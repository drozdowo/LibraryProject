<?php

if (isset($_POST['name']) || isset($_POST['author']) || isset($_POST['genre']) || isset($_POST['isbn'])){

$conn = mysqli(localhost, 'drozdowo', '<snip>', 'drozdowo_db');
if ($conn->connect_error) die($conn->connect_error);

$name = mysql_real_escape_string($_POST['name']);
$author = mysql_real_escape_string($_POST['author']);
$isbn = mysql_real_escape_string($_POST['isbn']);
$genre = mysql_real_escape_string($_POST['genre']);

$query = 'SELECT * FROM book WHERE ';

if (strlen($name) > 3){
    $query .= 'Name LIKE "%' . $name . '%" ';
}

if (strlen($author) > 3){
    $query .= 'Author_Name LIKE "%' . $author . '%" ';
}

if (strlen($isbn) > 3){
    $query .= 'ISBN LIKE "%' . $isbn . '%" ';
}

if (strlen($genre) > 3){
    $query .= 'Genre LIKE "%' . $genre . '%" ';
}

$query .= ';';

$result = $conn->query($query);
$numRows = $result->num_rows;

for ($k = 0; $k < $numRows ; $k++){
    $result->data_seek($k);
    $row = $result->fetch_array(MYSQLI_NUM);
    echo 'book - ' . $row[0] . '<br>';
}

} else {
    echo 'null';
}

?>