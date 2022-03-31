<?php
// SHOWS ALL ERRORS
error_reporting(E_ALL);
ini_set('display_errors', 1);

// CHECKS VERSION COMPATIBILITY
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    require_once("libraries/password_compatibility_library.php");
}

require_once("config/conf.php");
require_once("classes/Login.php");

$login = new Login();

if ($login->isUserLoggedIn() == true) {
    if(isset($_SESSION['user_verified']) && $_SESSION['user_verified'] == 0) {
        require_once('classes/VerifyEmail.php');
        $verify = new VerifyEmail();
?>

<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>PAGENAME - Verification</title>
            <style>:root {
                    --backgroundGradient: radial-gradient(#653d84, #332042);
                    --loginBoxBackground: #fff;
                    --topLinkAtextColor: #452A5A;
                    --topLinkAarrow: url(images/left.svg) no-repeat center;
                    --inputBackgroundColor: transparent;
                    --inputUnderlineNormalColor: #4f30677d;
                    --inputUnderlineHoverColor: #7B3EDE;
                    --leftBoxBackgroundColor: linear-gradient(-45deg, #dcd7e0, #fff);
                    --messageAndErrorColor: #f8d7db;
                    --messageAndErrorBorderColor: rgba(149, 107, 106, 0.5);
                    --messageAndErrorTextColor: #735150;
                    --submitButtonBackgroundColor: rgba(88, 54, 114, 1);
                    --submitButtonTextColor: #fff;
                    --submitButtonHoverBackgroundColor: #8D56B8;
                    --rightBoxImage: url(images/example.jpg);
                    --rightBoxBackgroundColor: #fff;

                } * {margin: 0;padding: 0;box-sizing: border-box;}html {overflow: hidden;scroll-behavior: smooth;}body {display: block;justify-content: center;align-items: center;}img{width: 100%;}.login {height: 100vh;width: 100%;background: var(--backgroundGradient);position: relative;}.login_box {max-width: 1050px;width: auto;height: 600px;position: relative;top: 50%;left: 50%;transform: translate(-50%,-50%);background: var(--loginBoxBackground);border-radius: 10px;box-shadow: 1px 4px 22px -8px #0004;display: flex;overflow: hidden;}.login_box .left{width: 41%;min-width: 22em;height: 100%;padding: 25px 25px;}.login_box .right{width: 59%;height: 100%}.left .top_link a {color: var(--topLinkAtextColor);font-weight: 400;}.left .top_link{height: 20px}.left .contact{display: flex;align-items: center;justify-content: center;align-self: center;height: 100%;width: 73%;margin: auto;}.left h3{text-align: center;margin-bottom: 14px;}.left input[type="text"],.left input[type="password"] {border: none;width: 80%;margin: 12px 0px;text-align:center;border-bottom: 1px solid var(--inputUnderlineNormalColor);padding: 7px 9px;width: 100%;overflow: hidden;background: var(--inputBackgroundColor);font-weight: 600;font-size: 24px;transition: 0.2s;}.left input[type="text"]:focus,.left input[type="password"]:focus {outline: none;border-bottom: 1px solid var(--inputUnderlineHoverColor);}.left{background: var(--leftBoxBackgroundColor)}#error {position: relative;display: block;font-weight:400;text-align:center;font-size: 14px;margin-bottom: 8px;color: var(--messageAndErrorTextColor);background: var(--messageAndErrorColor);border: var(--messageAndErrorBorderColor) 1px solid;border-radius:4px;padding: 12px 12px 12px 12px;height:auto;transition: 0.1s;}.submit {border: none;padding: 15px 70px;border-radius: 8px;display: block;margin: auto;margin-top: 40px;background: var(--submitButtonBackgroundColor);color: var(--submitButtonTextColor);font-weight: bold;-webkit-box-shadow: 0px 9px 15px -11px var(--submitButtonBackgroundColor);-moz-box-shadow: 0px 9px 15px -11px var(--submitButtonBackgroundColor);box-shadow: 0px 9px 15px -11px var(--submitButtonBackgroundColor);transition: 0.3s;outline: none;}button:hover, button:focus {outline: none;}.submit:hover {background: var(--submitButtonHoverBackgroundColor);}.right {background: var(--rightBoxImage);color: #fff;position: relative;}.right .right-text{height: 100%;position: relative;transform: translate(0%, 45%);}.right-text h2{display: block;width: 100%;text-align: center;font-size: 50px;font-weight: 500;}.right-text h5{display: block;width: 100%;text-align: center;font-size: 19px;font-weight: 400;}.top_link img {width: 28px;transform: scale(1.3);padding-right: 7px;margin-right:4px;margin-top: -3px;background-color: var(--topLinkAtextColor);-webkit-mask: var(--topLinkAarrow);mask: var(--topLinkAarrow)}@media (max-width:1052px) {.login_box .right {display: none;}.login_box {width: 22em;}}.forgotpass {color: var(--topLinkAtextColor);position: relative;text-align: center;margin-top: 8px;font-size: 14px;cursor: pointer;}.forgotpass:hover {text-decoration: underline;}
            </style>

            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
            integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z"
            crossorigin="anonymous">

        </head>
        <body>
            <section class="login">
                <div class="login_box">
                    <div class="left">
                        <div class="top_link"><a href="?logout"><img src="https://drive.google.com/u/0/uc?id=16U__U5dJdaTfNGobB_OpwAJ73vM50rPV&export=download" alt="">Return</a></div>
                        <div class="contact">
                            <form method="post" action="login" name="verificationform">
                                <h3>VERIFY YOUR E-MAIL</h3>
                                <div id="error"></div>
                                <input type="text" placeholder="000 000" name="verCode" autocomplete="off" maxlength="6" minlength="6" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" require>
                                <input class="submit" type="submit" name="verificationCode" value="SUBMIT"></input>
                            </form>
                        </div>
                    </div>
                    <div class="right"></div>
                </div>
            </section>
        </body>
    </html>
<?php
 if (isset($verify)) {
    if ($verify->errors) {
        foreach ($verify->errors as $error) {
            echo "<script>const f = document.getElementById('error');f.style.display = 'block';f.style.backgroundColor = '#f8d7db';f.style.color='#735150';f.style.border='rgba(149, 107, 106, 0.5) 1px solid';f.style.display = 'block';f.innerText = '" . $error . "';</script>";
        }
    }
    if ($verify->messages) {
        foreach ($verify->messages as $message) {
            echo "<script>const e = document.getElementById('error');e.style.display = 'block';e.style.backgroundColor = '#d5eddb';e.style.color='#668a64';e.style.border='#668a64 1px solid';e.innerText = '" . $message . "';</script>";
        }
    }
}
    } else {
        require_once('views/logged_in.php');
    }
} else {
?>
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>PAGENAME - Sign in</title>
            <style>:root {
                    --backgroundGradient: radial-gradient(#653d84, #332042);
                    --loginBoxBackground: #fff;
                    --topLinkAtextColor: #452A5A;
                    --topLinkAarrow: url(images/left.svg) no-repeat center;
                    --inputBackgroundColor: transparent;
                    --inputUnderlineNormalColor: #4f30677d;
                    --inputUnderlineHoverColor: #7B3EDE;
                    --leftBoxBackgroundColor: linear-gradient(-45deg, #dcd7e0, #fff);
                    --messageAndErrorColor: #f8d7db;
                    --messageAndErrorBorderColor: rgba(149, 107, 106, 0.5);
                    --messageAndErrorTextColor: #735150;
                    --submitButtonBackgroundColor: rgba(88, 54, 114, 1);
                    --submitButtonTextColor: #fff;
                    --submitButtonHoverBackgroundColor: #8D56B8;
                    --rightBoxImage: url(images/example.jpg);
                    --rightBoxBackgroundColor: #fff;

                } * {margin: 0;padding: 0;box-sizing: border-box;}html {overflow: hidden;scroll-behavior: smooth;}body {display: block;justify-content: center;align-items: center;}img{width: 100%;}.login {height: 100vh;width: 100%;background: var(--backgroundGradient);position: relative;}.login_box {max-width: 1050px;width: auto;height: 600px;position: relative;top: 50%;left: 50%;transform: translate(-50%,-50%);background: var(--loginBoxBackground);border-radius: 10px;box-shadow: 1px 4px 22px -8px #0004;display: flex;overflow: hidden;}.login_box .left{width: 41%;min-width: 22em;height: 100%;padding: 25px 25px;}.login_box .right{width: 59%;height: 100%}.left .top_link a {color: var(--topLinkAtextColor);font-weight: 400;}.left .top_link{height: 20px}.left .contact{display: flex;align-items: center;justify-content: center;align-self: center;height: 100%;width: 73%;margin: auto;}.left h3{text-align: center;margin-bottom: 14px;}.left input[type="text"],.left input[type="password"] {border: none;width: 80%;margin: 12px 0px;border-bottom: 1px solid var(--inputUnderlineNormalColor);padding: 7px 9px;width: 100%;overflow: hidden;background: var(--inputBackgroundColor);font-weight: 600;font-size: 14px;transition: 0.2s;}.left input[type="text"]:focus,.left input[type="password"]:focus {outline: none;border-bottom: 1px solid var(--inputUnderlineHoverColor);}.left{background: var(--leftBoxBackgroundColor)}#error {position: relative;display: none;font-weight:400;text-align:center;font-size: 14px;margin-bottom: 8px;color: var(--messageAndErrorTextColor);background: var(--messageAndErrorColor);border: var(--messageAndErrorBorderColor) 1px solid;border-radius:4px;padding: 12px 12px 12px 12px;height:auto;transition: 0.1s;}.submit {border: none;padding: 15px 70px;border-radius: 8px;display: block;margin: auto;margin-top: 40px;background: var(--submitButtonBackgroundColor);color: var(--submitButtonTextColor);font-weight: bold;-webkit-box-shadow: 0px 9px 15px -11px var(--submitButtonBackgroundColor);-moz-box-shadow: 0px 9px 15px -11px var(--submitButtonBackgroundColor);box-shadow: 0px 9px 15px -11px var(--submitButtonBackgroundColor);transition: 0.3s;outline: none;}button:hover, button:focus {outline: none;}.submit:hover {background: var(--submitButtonHoverBackgroundColor);}.right {background: var(--rightBoxImage);color: #fff;position: relative;}.right .right-text{height: 100%;position: relative;transform: translate(0%, 45%);}.right-text h2{display: block;width: 100%;text-align: center;font-size: 50px;font-weight: 500;}.right-text h5{display: block;width: 100%;text-align: center;font-size: 19px;font-weight: 400;}.top_link img {width: 28px;transform: scale(1.3);padding-right: 7px;margin-right:4px;margin-top: -3px;background-color: var(--topLinkAtextColor);-webkit-mask: var(--topLinkAarrow);mask: var(--topLinkAarrow)}@media (max-width:1052px) {.login_box .right {display: none;}.login_box {width: 22em;}}.forgotpass {color: var(--topLinkAtextColor);position: relative;text-align: center;margin-top: 8px;font-size: 14px;cursor: pointer;}.forgotpass:hover {text-decoration: underline;}
            </style>

            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
            integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z"
            crossorigin="anonymous">

        </head>
        <body>
            <section class="login">
                <div class="login_box">
                    <div class="left">
                        <div class="top_link"><a href="#"><img src="https://drive.google.com/u/0/uc?id=16U__U5dJdaTfNGobB_OpwAJ73vM50rPV&export=download" alt="">Return home</a></div>
                        <div class="contact">
                            <form method="post" action="login" name="loginform">
                                <h3>SIGN IN</h3>
                                <div id="error">⠀</div>
                                <input type="text" placeholder="E-MAIL / USERNAME" name="username">
                                <input type="password" placeholder="PASSWORD" name="password" autocomplete="off">
                                <input class="submit" type="submit" name="login" value="LOG IN"></input>
                                <div class="forgotpass">Forgot Password?</div>
                            </form>
                        </div>
                    </div>
                    <div class="right"></div>
                </div>
            </section>
        </body>
    </html>

<?php
    // show potential errors / feedback (from login object)
    if (isset($login)) {
        if ($login->errors) {
            foreach ($login->errors as $error) {
                echo "<script>const f = document.getElementById('error');f.style.display = 'block';f.style.backgroundColor = '#f8d7db';f.style.color='#735150';f.style.border='rgba(149, 107, 106, 0.5) 1px solid';f.style.display = 'block';f.innerText = '" . $error . "';</script>";
            }
        }
        if ($login->messages) {
            foreach ($login->messages as $message) {
                echo "<script>const e = document.getElementById('error');e.style.display = 'block';e.style.backgroundColor = '#d5eddb';e.style.color='#668a64';e.style.border='#668a64 1px solid';e.innerText = '" . $message . "';</script>";
            }
        }
    }
}
?>