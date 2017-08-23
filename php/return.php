<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if (!isset($_COOKIE['username'])){
        echo 'You shouldn\'t be doin that..';
        return;
    }

    if (isset($_POST['isbn'])){

        $conn = new mysqli(localhost, 'drozdowo', '<snip>', 'drozdowo_db');
        if ($conn->connect_error) die($conn->connect_error);

        //check if they already are borrowing this book
        //get their user id:
        $getUserIdResult = $conn->prepare("SELECT userid FROM users WHERE username=?;");
        $getUserIdResult->bind_param("s", $_COOKIE['username']);
        $getUserIdResult->execute();
        $getUserIdResult->bind_result($userId);
        $getUserIdResult->fetch();
        $getUserIdResult->close();

        if (is_null($userId)){
            echo 'whoa bro u tryin to break my stuff';
            return;
        }

        $returnBook = $conn->prepare("DELETE FROM borrows WHERE userid=? AND isbn=?;");
        $returnBook->bind_param("ss", $userId, $_POST['isbn']);
        $returnBook->execute();
        $returnBook->bind_result($returnRes);
        $returnBook->fetch();
        $returnBook->close();

        echo $returnRes;


    } else {
        echo 'Failed to provide ISBN?';
    }

?>