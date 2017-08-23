<?php

    if (isset($_COOKIE['username'])){
        echo 'You are still logged in. Please log out to make a new account.';
        return;
    }

    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['phonenumber'])){

        $conn = new mysqli(localhost, 'drozdowo', '<snip>', 'drozdowo_db');
        if ($conn->connect_error) die($conn->connect_error);

        $fuckthese = array("\"", "\'", "=");
        $query = 'INSERT INTO users VALUES(0, "';
        
        $userNameSanitized = str_replace($fuckthese, "", $_POST['username']);
        $query .= $userNameSanitized . '", "';

        $emailSanitized = str_replace($fuckthese, "", $_POST['email']);
        $query .= $emailSanitized . '", "';

        $phoneSanitized = str_replace($fuckthese, "", $_POST['phonenumber']);
        $query .= $phoneSanitized .'","';

        $passwordSanitized = str_replace($fuckthese, "", $_POST['password']);
        $query .= $passwordSanitized .'", ';

        //If they're reigstering here -- they're most likely a non-privileged user
        $query .= '0);';
        
        //echo $query;

        $result = $conn->query($query) or die($conn->error);

        echo 'Successfully registered! Go back to the home page and log in!';


    } else {
        echo 'weird shit';
        return;
    }



?>