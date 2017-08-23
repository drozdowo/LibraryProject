<?php
if (isset($_COOKIE['username'])){
    $conn = new mysqli('localhost', 'drozdowo', '<snip>', 'drozdowo_db');
    if ($conn->connect_error) die ($conn->connect_error);

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

    $getBooksStmt = $conn->query("SELECT a.Name, a.Author_Name, a.ISBN, b.start_borrow, b.end_borrow FROM book as a, borrows AS b WHERE a.ISBN = b.isbn AND b.userid=".$userId.";") or die('Error!!');
    $numRows = $getBooksStmt->num_rows;

    if ($numRows == 0){
        echo 'You haven\'t borrowed any books!';
    } else {
        $html = '<div class="searchresultstable"><table><tr><th>Book Title</th><th>Author</th><th>ISBN</th><th>Borrowed On</th><th>Due Before</th><th>Return</th></tr>';
        for ($k = 0 ; $k < $numRows ; $k++){
            $getBooksStmt->data_seek($k);
            $row = $getBooksStmt->fetch_array(MYSQLI_NUM);
            $html .= '<tr>';
            $html .= '<td>' . $row[0] . '</td><td>'. $row[1] .'</td><td>'. $row[2] . '</td><td>'. $row[3]. '</td><td>'.$row[4].'</td><td><input type="button" onclick= "returnBook('. $row[2] .')" value="Return"/></td>';
            $html .= '</td>';
        }

        $html .= '</table></div>';
        echo $html;
    }

} else {
    echo 'You\'re not supposed to be here!';
}


?>