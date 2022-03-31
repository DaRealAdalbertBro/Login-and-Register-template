<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


class Login {
    private $db_connection = null;

    public $errors = array();

    public $messages = array();

    public function __construct() {
        session_start();

        if(isset($_GET['logout'])) {
            $this->doLogout();
            
        } elseif(isset($_POST['login'])) {
            $this->processLogin();
        }
    }

    private function processLogin() {
        if(empty($_POST['username'])) {
            $this->errors[] = "Please, fill the username field!";

        } elseif(empty($_POST['password'])) {
            $this->$errors[] = "Please, fill the password field!";

        } elseif(!empty($_POST['username']) && !empty($_POST['password'])) {

            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            if(!$this->db_connection->set_charset('utf8mb4')) {
                $this->errors[] = $this->db_connection->error;
            }

            if(!$this->db_connection->connect_errno) {
                $username = $_POST['username'];
                $query = $this->db_connection->prepare("SELECT user_id, name, salt, hash, mail, PL, verified FROM users WHERE name = ? OR mail = ?");
                $query->bind_param('ss', $username, $username);
                $query->execute();
                $results = $query->get_result();

                if($results->num_rows == 1) {
                    $row = $results->fetch_object();
                    $saltedPass = $_POST['password'] . $row->salt;

                    if(password_verify($saltedPass, $row->hash)) {
                        $_SESSION['user_name'] = $row->name;
                        $_SESSION['user_id'] = $row->user_id;
                        $_SESSION['user_email'] = $row->mail;
                        $_SESSION['login_status'] = 1;
                        $_SESSION['PL'] = $row->PL; // permission level
                        $_SESSION['user_verified'] = $row->verified;

                    } else {
                        $this->errors[] = "Invalid credentials, try again.";
                    }
                } else {
                    $this->errors[] = "Invalid credentials, try again.";
                }
            } else {
                $this->errors[] = "Database connection problem.";
            }

        }
    }

    public function doLogout() {
        $_SESSION = array();
        session_destroy();
        $this->messages[] = "You have been logged out.";
    }

    public function isUserLoggedIn() {
        if(isset($_SESSION['login_status']) && $_SESSION['login_status'] == 1) {
            return true;
        }

        return false;
    }
}

?>