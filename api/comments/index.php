<?php

  // Set default timezone
date_default_timezone_set('UTC');

try {
    /**************************************
    * Create databases and                *
    * open connections                    *
    **************************************/

    // Create (connect to) SQLite database in file
    $file_db = new PDO('sqlite:messaging.sqlite3');
    // Set errormode to exceptions
    $file_db->setAttribute(PDO::ATTR_ERRMODE, 
      PDO::ERRMODE_EXCEPTION);



    /**************************************
    * Create tables                       *
    **************************************/

    // Create table messages
    // $file_db->exec("CREATE TABLE IF NOT EXISTS comments (
    //                 id INTEGER PRIMARY KEY, 
    //                 comment TEXT, 
    //                 -- message TEXT, 
    //                 time INTEGER)");

    $result = [];
    // $test = "hello";

    $ip_address = "";
    $forwarded_address = "";

    $_POST = json_decode(file_get_contents("php://input"),true);


    if (isset($_POST)) {
      // var_dump($_POST);

      if (isset($_SERVER['REMOTE_ADDR'])) {
        $result["ip"] = $_SERVER['REMOTE_ADDR'];
      }

      if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $forwarded_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
      }

      if (isset($_POST["username"])) {
        $result["username"] = $_POST["username"];
      }

      if (isset($_POST["comment"])) {
        $result["comment"] = $_POST["comment"];
      }
      

      $date = new DateTime();
      $result["timestamp"] = $date->getTimestamp();

    }

    // $result["greeting"] = "Hello!";

    echo json_encode($result);



    /**************************************
    * Set initial data                    *
    **************************************/

    // Array with some test data to insert to database             
    // $messages = array(
    //               array('title' => 'Hello!',
    //                     'message' => 'Just testing...',
    //                     'time' => 1327301464),
    //               array('title' => 'Hello again!',
    //                     'message' => 'More testing...',
    //                     'time' => 1339428612),
    //               array('title' => 'Hi!',
    //                     'message' => 'SQLite3 is cool...',
    //                     'time' => 1327214268)
    //             );






    /**************************************
    * Close db connections                *
    **************************************/

    // Close file db connection
    $file_db = null;
  }
  catch(PDOException $e) {
    // Print PDOException message
    echo $e->getMessage();
  }
  ?>