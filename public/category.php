<?php 
  session_start();
  include ("../include/dbh.php");
  include ("recipeFunctions.php");
  include("functions.php");
  
  if (isset($_GET['category'])) {
    $cat = $_GET['category'];

    $stmt = getAbout($cat, $db); 
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {  
        $name = $row['name']; 
        $desc = $row['description']; 
    }
  }  
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css" />
    <link rel="icon" href="../img/chef7.svg">
    <title>Dine | <?php echo($name); ?> </title>
    
</head>
<body>
    <?php 
      include("../include/nav.php");
    ?>
    <section class="under-nav">
        <h3>Vegetarian</h3>
    </section>
    <main>
        <section class="top">
            <h1><?php echo($name); ?> Recipes</h1>
            <p><?php echo($desc); ?></p>
        </section>
        
        <section class="most-liked">
            <?php 
                $stmt = getPopular($cat, $db, $dbName);
                if ($stmt ->rowCount() > 0) {
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
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
                                            <p><img src="../img/chef.svg" class="icon" alt=""><b> <?php echo($difficulty) ?></b></p>
                                            <p><img src="../img/clock.svg" class="icon" alt=""><b> <?php echo($time); ?> min</b></p>
                                        </div>
                                        <div class="like-button">
                                            <img src="../img/heart.svg" alt="">
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
    <script src="../js/register.js"></script>

</body>
</html>

