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
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css"
    />
    <link rel="icon" href="img/chef7.svg">
    <title>Dine | Home </title>
</head>

<body>
    <!-- Header part -->
    <header>
        <?php 
      include("../include/nav.php");
    ?>
        <article class="header-text animate__animated">
            <h2>Discover delicious food recipes or share your own.</h2>
            <form action="search.php" method="POST">
                <input name="search" class="recipe-search" placeholder="Search for recipes.." type="text">
                <button type="submit" class="btn search">Search</button>
            </form>
        </article>

        <article class="mobile-header">
            <h3>What are you creating today? 👨‍🍳</h3>
        </article>

    </header>

    <!-- Main -->
    <?php 
    if (isset($_SESSION['ID'])) {
        $ID = $_SESSION['ID'];
    }
    ?>
    <main>
        <!-- Categories section -->
        <section class="categories">
            <article class="category">
                <a class="category-link" title="Popular now" href="#">
                    <img src="img/chopsticks.svg" alt="">
                    <p>Popular now</p>
                </a>
            </article>


            <article class="category">
                <a class="category-link" title="Fast & Easy" href="category.php?category=fast">
                    <img src="img/burger.svg" alt="">
                    <p>Fast & Easy</p>
                </a>
            </article>

            <article class="category">
                <a class="category-link" title="Healthy" href="category.php?category=healthy">
                    <img src="img/nutrition.svg" alt="">
                    <p>Healthy</p>
                </a>
            </article>

            <article class="category">
                <a class="category-link" title="Vegetarian" href="category.php?category=vegetarian">
                    <img src="img/vegetable.svg" alt="">
                    <p>Vegetarian</p>
                </a>
            </article>

            <article class="category">
                <a class="category-link" title="popular" href="category.php?category=bakery">
                    <img src="img/cookie.svg" alt="">
                    <p>Bakery</p>
                </a>
            </article>

            <article class="category">
                <a class="category-link" title="popular" href="category.php?category=Breakfast">
                    <img src="img/bacon.svg" alt="">
                    <p>Breakfast & Lunch</p>
                </a>
            </article>

            <!-- See all recipies -->
            <article class="category-all">
                <p><a id="recipe-link" href="all.php">See all recipes</a></p>
            </article>
        </section>

        <!-- About section -->
        <section class="about">
            <a id="own-ac" class="ac" href="share.php">
                <h2>Create your own</h2>
            </a>

            <a id="about-ac" class="ac" href="#">
                <h2>About Dine</h2>
            </a>

        </section>
    </main>

    <!-- The current most popular recipes -->
    <section class="recipe-section popular-recipes">
        <h1>Popular Now</h1>
        <!-- Results here -->
        <?php 
            $sql = "SELECT * FROM $dbName.recipe LIMIT 6;"; 
            $stmt = $db->prepare($sql);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
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
                            <p><img src="img/chef.svg" class="icon" alt=""><b> <?php echo($difficulty) ?></b></p>
                            <p><img src="img/clock.svg" class="icon" alt=""><b> <?php echo($time); ?> min</b></p>
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
                echo("<p> No recipes found! </p>"); 
            }
        ?>

    </section>

    <?php 
    include("../include/footer.php");
  ?>
    <!-- loader for when the page loads -->
    <div class="loader">
        <img src="img/loading.gif" alt="">
    </div>
  <script src="js/load.js"></script>
</body>

</html>