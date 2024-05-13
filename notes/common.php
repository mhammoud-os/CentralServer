<?php

/**********  ERROR REPORTING  **********/
// development
error_reporting(E_ALL);
ini_set('log_errors', 1);

// production
//error_reporting(0); ini_set('display_errors','0');
#ini_set('display_errors', 0);
#ini_set('log_errors', 1);
#error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Same as error_reporting(E_ALL);
//ini_set('error_reporting', E_ALL);

//And to print a message to the error log: which for web apps is /var/log/apach2/error.log
#error_log("There is something wrong!", 0);

//require_once '/home/.config.php';

/**********  SESSION VARIABLES  **********/
$username=$fullname="";

if (isset($_SESSION["username"])) {
	$username = $_SESSION["username"];
}

if (isset($_SESSION["fullname"])) {
	$fullname = $_SESSION["fullname"];
}


/**********  COMMON FUNCTIONS  **********/

function connectToDB() {
    $db = mysqli_connect("localhost", "user", "password", "main");
    if ($db->connect_errno) {
        echo "<script>";
        echo 'alert("Error connecting to database '.$database.'. Your connection has probably timed out. Please log in again");';
        echo "window.location='index.php';";
        echo "</script>";
        // header("Location: index.php");
#       echo "Failed to connect to MySQL database $database : " . mysqli_connect_error();
#       die("Program terminated");
    }
    //mysqli_query($db, "set names UTF8;");
    return $db;
}

// This is a legacy function.
// ONly use this for queries that do not use any variables. Otherwise SQL injection attacks can happen.
function runSimpleQuery($mysqli, $sql_) {
    $result = mysqli_query($mysqli, $sql_);
//  if (!$mysqli->error) {
//      printf("Errormessage: %s\n", $mysqli->error);
//  }

    // Check result. This shows the actual query sent to MySQL, and the error. Useful for debugging.
    if (!$result) {
       $message_  = 'Invalid query: ' . mysqli_error($mysqli) . "\n<br>";
       $message_ .= 'SQL: ' . $sql_;
       die($message_);
    }
    return $result;
}

function clean_html($string) {
    $string = trim(htmlspecialchars(addslashes($string)));
    #$string = trim(htmlentities(addslashes($string)));
    return $string;
}

function clean_input($string) {
    $string = trim(strip_tags(addslashes($string)));
    return $string;
}
