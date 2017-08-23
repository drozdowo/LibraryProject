<?php

    if (isset($_COOKIE['username'])){
        echo 'you already logged in bro';
        return;
    }

    if (isset($_POST['username']) && $_POST['password']){

    if (strlen($_POST['username']) < 6) {
        echo 'Username not long enough! <br>';
    }

    if (strlen($_POST['password']) < 6){
        echo 'Password not long enough! <br>';
    }

    if (strlen($_POST['password']) > 5 && strlen($_POST['username']) > 5){

        $conn = new mysqli(localhost, 'drozdowo', '<snip>', 'drozdowo_db');
        if ($conn->connect_error) die($conn->connect_error);
        
        $fuckthese = array("\"", "\'", "=");

        $userNameSafe = str_replace($fuckthese, "", $_POST['username']);
        $passwordSafe = str_replace($fuckthese, "", $_POST['password']);

        $query = 'SELECT * FROM users WHERE username LIKE "' . $userNameSafe . '" AND password LIKE "' . $passwordSafe . '";';

        $result = $conn->query($query) or die($conn->error);  

        $numRows = $result->num_rows;

        if ($numRows != 1){
            echo 'Invalid username or password!';
            return;
        }

        echo 'Successfully logged in!';

        setcookie('username', $userNameSafe, time() + 6000);

    }

    } else {
        echo 'Error! You sure you put information in?';
    }


?>