<?php 
  session_start();
  include ("../include/dbh.php");
  include ("recipeFunctions.php");
  include ("functions.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- General CSS -->
    <link rel="stylesheet" type="text/css" href="css/styling.css">
    <!-- CSS for index -->
    <link rel="stylesheet" type="text/css" href="css/recipe.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css" />
    <link rel="icon" href="img/chef7.svg">
    <title>Dine | Recipe </title>   
</head>
<body>
    <?php 
        include("../include/nav.php");
        //grab the chosen recipe
        if (isset($_GET['rID'])) {
            $ID = $_GET['rID'];
            
            $sql = "SELECT * FROM recipe where idrecipe = :id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $ID); 
            $stmt->execute(); 
            
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {  
                $name = $row['name']; 
                $desc = $row['description']; 
                $time = $row['time']; 
                $diff = $row['difficulty']; 
                $user = $row['iduser'];  
                $likes = getLikes($ID, $db); 
                $username = getUsername($user, $db, $dbName);
                
            }   
        }

        //check if the logged in user owns the recipe 
        $owner = false; 
        if (isset($_SESSION['ID']) && $_SESSION['ID'] == $user) {
            $owner = true; 
        }

        //check if the user has liked the recipe
        $liked = false; 
        if (!$owner && isset($_SESSION['ID'])) {
            $liked = checkLike($ID, $db); 
        }

        if (isset($_GET['succesful'])) {
            echo('<article class="animate__animated animate__lightSpeedInLeft success">
            <p>Recipe created! Now add ingredients</p>
        </article>'); 
        }
    ?>
    <section class="under-nav">
        <h3>Recipe</h3>
    </section>

    <!-- the whole recipe -->
    <main class="recipe">
        <!-- the img -->
        <section class="recipe-img">
            <?php 
                $img = getRecipePic($ID, $db, $dbName);
                if ($img != null) {
                    echo('<img src="data:image/jpeg;base64,'.base64_encode($img).'"/>');
                } else {
                    echo('<img src="img/padthai.jpg"/>');
                }
            ?>
        </section>

        <!-- Description for the recipe -->
        <section class="recipe-desc">
            <article class="desc-top">
                <h1><?php echo($name); ?></h1>
                <p>Created by <b><?php
                    if ($owner) {
                        echo("You"); 
                    } else {
                        echo('<a href="profile.php?id='.$user.'">'.$username.'</a>');
                    } ?></b></p>
                <p><img src="img/heart.svg" class="icon" alt=""> Likes: <b><?php echo($likes) ?></b></p>
               
            </article>
            <p><?php echo($desc); ?></p>

            <article id="extra" class="recipe-extra">
                <article>
                    <p><?php echo($time); ?> min <img src="img//clock.svg" class="icon" alt=""></p>
                </article>
                <article>
                    <p><?php echo($diff); ?></p>
                </article>
                <article>
                    <?php
                        //this gives out the correct buttons for the liking-system: 
                        if (!$owner) {
                            echo('<form action="insert.php" method="POST">');
                            //not owner, give out button to like and unlike: 
                            if ($liked) {
                                echo('<button type="submit" name="unlike" value="recipe" class="recipe-like"><img src="img/heart-full.svg" alt=""></button>');
                            } else {
                                echo('<button type="submit" name="like" value="recipe" class="recipe-like"><img src="img/heart.svg" alt=""></button>');
                            }
                            echo('<input name="idRecipe" type="hidden" value="'. $ID .'">'); 
                            echo('</form>');
                 
                        } elseif ($owner) {
                            echo("<button class='btn dark'>EDIT</button>");
                        }
                    ?>
                </article>
            </article>

        </section>

        <!-- Ingredients -->
        <section class="ingredients">
            <?php 
                //this checks for errors: 
                if (isset($_GET['error'])) {
                    $error = error($_GET['error']);
                    if (!empty($error)) {
                        echo("<p class='error-message'> <img class='icon' src='img/error.svg' alt=''> $error </p>"); 
                    }    
                }    
            ?>
            <!-- the ingredients needed: -->
            <article class="ingredient-display">
                <h2>Ingredients</h2>
                <?php 
                    //get the ingredients: 
                    $stmt = getIngredients($ID, $db); 
                    //check if the user owns the recipe, then give them the option to add: 
                    if ($owner) {
                        if ($stmt->rowCount() == 0) {
                            echo("<p>No ingredients added yet, add some!</p>"); 
                        }
                ?>
                        <form action="insert.php" method="post">
                            <input name="item" type="text" placeholder="Add ingredient">
                            <input name="id" type="hidden" value="<?php echo($ID) ?>">
                            <button type="submit" name="ingredient" value="new" class="btn dark">+</button>
                        </form>         
                <?php 
                    }
                    if ($stmt->rowCount() > 0) {
                        echo("<ul class='ingredient-list'>"); 
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo("<li>" . $row['name'] . "</li>");
                        }
                        echo("</ul>");
                    }
                ?>
            </article>

            <article id="ingredient-add" class="ingredient-how">
                <h2>How to make it</h2>
                <?php 
                    $stmt2 = getHow($ID, $db); 
                    if ($owner) {
                        if ($stmt2->rowCount() == 0) {
                            echo("<p>No steps yet, add some!</p>"); 
                        }  
                        echo('<button class="btn dark" id="edit" onclick="edit()">EDIT</button>');
                ?>
                    <form id="add" action="insert.php" method="post">
                        <input name="desc" type="text" placeholder="Add step">
                        <input name="id" type="hidden" value="<?php echo($ID) ?>">
                        <button type="submit" name="step" value="new" class="btn dark">+</button>
                    </form> 
                    
                <?php  
                    }
                    $step = 0; 
                    while($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                        $idStep = $row['step']; 
                        $step += 1; 
                        $desc = $row['description']; 
                ?>
                    <article class="how-to">
                        <span class="step"><?php echo($step); ?></span>
                        <div>
                            <p class="description"><?php echo($desc); ?></p>
                            <?php if($owner) {
                                echo('<form action="insert.php" method="post">');
                                echo('<input name="id" type="hidden" value='.$idStep.'>');
                                echo('<input name="idRecipe" type="hidden" value='.$ID.'>');
                                echo('<button name="step" value="delete" type="submit" class="delete" id="delete">X</button>');
                                echo('</form>');
                            } ?>
                        </div>
                    </article>
                            <input type="hidden" value>
                <?php 
                    }
                ?>
            </article>
        </section>
    </main>

    <?php 
        include("../include/footer.php");
    ?>
     <script src="js/recipe.js"></script>
</body>
</html>