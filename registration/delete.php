<?php
// Deletes post. There should be a better way to do this?
$db = mysqli_connect('localhost', 'root', '', 'test');
$query = "DELETE FROM posts WHERE post_id = {$_GET['id']}";
mysqli_query($db, $query);
header("location: http://localhost/registration/index.php");

?>
