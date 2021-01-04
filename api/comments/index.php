<?php

  // Set default timezone
date_default_timezone_set('UTC');

try {
    /**************************************
    * Create databases and                *
    * open connections                    *
    **************************************/

    // Create (connect to) SQLite database in file
    $file_db = new PDO('sqlite:comments.sqlite3');
    // Set errormode to exceptions
    $file_db->setAttribute(PDO::ATTR_ERRMODE, 
      PDO::ERRMODE_EXCEPTION);



    /**************************************
    * Create tables                       *
    **************************************/

    // Create table messages
    $file_db->exec("CREATE TABLE IF NOT EXISTS comments (
      id INTEGER PRIMARY KEY,
      username TEXT,
      email TEXT,
      comment TEXT,
      show INTEGER,
      ip_address TEXT,
      forwarded_address TEXT, 
      time TEXT)");

    




    /**************************************
    * Parse POST data                     *
    **************************************/

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      $post_data = [];
      $error = "";

      $post = json_decode(file_get_contents("php://input"),true);

      echo json_encode($post);


      if (isset($post)) {
      // var_dump($post);

        if (isset($_SERVER['REMOTE_ADDR'])) {
          $post_data["ip"] = filter_var(trim($_SERVER['REMOTE_ADDR']), FILTER_SANITIZE_STRING);
        }

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
          $post_data["forwarded_address"] = filter_var(trim($_SERVER['HTTP_X_FORWARDED_FOR']), FILTER_SANITIZE_STRING);
        }

        if (isset($post["username"]) && !empty($post["username"])) {
          $post_data["username"] = htmlspecialchars(trim($post["username"]));
        } else {
          $error .= "A name is required.\n";
        }

        if (isset($post["comment"]) && !empty($post["comment"])) {
          $post_data["comment"] = htmlspecialchars(trim($post["comment"]));
        } else {
          $error .= "A comment is required.\n";
        }

        if (isset($post["email"])) {
          $post_data["email"] = filter_var(trim($post["email"]), FILTER_SANITIZE_EMAIL);
        }

        // if (isset($_POST["parent_id"]) && !empty($_POST["parent_id"])) {
        //   $post_data["parent_id"] = $_POST["parent_id"];
        // } else {
        //   $post_data["parent_id"] = 0;
        // }

        $date = new DateTime();
        $post_data["timestamp"] = date('Y/m/d H:i:s', $date->getTimestamp());

        $post_data["show"] = 0;

      }

      // if (!empty($error)) {
      //   echo $error;
      //   exit();
      // }



      // $post_data["hello"] = "Hello!";

      // echo json_encode($post_data);


      /**************************************
      * Insert new comment                  *
      **************************************/

      if (empty($error)) {
      // Prepare INSERT statement to SQLite3 file db
        $insert = "INSERT INTO comments (username, email, comment, show, ip_address, forwarded_address, time) 
        VALUES (:username, :email, :comment, :show, :ip_address, :forwarded_address, :time)";
        $stmt = $file_db->prepare($insert);

      // Bind parameters to statement variables
        $stmt->bindParam(':username', $post_data["username"]);
        $stmt->bindParam(':email', $post_data["email"]);
        $stmt->bindParam(':comment', $post_data["comment"]);
        $stmt->bindParam(':show', $post_data["show"]);
        $stmt->bindParam(':ip_address', $post_data["ip"]);
        $stmt->bindParam(':forwarded_address', $post_data["forwarded_address"]);
        $stmt->bindParam(':time', $post_data["timestamp"]);

        $stmt->execute();
      }

    }




    /**************************************
    * Get comments                        *
    **************************************/

    $result = [];

    $sql = "SELECT id, username, comment, time FROM comments WHERE show = 1";

    $stmt = $file_db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


    echo json_encode($result);

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