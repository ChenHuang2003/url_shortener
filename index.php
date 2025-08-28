<!DOCTYPE html>
<html>
<head>
    <title>URL Shortener</title>
</head>
<body>
    <h2>Shorten Your URL</h2>
    <form action="shortener.php" method="POST">
        <label for="url">Enter URL:</label>
        <input type="url" name="url" required>
        <button type="submit">Shorten</button>
    </form>
</body>
<br/><br/>
</html>

<?php
include 'core/core_functions.php';
use Functions as Functions;

if(isset($_GET['redirect'])){
    var_dump($_GET['redirect']);
    (new Functions)->RedirectToUrl($_GET['redirect']);
}

(new Functions)->DisplayUrls();
?>