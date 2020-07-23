<?php 
    //this page shows all the created recipes
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
    <link rel="stylesheet" type="text/css" href="css/category.css">
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css"
    />
    <link rel="icon" href="img/chef7.svg">
    <title>Dine | All Recipes </title>
</head>

<body>
    <?php 
      include("../include/nav.php");
    ?>
    <section class="under-nav">
        <h3>All Recipes</h3>
    </section>
    <main>
        <?php 
            if (isset($_SESSION['ID'])) {
                $ID = $_SESSION['ID'];
            }
        ?>
        <section class="top">
            <h1>All Recipes</h1>
            <p>Find all the recipes created from the users at Dine. From vegetarian lunch ideas, to tasty bakery recipes and more. </p>
        </section>

        <section class="most-liked">
            <?php 
                $sql = "SELECT * FROM recipe";
                $stmt = $db->prepare($sql); 
                $stmt->execute(); 
                if ($stmt ->rowCount() > 0) {
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $idRecipe = $row['idrecipe']; 
                        $title = $row['name']; 
                        if (strlen($title) > 19) {
                            //kort versjon av teksten: 
                            $title = substr($title, 0, 15) . "..."; 
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
                                            <p><img src="../img/chef.svg" class="icon" alt=""><b> <?php echo($difficulty) ?></b></p>
                                            <p><img src="../img/clock.svg" class="icon" alt=""><b> <?php echo($time); ?> min</b></p>
                                        </div>
                                        <div class="like-button">
                                        <?php 
                                            $liked = false; 
                                            if (isset($ID)) {
                                                $liked = checkLike($idRecipe, $db); 
                                                if ($liked) {
                                                    echo('<img src="img/heart-full.svg" alt="">');
                                                } else {
                                                    echo('<img src="img/heart.svg" alt="">');
                                                }
                                            } else {
                                                echo('<img src="img/heart.svg" alt="">');
                                            }
                                        ?>
                                        </div>
                                    </div>
                                </div>

                            </article>
                        </a> 
            <?php 
                    }
                } else {
                    echo("<p> no recipes found. </p>");
                }
            ?>
        </section>
    </main>
    <?php 
        include("../include/footer.php");
    ?>
    
</body>
</html>