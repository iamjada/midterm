<?php
// This is my controller for the midterm survey

// Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// start a session
session_start();

// Require autoload file
require_once('vendor/autoload.php');
require_once ('model/data-layer.php');
require_once ('model/validation.php');

// instantiate fat-free
$f3 = Base::instance();

// define routes
$f3->route('GET /', function(){

    // Display the survey home page
    $view = new Template(); // instantiate view object
    echo $view->render('views/survey.html'); // using view object to display the view page

});

$f3->route('GET|POST /short-survey', function($f3){

    //Initialize variables for user input
    $_SESSION = array();

    // Initalize for session array
    //$userName = "";
    //$userChoice = array();

    //If the form has been submitted, validate the data
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //var_dump($_POST);

        //validate name
        if (validName($_POST['name'])) {
            $_SESSION['name'] = $_POST['name'];
        } //Otherwise, set an error variable in the hive
        else {
            $f3->set('errors["name"]', 'Please enter a Name');
        }

        // validate choices
        if (!empty($_POST['choices'])) {

            //If choices are valid
            if (validChoices($_POST['choices']) && isset($_POST['choices'])) {
                $_SESSION['choices'] = implode(", ", $_POST['choices']);
            }
            else {
                $f3->set('errors["choices"]', 'Invalid selection');
            }
        }else{
            $f3->set('errors["choices"]', 'Please select one or more checkboxes');
        }
        //If the error array is empty, redirect to summary page
        if (empty($f3->get('errors'))) {
            header('location: summary');
        }
    }

    //Get the data from the Model and send them to the View
    $f3->set('choices', getChoices());

    //Add/store the user data to the hive
    //$f3->set('name', $userName);
    //$f3->set('userChoice', $userChoice);

    // Display the short-survey page
    $view = new Template();
    echo $view->render('views/short-survey.html');
});

// Summary page
$f3->route('GET /summary', function(){

    // Display the summary page
    $view = new Template();
    echo $view->render('views/summary.html');

});

// run fat-free
$f3->run();