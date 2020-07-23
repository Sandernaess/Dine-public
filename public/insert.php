<?php 
    session_start(); 
    include ("../include/dbh.php");
    include ("functions.php"); 

    if (isset($_POST['ingredient']) && $_POST['ingredient'] == "new") {
        $ingredient = $_POST['item']; 
        $id = $_POST['id']; 

        if (empty($ingredient)) {
            header("Location: recipe.php?rID=$id&error=empty"); 
            exit; 
        }

        $sql = "INSERT INTO ingredients VALUES(:id, :item);";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id',$id); 
        $stmt->bindParam(':item',$ingredient);
        
        if ($row = $stmt->execute()) {
            header("Location: recipe.php?rID=$id#ingredient-add"); 
        } else {
            header("Location: recipe.php?rID=$id&error=upload"); 
        }
    }

    if (isset($_POST['step']) && $_POST['step'] == "new") {
        $desc = $_POST['desc']; 
        $id = $_POST['id']; 

        $sql = "INSERT INTO step (id, description) VALUES(:id, :dc)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->bindParam(':dc',$desc); 
        
        if ($row = $stmt->execute()) {
            header("Location: recipe.php?rID=$id#ingredient-add"); 
        } else {
            header("Location: recipe.php?rID=$id&error=upload"); 
        }
    }

    if (isset($_POST['step']) && $_POST['step'] == "delete") {
        $id = $_POST['id']; 
        $recipe = $_POST['idRecipe']; 

        $sql = "DELETE FROM step where step = :id AND id = :rp;";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->bindParam(':rp',$recipe); 
        
        if ($row = $stmt->execute()) {
            header("Location: recipe.php?rID=$id#ingredient-add"); 
        } else {
            header("Location: recipe.php?rID=$id&error=upload"); 
        }
    }

    //likes a recipe: 
    if (isset($_POST['like']) && $_POST['like'] == "recipe") {
        
        if (isset($_SESSION['ID'])) {
            $id = $_SESSION['ID']; 
            $recipeID = $_POST['idRecipe']; 

            $sql = "INSERT INTO likes VALUES (:rID, :id);";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id',$id);
            $stmt->bindParam(':rID',$recipeID); 

            if ($row = $stmt->execute()) {
                header("Location: recipe.php?rID=$recipeID#extra"); 
            } else {
                header("Location: recipe.php?rID=$recipeID&error=upload"); 
            }

        } else {
            header("Location: login.php"); 
        }
    }

    //removes like from a recipe: 
    if (isset($_POST['unlike']) && $_POST['unlike'] == "recipe") {
        $id = $_SESSION['ID']; 
        $recipeID = $_POST['idRecipe']; 

        $sql = "DELETE FROM likes where idr = :rID and ids = :id;";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->bindParam(':rID',$recipeID); 
        if ($row = $stmt->execute()) {
            header("Location: recipe.php?rID=$recipeID#extra"); 
        } else {
            header("Location: recipe.php?rID=$recipeID&error=upload"); 
        }
    }
    