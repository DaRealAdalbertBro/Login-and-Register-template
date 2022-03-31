<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

unset($_SESSION['verification_messages']);
unset($_SESSION['verification_errors']);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once './libraries/PHPMailer/vendor/autoload.php';

require_once './libraries/PHPMailer/vendor/phpmailer/phpmailer/src/Exception.php';
require_once './libraries/PHPMailer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once './libraries/PHPMailer/vendor/phpmailer/phpmailer/src/SMTP.php';

class sendNewEmail {

    private $db_connection = null;

    public $errors = array();

    public $messages = array();

    public function __construct() {
        $this->sendEmail($_SESSION['user_email'], $_SESSION['user_name']);
    }

    private function sendEmail($email, $name) {

        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if(!$this->db_connection->set_charset("utf8mb4")) {
            $this->errors[] = $this->db_connection->error;
        }

        if(!$this->db_connection->connect_errno) {
            $mail = new PHPMailer(true);

            //Send using SMTP
            $mail->isSMTP();

            //Set the SMTP server to send through
            $mail->Host = 'HOST';

            //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            $mail->Port = 587;

            //Enable SMTP authentication
            $mail->SMTPAuth = true;
            
            //Enable TLS encryption;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

            //SMTP username
            $mail->Username = 'REGISTERED EMAIL';

            //SMTP password
            $mail->Password = 'PASSWORD';

            //Recipients
            $mail->setFrom('EMAIL', 'Verification - No-Reply');

            //Add a recipient
            $mail->addAddress($email, $name);

            //Set email format to HTML
            $mail->isHTML(true);

            $verCode = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

            $mail->Subject = 'Email verification';
            $mail->Body    = '<p>Your verification code is: <b style="font-size: 30px;">' . $verCode . '</b></p>';
            
            $userID = $_SESSION['user_id'];

            $query2 = $this->db_connection->prepare("UPDATE users SET verification_code = ? WHERE user_id = ?");
            $query2->bind_param('ii', $verCode, $userID);
            $query2->execute();
            $results2 = $query2->affected_rows;

            if($results2 > 0) {
                try {
                    $mail->send();
                    $this->messages[] = "Verification code has been sent to your email.";

                } catch(Exception $e) {
                        $this->errors[] = "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }

            } else {
                $this->errors[] = "An unknown error occurred while inserting data into the database.";
            }

            $this->db_connection->close();

        } else {
            $this->errors[] = "Sorry, no database connection.";
        }
    }
}

?>