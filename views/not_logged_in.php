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
            --messageAndErrorColor: #E33C39;
            --submitButtonBackgroundColor: rgba(88,54,114,1);
            --submitButtonTextColor: #fff;
            --submitButtonHoverBackgroundColor: #8D56B8;
            --rightBoxImage: url(images/example.jpg);
            --rightBoxBackgroundColor: #fff;

        } * {margin: 0;padding: 0;box-sizing: border-box;}html {overflow: hidden;scroll-behavior: smooth;}body {display: block;justify-content: center;align-items: center;}img{width: 100%;}.login {height: 100vh;width: 100%;background: var(--backgroundGradient);position: relative;}.login_box {max-width: 1050px;width: auto;height: 600px;position: relative;top: 50%;left: 50%;transform: translate(-50%,-50%);background: var(--loginBoxBackground);border-radius: 10px;box-shadow: 1px 4px 22px -8px #0004;display: flex;overflow: hidden;}.login_box .left{width: 41%;min-width: 22em;height: 100%;padding: 25px 25px;}.login_box .right{width: 59%;height: 100%}.left .top_link a {color: var(--topLinkAtextColor);font-weight: 400;}.left .top_link{height: 20px}.left .contact{display: flex;align-items: center;justify-content: center;align-self: center;height: 100%;width: 73%;margin: auto;}.left h3{text-align: center;margin-bottom: 40px;}.left input[type="text"],.left input[type="password"] {border: none;width: 80%;margin: 12px 0px;border-bottom: 1px solid var(--inputUnderlineNormalColor);padding: 7px 9px;width: 100%;overflow: hidden;background: var(--inputBackgroundColor);font-weight: 600;font-size: 14px;transition: 0.2s;}.left input[type="text"]:focus,.left input[type="password"]:focus {outline: none;border-bottom: 1px solid var(--inputUnderlineHoverColor);}.left{background: var(--leftBoxBackgroundColor)}#error {position: absolute;user-select: none;display: none;font-size: 14px;margin-top: 8px;color: var(--messageAndErrorColor);transition: 0.1s;}.submit {border: none;padding: 15px 70px;border-radius: 8px;display: block;margin: auto;margin-top: 120px;background: var(--submitButtonBackgroundColor);color: var(--submitButtonTextColor);font-weight: bold;-webkit-box-shadow: 0px 9px 15px -11px var(--submitButtonBackgroundColor);-moz-box-shadow: 0px 9px 15px -11px var(--submitButtonBackgroundColor);box-shadow: 0px 9px 15px -11px var(--submitButtonBackgroundColor);transition: 0.3s;outline: none;}button:hover, button:focus {outline: none;}.submit:hover {background: var(--submitButtonHoverBackgroundColor);}.right {background: var(--rightBoxImage);color: #fff;position: relative;}.right .right-text{height: 100%;position: relative;transform: translate(0%, 45%);}.right-text h2{display: block;width: 100%;text-align: center;font-size: 50px;font-weight: 500;}.right-text h5{display: block;width: 100%;text-align: center;font-size: 19px;font-weight: 400;}.top_link img {width: 28px;transform: scale(1.3);padding-right: 7px;margin-right:4px;margin-top: -3px;background-color: var(--topLinkAtextColor);-webkit-mask: var(--topLinkAarrow);mask: var(--topLinkAarrow)}@media (max-width:1052px) {.login_box .right {display: none;}.login_box {width: 22em;}}.forgotpass {color: var(--topLinkAtextColor);position: relative;text-align: center;margin-top: 8px;font-size: 14px;cursor: pointer;}.forgotpass:hover {text-decoration: underline;}
    </style>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z"
    crossorigin="anonymous">

</head>
<body>
<body>
	<section class="login">
		<div class="login_box">
			<div class="left">
				<div class="top_link"><a href="#"><img src="https://drive.google.com/u/0/uc?id=16U__U5dJdaTfNGobB_OpwAJ73vM50rPV&export=download" alt="">Return home</a></div>
				<div class="contact">
					<form method="post" action="login" name="loginform">
						<h3>SIGN IN</h3>
						<input type="text" placeholder="USERNAME" name="username" required>
						<input type="password" placeholder="PASSWORD" name="password" autocomplete="off" required >
                        <div id="error">⠀</div>
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
</body>
</html>

<?php
// show potential errors / feedback (from login object)
if (isset($login)) {
    if ($login->errors) {
        foreach ($login->errors as $error) {
            echo "<script>const d = document.getElementById('error');d.style.display = 'block';d.innerText = '" . $error . "';</script>";
        }
    }
    if ($login->messages) {
        foreach ($login->messages as $message) {
            echo "<script>const e = document.getElementById('error');e.style.display = 'block';e.innerText = '" . $message . "';</script>";
        }
    }
}
?>