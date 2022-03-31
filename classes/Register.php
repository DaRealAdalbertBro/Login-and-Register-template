<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('idGenerationService.php');

class Registration {
    private $db_connection = null;

    public $errors = array();

    public $messages = array();

    private $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ$.';

    public function __construct() {
        if (isset($_POST["register"])) {
            $this->registerNewUser();
        }
    }

    private function registerNewUser() {
        if (empty($_POST['username'])) {
            $this->errors[] = "Invalid Username!";

        } elseif (strlen($_POST['username']) < 4) {
            $this->errors[] = "Username is too short!";

        } elseif (strlen($_POST['username']) > 64) {
            $this->errors[] = "Username is too long!";

        } elseif (filter_var($_POST['username'], FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Your username cannot be an email adress!";

        } elseif (empty($_POST['email'])) {
            $this->errors[] = "Please, fill the email field!";

        } elseif (strlen($_POST['email']) > 64) {
            $this->errors[] = "Email is too long!";

        } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Invalid e-mail format!";

        } elseif (empty($_POST['password_new']) || empty($_POST['password_repeat'])) {
            $this->errors[] = "Please, fill the password field!";

        } elseif (strlen($_POST['password_new']) < 8) {
            $this->errors[] = "Password is too short!";

        } elseif ($_POST['password_new'] !== $_POST['password_repeat']) {
            $this->errors[] = "The passwords don\'t match!";

        } elseif (!empty($_POST['username']) && strlen($_POST['username']) <= 64 && strlen($_POST['username']) >= 4 && !empty($_POST['email']) && strlen($_POST['email']) <= 64 && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && !empty($_POST['password_new']) && !empty($_POST['password_repeat']) && ($_POST['password_new'] === $_POST['password_repeat'])) {
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            if (!$this->db_connection->set_charset('utf8mb4')) {
                $this->errors[] = $this->db_connection->error;
            }

            if(!$this->db_connection->connect_errno) {
                $username = $_POST['username'];
                $useremail = $_POST['email'];
                $password = $_POST['password_new'];
                $options = [
                    'cost' => 10,
                ];
                $salt = $this->random_str(64);
                $salted_password = $password . $salt;
                $password_hash = password_hash($salted_password, PASSWORD_BCRYPT, $options);

                $query = $this->db_connection->prepare("SELECT name, mail FROM users WHERE name = ? OR mail = ?");
                $query->bind_param('ss', $username, $useremail);
                $query->execute();
                $results = $query->get_result();

                if($results->num_rows == 1) {
                    $row = $results->fetch_object();
                    
                    if($username == $row->name) {
                        $this->errors[] = "This username is already taken!";
                    } elseif($useremail == $row->mail) {
                        $this->errors[] = "This email address is already taken!";
                    } else {
                        $this->errors[] = "This username / email address is already taken.";
                    }
                } else {

                    $idService = new idGenerationService;
                    $userID = $idService->create();
                    // echo $userID;
                    // echo "<br>";
                    // echo $username;
                    // echo "<br>";
                    // echo $salt;
                    // echo "<br>";
                    // echo $password_hash;
                    // echo "<br>";
                    // echo $useremail;
                    // echo "<br>";

                    $sql = $this->db_connection->prepare("INSERT INTO users (user_id, name, salt, hash, mail) VALUES (?, ?, ?, ?, ?)");
                    $sql->bind_param("issss", $userID, $username, $salt, $password_hash, $useremail);
                    $sql->execute();
                    $dataR = $sql->affected_rows;

                    if($dataR > 0) {
                        $_SESSION['user_name'] = $username;
                        $_SESSION['user_id'] = $userID;
                        $_SESSION['user_email'] = $useremail;
                        $_SESSION['login_status'] = 1;
                        $_SESSION['PL'] = 0;
                        $_SESSION['user_verified'] = 0;

                        $this->db_connection->close();

                        require 'sendEmail.php';
                        $sendCode = new sendNewEmail();

                        if ($sendCode->errors) {
                            foreach ($sendCode->errors as $error) {
                                $this->errors[] = $error;
                                $_SESSION['verification_errors'] = $this->errors;
                            }
                        }
                        
                        if ($sendCode->messages) {
                            foreach ($sendCode->messages as $message) {
                                $this->messages[] = $message;
                                $_SESSION['verification_messages'] = $this->messages;
                            }
                        }

                        echo "<script type='text/javascript'>location.href = './verification';</script>";

                    } else {
                        $this->errors[] = "Sorry, your registration failed. Please go back and try again.";
                    }
                }
            } else {
                $this->errors[] = "Sorry, no database connection.";
            }
        } else {
            $this->errors[] = "An unknown error occurred.";
        }
    }

    private function random_str($length): string {
        if ($length < 1) {
            throw new \RangeException("Length must be a positive integer");
        }
        $pieces = [];
        $max = mb_strlen($this->keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces []= $this->keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }

}

?>