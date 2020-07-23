<?php 
    session_start();
    include ("../include/dbh.php");
    include ("functions.php"); 
    include ("recipeFunctions.php");
    if (!isset($_SESSION['ID'])) {
        header("Location: login.php"); 
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- General CSS -->
    <link rel="stylesheet" type="text/css" href="css/styling.css">
    <link rel="stylesheet" type="text/css" href="css/settings.css">
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css"
    />
    <title>Dine | Profile</title>
    <link rel="icon" href="img/chef7.svg">
</head>
<?php 
    //get user information
    $username = $_SESSION['username']; 
    $name = $_SESSION['name'];
    $userID = $_SESSION['ID'];
    if (isset($_SESSION['description'])) {
        $desc = $_SESSION['description']; 
    } else {
        $desc = "";
    }
?>

<body>
    <?php 
        include("../include/nav.php");
    ?>
    <main>
        <section class="profile-nav">
            <article class="tablink" id="profile" onclick="velgSide('rediger-bruker', this)">
                <h2>Profile</h2>
                <img class="icon" src="img/user-solid.svg" alt="">
            </article>

            <article class="tablink" id="pw" onclick="velgSide('bytt-passord', this)">
                <h2>Password</h2>
                <img class="icon" src="img/key-solid.svg" alt="">
            </article>

            <article class="tablink" id="account" onclick="velgSide('inst-bruker', this)">
                <h2>Account</h2>
                <img class="icon" src="img/cog.svg" alt="">
            </article>
        </section>
        
        <?php 
            if (isset($_GET['succesful'])) {
                echo('<article class="animate__animated animate__lightSpeedInLeft success">
                <p>Profile updated!</p>
            </article>'); 
            }
        ?>


        <section class="profile">
            <article class="user-info">
                <h2>Personal</h2>
                <?php 
                    //this checks for errors: 
                    if (isset($_GET['error'])) {
                        $error = error($_GET['error']);
                        if (!empty($error)) {
                            echo("<p class='error-message'> <img class='icon' src='../img/error.svg' alt=''> $error </p>"); 
                        }    
                    }
                ?>
                <form action="edits.php" method="POST">
                    <label for="username">Username:</label>
                    <input name="username" id="username" type="text" value="<?php echo($username); ?>">
                    <label for="name">Name:</label>
                    <input name="name" id="name" type="text" value="<?php echo($name); ?>"> 
                    <label for="desc">Description:</label>
                    <textarea class="desc" name="desc" id="desc" cols="30" rows="10" placeholder="Description/Bio"><?php echo($desc) ?></textarea>
                    <button name="edit" value="personal" class="btn dark" type="submit">EDIT PROFILE</button>          
                </form>
                
            </article>

            <article class="user-picture"> 
                <?php 
                if (isset($_SESSION['picture'])) {
                    echo('<img src="data:image/jpeg;base64,'.base64_encode($_SESSION['picture']).'"/>');
                } else {
                    echo('<img src="img/profile-picture.png" />');
                }
                ?>
                    
                <form class="picture-upload" action="uploads.php" method="POST" enctype="multipart/form-data">
                    <input class="file-upload" type="file" name="userImage" size="30">
                    <button type="submit" value="profilepicture" name="picture_upload" class="btn dark">UPLOAD</button>
                </form>
            </article>
        </section>
    </main>

    <?php 
        include("../include/footer.php");
    ?>
</body>
</html>
