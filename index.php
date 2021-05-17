<?php

// This is my controller for the midterm survey

// Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// start a session
session_start();

// Require autoload file
require_once('vendor/autoload.php');

// instantiate fat-free
$f3 = Base::instance();

// define routes
$f3->route('GET /', function(){

    // Display the home page
    $view = new Template(); // instantiate view object
    echo $view->render('views/survey.html'); // using view object to display the view page

});

$f3->route('GET /short-survey', function(){

    // Display the short-survey page
    $view = new Template();
    echo $view->render('views/short-survey.html');

});

// run fat-free
$f3->run();