<?php include 'header.php';
session_start();
$user = $_SESSION["user"];
$userid = $_SESSION["userId"];

$flat = 0;
include 'connection.php';
$sql = "SELECT username, email, userprofile FROM UserList WHERE id = '$userid'";
$result = $conn->query($sql);

if ($result->num_rows > 0)
{
    while ($row = $result->fetch_assoc()) {
        $username = $row["username"];
        $useremail = $row["email"];
        $profile_pic = $row["userprofile"];
        $flat = 1;
    }
} else {
    echo "0 results";
}
if ($flat == 0)
{
    $profile_pic = "uploads/user.png";
}
$conn->close();

?>
<div class="wrapper">
    <header class="header">
        <div class="l-container clear-fix">

            <h2 class="title f-left"><a href="index.php">Home</a></h2>

            <?php if ($user == "")
            {
                echo '<a href="register.php" class="comn-btn f-right">Register</a>';
                echo '<a href="login.php" class="comn-btn f-right">Login</a>  ';
            } else {
                echo '<div class="dropdown f-right">';
                echo '<button class="dropbtn"><img src=' . $profile_pic . ' alt="" class="profile"></button>';
                echo '<div class="dropdown-content">';
                echo '<a href="profile.php">Profile</a>';
                echo '<a href="logout.php">Logout</a>';
                echo '</div></div>';
            }
            ?>
        </div>
</div>
</header>
<div class="l-container">
    <div class="profile-card form-profile">
        <h3 class="profile-ttl">My Profile Setting</h3>
        <form action="upload.php" method="post" enctype="multipart/form-data" class="form">
            <img src="<?php echo $profile_pic; ?>" alt="profile" class="profile-mv">
            <input type="button" id="upload" value="Upload" onclick="document.getElementById('fileToUpload').click();" class="upload comn-btn" />
            <input type="file" style="display:none;" id="fileToUpload" name="fileToUpload" />

            <p class="comn-inputp">Name</p>
            <input type="text" name="name" id="" class="inputtext" placeholder="name" value=<?php echo $username; ?> required>

            <p class="comn-inputp">Email</p>
            <input type="email" name="email" class="inputtext" placeholder="name@example.com" id="" value="<?php echo $useremail; ?>" required>
            <div class="clear-fix">
                <input type="submit" value="Update" class="comn-btn f-right">
            </div>

        </form>
    </div>
</div>
</div>
<?php include 'footer.php' ?>