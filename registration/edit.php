<link rel="stylesheet" type="text/css" href="style.css">
<?php
session_start();

$db = mysqli_connect('localhost', 'root', '', 'test');

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
}
$query = "SELECT * FROM posts WHERE post_id = {$_GET['id']}";
$result = mysqli_query($db, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $prevContent = $row['content'];
    $prevTitle = $row['title'];
    $prevTime = $row['post_time'];
}
?>

<body>
    <div class="header">
        <label>Edit Post<?php echo " " . $_GET['id'] ?></label><br>
    </div>
    <form action="" method="post">
    <input type="text" name="title" id="title" placeholder="Title..." value="<?php echo $prevTitle ?>" />
        <textarea type="submit" rows="25" name="postContent" placeholder="Content..." >
<?php
echo $prevContent;
?>
        </textarea>
        <input type="submit" name="button" class="btn" value="Submit" />
    </form>
</body>

<?php
$postContent = isset($_POST['postContent']) ? $_POST['postContent'] : '';


if (isset($_POST['title']) && trim($_POST['title']) != '') {
    $title = $_POST['title'];
} else {
    $title = 'Untitled';
}

$query = "UPDATE posts SET title = '{$title}', content = '{$postContent}' WHERE post_id = {$_GET['id']}";

mysqli_query($db, $query);

?>

