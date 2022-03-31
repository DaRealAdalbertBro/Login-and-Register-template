<?php

class VerifyEmail {

    private $db_connection = null;

    public $errors = array();

    public $messages = array();

    public function __construct() {

        if(isset($_POST['verificationCode'])) {
            $this->startVerifying();
        } else {
            if(isset($_SESSION['user_email'])) {
                $this->messages[] = "We\'ve sent a verification code to your email - " . $_SESSION['user_email'];
                
            } else {
                $this->errors[] = "Something went wrong in the process of getting your e-mail... Please re-log to your account!";
            }
        }
    }

    private function startVerifying() {

        if(strlen($_POST['verCode']) !== 6) {
            $this->errors[] = "The entered verification code is invalid!";

        } elseif(!empty($_POST['verCode']) && strlen($_POST['verCode']) === 6) {
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            if(!$this->db_connection->set_charset("utf8mb4")) {
                $this->errors[] = $this->db_connection->error;
            }

            if(!$this->db_connection->connect_errno) {
                if(isset($_SESSION['user_id'])) {
                    $userID = $_SESSION['user_id'];
                    $enteredCode = $_POST['verCode'];
                    $query = $this->db_connection->prepare("SELECT verification_code FROM users WHERE user_id = ?");
                    $query->bind_param('i', $userID);
                    $query->execute();
                    $results = $query->get_result();

                    if($results->num_rows == 1) {
                        $row = $results->fetch_object();

                        if($enteredCode == $row->verification_code) {
                            $this->messages[] = "Correct!";
                            $query2 = $this->db_connection->prepare("UPDATE users SET verified = ? WHERE user_id = ?");
                            $verifyState = 1;
                            $query2->bind_param('ii', $verifyState, $userID);
                            $query2->execute();
                            $_SESSION['user_verified'] = $verifyState;

                            // DO WHATEVER YOU WANT

                        } else {
                            $this->errors[] = "The entered verification code is invalid!";
                            $_SESSION['user_verified'] = 1;
                        }

                    } else {
                        $this->errors[] = "An unknown error occurred.";

                    }

                } else {
                    $this->errors[] = "Something went wrong in the process of getting your ID... Please re-log to your account!";
                }

            } else {
                $this->errors[] = "Sorry, no database connection.";
            }

            $this->db_connection->close();

        } else {
            if(isset($_SESSION['user_email'])) {
                $this->messages[] = "We\'ve sent a verification code to your email - " . $_SESSION['user_email'];
            } else {
                $this->errors[] = "Something went wrong in the process of getting your e-mail... Please re-log to your account!";
            }
        }
        
    }
}

?>