<?php

require __DIR__ . "/../../vendor/autoload.php";
//need to go into the MOVIE-REST-APP root for this Dotenv instance to find the dotenv vendor

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../', 'client.env');
$dotenv->load();
$dotenv->required([
    'CLIENT_URI',
    'POSTER_PATH'
])->notEmpty();

// Define the directory containing poster images
$dir = __DIR__ . '/../' . $_ENV['POSTER_PATH'];

// Get an array of image files
$images = array_diff(scandir($dir), array('.', '..')); // Exclude . and ..

// Create an array of full URLs
$imageURLs = array_values(array_map(function ($image) {
    return $_ENV['CLIENT_URI'] . $_ENV['POSTER_PATH'] . $image;
}, $images));

// Output as JSON for easy use in JavaScript
header('Content-Type: application/json');
echo json_encode($imageURLs, JSON_PRETTY_PRINT);
