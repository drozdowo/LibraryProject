<?php

if (isset($_POST['name']) || isset($_POST['author']) || isset($_POST['genre']) || isset($_POST['isbn'])){

$conn = new mysqli(localhost, 'drozdowo', '<snip>', 'drozdowo_db');
if ($conn->connect_error) die($conn->connect_error);

$name = $_POST['name'];
$author = $_POST['author'];
$isbn = $_POST['isbn'];
$genre = $_POST['genre'];

$query = 'SELECT * FROM book WHERE ';

$fuckthese = array("\"", "\'", "=");

if (strlen($name) > 2){
    $name_sanitized = str_replace($fuckthese, "", $name);
    $query .= 'Name LIKE "%' . $name_sanitized . '%" ';
}

if (strlen($author) > 2){
    if (strlen($name) > 2) {
        $query .= ' AND ';
    }
    $author_sanitized = str_replace($fuckthese, "", $author);
    $query .= 'Author_Name LIKE "%' . $author_sanitized . '%" ';
}

if (strlen($isbn) > 2){
    if (strlen($name) > 2 || strlen($author) > 2) {
        $query .= ' AND ';
    }
    $isbn_sanitized = str_replace($fuckthese, "", $isbn);
    $query .= 'ISBN LIKE "%' . $isbn_sanitized . '%" ';
}

if (strlen($genre) > 2){
    if (strlen($name) > 2 || strlen($author) > 2 || $strlen($isbn) > 2) {
        $query .= ' AND ';
    }
    $genre_sanitized = str_replace($fuckthese, "", $genre);
    $query .= 'Genre LIKE "%' . $genre . '%" ';
}

$query .= ';';

//echo $query;

$result = $conn->query($query);
$numRows = $result->num_rows;
$html = '<div class="searchresulttable"><table><tr><th> Book Title </th><th> Author </th><th> ISBN </th><th> Genre </th> <th> Borrow </th> </tr>';

for ($k = 0; $k < $numRows ; $k++){
    $result->data_seek($k);
    $row = $result->fetch_array(MYSQLI_NUM);
    $html .= '<tr>';
    $html .= '<td>' . $row[0] . '</td><td>'. $row[1] .'</td><td>'. $row[2] .'</td><td>'. $row[3] .'</td><td> <input type="button" onclick= "borrow('. $row[2] .')" value="Borrow"/> </td>';
    $html .= '</tr>';
}

$html .= '</table></div>';

echo $html;

} else {
    echo 'null';
}

?>