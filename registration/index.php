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
?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body style="text-align: center;">

    <div class="header">
        <h2>Home Page</h2>
    </div>
    <div class="content">
        <!-- notification message -->
        <?php if (isset($_SESSION['success'])) : ?>
          <div class="error success" >
            <h3>
                <?php 
                echo $_SESSION['success']; 
                unset($_SESSION['success']);
                ?>
            </h3>
          </div>
        <?php endif ?>

        <!-- logged in user information -->
        <?php  if (isset($_SESSION['username'])) : ?>
        <p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
        <p> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>
        <?php endif ?>
    </div>
    <div class="header">
        <label>POST STUFF</label><br>
    </div>
    <form action="" method="post">
    <div style="text-align: left;">
        <input type="text" name="title" id="title" style="" placeholder="Title..."/>
    </div>
        <textarea type="submit" rows="25" name="postContent" placeholder="Content..."></textarea>
        <input type="submit" name="button" class="btn" value="Submit" />
    </form>
<?php
// Gets all table values.
$sql = "SELECT * FROM posts";
// Stores table values into $result.
$result = mysqli_query($db, $sql) or die("Bad Query: $sql");
// Checks for content in the post stuff text box.
$postContent = isset($_POST['postContent']) ? $_POST['postContent'] : '';

$day = date("m/d/y");
$time = date("h:i:sa");
$user = $_SESSION['username'];

// Checks for title, if not, sets to untitled.
if (isset($_POST['title']) && trim($_POST['title']) != '') {
    $title = $_POST['title'];
} else {
    $title = 'Untitled';
}

$query = "INSERT INTO posts (title, content, author)
    VALUES('$title', '$postContent', '$user')";

// Outputs result on page.
while($row = mysqli_fetch_assoc($result)) {
    echo  "{$row['post_id']}. {$row['author']} {$row['post_time']}<nbr>
        <form id='special' action='edit.php?id={$row['post_id']}' method='post'>
        <input type='submit' name='edit{$row['post_id']}' value='Edit {$row['post_id']}' />
        </form>
        <br> Title: {$row['title']}<br> Content: {$row['content']}<br><br>";
}

// Posts posts table contents.
echo $postContent;
echo "<br>" . $_SESSION['username'] . " " ;
echo date("m/d/y") . " " . date("h:i:sa");
// Does not submit if content is empty.
if (trim($postContent) == '') {
    exit;
}
// Sends query to database and INSERTS INTO posts table.
mysqli_query($db, $query);

?>

<?php
// If page is refreshed, their post will not be resubmitted.
header("location: http://localhost/registration/index.php"); 
?>
</body>
</html>
