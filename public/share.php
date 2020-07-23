<?php 
    session_start();
    include ("functions.php"); 
    include ("recipeFunctions.php"); 
    include ("../include/dbh.php");
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
    <link rel="stylesheet" type="text/css" href="css/share.css">
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css"
    />
    <title>Dine | Share Recipe</title>
    <link rel="icon" href="img/chef7.svg">
</head>
<?php 
    //get user information
    $username = $_SESSION['username']; 
    $name = $_SESSION['name'];
    $userID = $_SESSION['ID'];  
?>

<body>
    <?php 
        include("../include/nav.php");
    ?>
    <section class="under-nav">
        <h3>Create Recipe</h3>
    </section>
    <main>
        <section class="create-recipe">
            <form action="uploads.php" method="POST" enctype="multipart/form-data">
                <h1>Share your recipe</h1>
                <!-- Image upload -->
                <input class="file-upload" type="file" name="recipeImage" size="30">
            
          

                <!-- Title -->
                <label for="title">Title</label>
                <input placeholder="A title for your recipe" name="title" id="title" type="text" required>

                <!-- Other info -->
                <label for="title">Type of genre</label>
                <select name="genre" id="genre">                
                <?php
                    getGenres($db, $dbName);
                ?>         
                </select>

                <label for="description">Description </label>
                <textarea placeholder="Description of the recipe" class="description" name="description" id="desc" cols="30" rows="10"></textarea>
                <label for="difficulty">Difficulty </label>
                <select name="difficulty" id="difficulty" required>                
                <?php
                    getDifficulty($db, $dbName);
                ?>         
                </select>
                <label for="quantity">Time to make in minutes</label>
                <input placeholder="minutes" type="number" id="minutes" name="minutes" min="2" max="300">
                <button name="create" value="recipe" class="btn dark" type="submit">CREATE</button>          
            </form>
 
        </section>

    </main>

    <?php 
        include("../include/footer.php");
    ?>
</body>
</html>
