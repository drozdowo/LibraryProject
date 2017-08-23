<?php
    if ($_GET['logout'] == '1'){
        if (isset($_COOKIE['username'])){
            unset($_COOKIE['username']);
            setcookie('username', '', time() - 1);
            echo 'Successfully logged out!';
        }
        return;
    }

    if (isset($_COOKIE['username'])){
        echo '<center> Currently logged in as: ' . $_COOKIE['username'] . '.<br>';
        echo '<div><input onclick="gotomybooks()" type="button" value="My Books"/>  <input onclick="logout()" type="button" value="Log out"/></div>';
    } else {
        echo 'You aren\'t currently signed in.<br>';
        echo '<input type="button" onclick="location.href=\'./login.html\'" value="Sign in"/>';
    }
?>