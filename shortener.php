<?php
include 'core/core_functions.php';
use Functions as Functions;

if((new Functions)->CheckPostRequest() == false){
    print_r("No URL specified: ");
    print_r("<a href='index.php'><button>Go Back</button></a>");
    exit();
}

$url = trim($_POST['url']);
if((new Functions)->CheckIfWebUrlExists($url) == true){
    $shortCode = (new Functions)->RetrieveShortUrl($url);
    print_r("URL already exists:");
    print_r("<a href='./$shortCode'>$shortCode</a> ");
    print_r("<a href='index.php'><button>Go Back</button></a>");
    exit();
}

(new Functions)->ValidateURL($url) ? 0 : exit();
$shortCode = (new Functions)->CreateShortCode();

$line = $shortCode . '|' . $url . PHP_EOL;
(new Functions)->SaveUrlToDatabase($shortCode, $url);

// Provide the short URL to the user
print_r("Shortened URL: <a href='./$shortCode'>$shortCode</a> ");
print_r("<a href='index.php'><button>Go Back</button></a>");