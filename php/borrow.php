<?php

    error_reporting(E_ALL);

    if (!isset($_COOKIE['username'])){
        echo 'Cannot borrow a book! You must register first!';
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

        //see if they already are borrowing this book
        $daborrowQuery = "SELECT COUNT(*) FROM borrows WHERE userid=? AND isbn=?;";
        $daborrowResult = $conn->prepare($daborrowQuery);
        $daborrowResult->bind_param("ss", $userId, $_POST['isbn']);
        $daborrowResult->execute() or die('Error!');
        $daborrowResult->bind_result($daborrowActualResult);
        $daborrowResult->fetch();
        $daborrowResult->close();

        if ($daborrowActualResult != 0){
            echo 'You already are borrowing a copy of this book!';
            return;
        }


        //got the user ID here, prepare the query to put it into borrows.$_COOKIE

        $borrowQuery = 'INSERT INTO borrows VALUES (?, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP + interval 14 day);';
        $borrowResult = $conn->prepare($borrowQuery);
        $borrowResult->bind_param("ss", $userId, $_POST['isbn']);
        $borrowResult->execute() or die('Error!');
        $borrowResult->bind_result($actualResult);
        $borrowResult->fetch();

        echo 'Action Successful!';

        $getUserIdResult->close();
        $borrowResult->close();

    }

?>