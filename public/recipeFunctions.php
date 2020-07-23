<?php 
    //Get the difficulties from the db: 
    function getDifficulty($db) {
        //get the different options from the db: 
            $sql = "SELECT * FROM difficulty"; 
            $stmt = $db->prepare($sql); 
            $stmt->execute(); 
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo("<option id='option' name='option' value='" . $row['name'] . "'>");
                echo($row['name'] . "</option>");
            }
    }

    function getRecipeImg($db, $id) {
        $sql = "SELECT location FROM picture, recipe WHERE picture.id = recipe.pictureid and recipe.idrecipe = :id"; 
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute(); 
        if ($row = $stmt->fetch()) {
            $location = $row['location'];
        } else {
            $location = "img/dalgona.jpg";
        }
        return $location; 
    }

    //this grabs all the genres: 
    function getGenres($db) {
        //get the different options from the db: 
        $sql = "SELECT * FROM genre"; 
        $stmt = $db->prepare($sql); 
        $stmt->execute(); 
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo("<option id='option' name='option' value='" . $row['name'] . "'>");
            echo($row['name'] . "</option>");
        } 
    }

    //this grabs the likes from a chosen recipe: 
    function getLikes($id, $db) {
        $likes = 0; 
        $sql = "SELECT COUNT(*) AS amount FROM likes where idr = :id;"; 
        $stmt = $db->prepare($sql); 
        $stmt->bindParam(':id', $id);
        $stmt->execute(); 
        if ($row = $stmt->fetch()) {
            $likes = $row['amount']; 
        }
        return $likes; 
    }

    //this checks if an user has liked the recipe
    function checkLike($id, $db) {
        $liked = false; 
        $sql = "SELECT * FROM likes where idr = :idrecipe and ids = :iduser;";
        $stmt = $db->prepare($sql); 
        $stmt->bindParam(':idrecipe', $id);
        $stmt->bindParam(':iduser', $_SESSION['ID']);
        $stmt->execute(); 
        if ($stmt->rowCount() > 0) {
            $liked = true;  
        }
        return $liked; 
    }

    function getIngredients($id, $db) {
       $sql =  "SELECT * FROM ingredients where recipeid = :id;";
       $stmt = $db->prepare($sql); 
       $stmt->bindParam(':id', $id);
       $stmt->execute(); 

       return $stmt; 
    }

    //get all the recipes for a category, sorted on most popular by liked:
    function getPopular($genre, $db, $dbName) {
        $sql =  "SELECT * FROM $dbName.recipe where genre = :gr;";
        $stmt = $db->prepare($sql); 
        $stmt->bindParam(':gr', $genre);
        $stmt->execute(); 
        return $stmt; 
    }

    function getHow($id, $db) {
        $sql =  "SELECT * FROM step where id = :id ORDER BY step;";
        $stmt = $db->prepare($sql); 
        $stmt->bindParam(':id', $id);
        $stmt->execute(); 
        return $stmt; 
    }

    function getAbout($name, $db) {
        $sql =  "SELECT * FROM genreDesc where name = :nm";
        $stmt = $db->prepare($sql); 
        $stmt->bindParam(':nm', $name);
        $stmt->execute(); 
        return $stmt; 
    }
    
    