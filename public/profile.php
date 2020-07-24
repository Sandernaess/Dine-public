<?php 
    session_start();
    include ("../include/dbh.php");
    include ("functions.php");
    include ("recipeFunctions.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- General CSS -->
    <link rel="stylesheet" type="text/css" href="css/styling.css">
    <!-- CSS for index -->
    <link rel="stylesheet" type="text/css" href="css/profile.css">
    <title>Dine | Profile</title>
</head>
<?php 
    $own = false; 
    
    //check if visiting a profile
    if (isset($_GET['id'])) {
        $userID = $_GET['id']; 
        //get user information from database
        $stmt = getUserinfo($userID, $db); 
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $username = $row['username']; 
            $name = $row['realname'];
            if (isset($row['description'])) {
                $desc = $row['description'];
            } else {
                $desc = "This user has no description yet";
            }
        }
        
    } else {
        //check if user is logged in: 
        if (!isset($_SESSION['ID'])) {
            header("Location: login.php"); 
            exit; 
        }
        $own = true; 
        $username = $_SESSION['username']; 
        $name = $_SESSION['name'];
        $userID = $_SESSION['ID'];
        if (isset($_SESSION['description'])) {
            $desc = $_SESSION['description'];
        } else {
            $desc = "This user has no description yet";
        }
    }

    //get total created recipes: 
    $sql = "SELECT * FROM recipe WHERE iduser = :id LIMIT 6;";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $userID); 
    $stmt->execute();

    $total = $stmt->rowCount(); 

    //get all the liked recipes: 
    $sqlLiked = "SELECT * FROM recipe, likes WHERE idr = idrecipe and ids = :id LIMIT 6;"; 
    $stmtLiked = $db->prepare($sqlLiked);
    $stmtLiked->bindParam(':id', $userID); 
    $stmtLiked->execute();

    $totalLiked = $stmtLiked->rowCount(); 

?>

<body>
    <?php 
        include("../include/nav.php");
    ?>
    <section class="under-nav">
        <h3>Profile</h3>
    </section>
    <main>
        <!-- the user information and editing -->
        <section class="user-description">
            <article class="profile-info">
            <?php 
                //if own profile we can grab picture from the session, else get picture from db: 
                if ($own) {
                    if (isset($_SESSION['picture'])) {
                        echo('<img src="data:image/jpeg;base64,'.base64_encode($_SESSION['picture']).'"/>');
                    } else {
                        echo('<img src="img/profile-picture.png" />');
                    }
                } else {
                    //this gets the image from the db: 
                    $img = getProfilePic($userID, $db, $dbName); 
                    if ($img != null) {
                        echo('<img src="data:image/jpeg;base64,'.base64_encode($img).'"/>');
                    } else {
                        echo('<img src="img/profile-picture.png" />');
                    }
                }
            ?>
                <h1 class="real-name"><?php echo($name); ?></h1>
                <p class="username"><?php echo($username); ?></p>
            </article>

            <article class="profile-extra">
                <p class="desc"><?php echo($desc) ?></p>
                <?php 
                    //be able to edit profile if own profile
                    if ($own) {
                        echo('<a href="settings.php"><button class="btn dark">Edit profile</button></a>');
                    }
                ?>
            </article>

            <article class="profile-activity">
                <p><img src="img/utensils.svg" class="icon" alt=""> Recipes created: <b><?php echo($total) ?></b></p>
                <p><img src="img/heart.svg" class="icon" alt=""> Recipes liked: <b><?php echo($totalLiked) ?></b></p>
            </article>
        </section>


        <!-- Overview of the user's recipes -->
        <section class="recipe-overview">
            <!-- Created recipes -->
            <article class="recipes-created">
                <h1>Recipes created</h1>

                <?php 
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
                        $idRecipe = $row['idrecipe']; 
                        $title = $row['name']; 
                        if (strlen($title) > 26) {
                            //kort versjon av teksten: 
                            $title = substr($title, 0, 26) . "..."; 
                        }
                        $time = $row['time']; 
                        $difficulty = $row['difficulty']; 
                        $img = getRecipePic($idRecipe, $db, $dbName);
                ?>
                <a class="recipe-link" href="recipe.php?rID=<?php echo($idRecipe) ?>">
                    <article class="recipe-preview">
                    <?php 
                        if ($img != null) {
                            echo('<img src="data:image/jpeg;base64,'.base64_encode($img).'"/>');
                        } else {
                            echo('<img src="img/padthai.jpg"/>');
                        }
                        ?>
                        <div class="info">
                            <h3 class="recipe-title"><?php echo($title); ?></h3>
                            <div class="recipe-info">
                                <div class="infos">
                                    <p><img src="img/chef.svg" class="icon" alt=""><b> <?php echo($difficulty) ?></b>
                                    </p>
                                    <p><img src="img/clock.svg" class="icon" alt=""><b> <?php echo($time); ?> min</b>
                                    </p>
                                </div>
                                <div class="like-button">
                                    <img src="img/heart.svg" alt="">
                                </div>
                            </div>
                        </div>
                    </article>
                </a>
                <?php 
                    }
                    if ($total < 1) {
                        echo("<p> No recipes found! </p>");
                    }
                    if ($own) {
                        echo('<article class="btn-recipe">'); 
                        echo('<a href="share.php"><button class="btn dark add">+</button></a>');
                        echo('<a href="#"><button class="btn dark">SEE ALL</button></a>');
                        echo('</article>');
                    }     
                ?>
            </article>

            <!-- Liked recipes -->
            <article class="recipes-created">
                <h1>Liked recipes</h1>
                <?php 
                    while ($row2 = $stmtLiked->fetch(PDO::FETCH_ASSOC)) { 
                        $idRecipe = $row2['idrecipe']; 
                        $title = $row2['name']; 
                        if (strlen($title) > 26) {
                            //kort versjon av teksten: 
                            $title = substr($title, 0, 26) . "..."; 
                        }
                        $time = $row2['time']; 
                        $difficulty = $row2['difficulty']; 
                        $img = getRecipePic($idRecipe, $db, $dbName);
                ?>
                <a class="recipe-link" href="recipe.php?rID=<?php echo($idRecipe) ?>">
                    <article class="recipe-preview">
                        <?php 
                            if ($img != null) {
                                echo('<img src="data:image/jpeg;base64,'.base64_encode($img).'"/>');
                            } else {
                                echo('<img src="img/padthai.jpg"/>');
                            }
                        ?>
                        <div class="info">
                            <h3 class="recipe-title"><?php echo($title); ?></h3>
                            <div class="recipe-info">
                                <div class="infos">
                                    <p><img src="img/chef.svg" class="icon" alt=""><b> <?php echo($difficulty) ?></b>
                                    </p>
                                    <p><img src="img/clock.svg" class="icon" alt=""><b> <?php echo($time); ?> min</b>
                                    </p>
                                </div>
                                <div class="like-button">
                                    <img src="img/heart-full.svg" alt="">
                                </div>
                            </div>
                        </div>
                    </article>
                </a>
                <?php 
                    }
                    if ($totalLiked < 1) {
                        echo("<p> No recipes liked yet! </p>");
                    }
                    
                ?>
            </article>
        </section>


    </main>

    <?php 
        include("../include/footer.php");
    ?>
</body>

</html>