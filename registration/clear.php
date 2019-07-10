<?php

$db = mysqli_connect('localhost', 'root', '', 'test');
$query = "TRUNCATE TABLE posts";
mysqli_query($db, $query);
header("location: http://localhost/registration/index.php");

?>

