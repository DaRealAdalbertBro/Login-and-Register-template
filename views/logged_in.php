<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SITE-NAME | PAGE-NAME</title>
    <meta name="description" content="SITE-NAME | PAGE-NAME">
    <meta name="url" content="https://SITE-NAME.com/">
    <meta name="image" content="images/IMAGE-NAME">
    <meta name="title" content="SITE-NAME">
    <meta property="description" content="SITE-NAME | PAGE-NAME">
    <meta property="url" content="https://SITE-NAME.com/">
    <meta property="image" content="images/IMAGE-NAME">
    <meta property="title" content="SITE-NAME">

    <meta name="og:description" content="SITE-NAME | PAGE-NAME">
    <meta name="og:url" content="https://SITE-NAME.com/">
    <meta name="og:image" content="images/IMAGE-NAME">
    <meta name="og:title" content="SITE-NAME">
    <meta property="og:description" content="SITE-NAME | PAGE-NAME">
    <meta property="og:url" content="https://SITE-NAME.com/">
    <meta property="og:image" content="images/IMAGE-NAME">
    <meta property="og:title" content="SITE-NAME">
    <link rel="icon" href="images/IMAGE-NAME">
    <link rel="stylesheet" href="./views/panel.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.6.0/dist/chart.min.js"></script>
    <script src="./cryptojs/crypto-js.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <link href="./views/fontawesome-free-5.15.4-web/css/all.css" rel="stylesheet">
</head>
<body>
    <!-- HTML -->
    <h3>LOGGED IN</h3>
    <br>
    <div>Username: <?php echo $_SESSION['user_name']; ?><div>
    <div>ID: <?php echo $_SESSION['user_id']; ?><div>
    <div>PL: <?php echo $_SESSION['PL']; ?><div>
</body>
</html>