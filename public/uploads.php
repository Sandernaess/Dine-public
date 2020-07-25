<?php 
    //this file handles uploading pictures & creating recipes: 

    include ("../include/dbh.php");
    include ("functions.php"); 
    session_start(); 

    //this handles creating recipes: 
    if (isset($_POST['create']) and $_POST['create']=="recipe") {
        $title = $_POST['title'];
        $desc = $_POST['description'];
        $difficulty = $_POST['difficulty']; 
        $minutes = $_POST['minutes']; 
        $genre = $_POST['genre'];

        if (count($_FILES) > 0) {
            if (is_uploaded_file($_FILES['recipeImage']['tmp_name'])) {
                $imgData = addslashes(file_get_contents($_FILES['recipeImage']['tmp_name']));
                $imageProperties = getimageSize($_FILES['recipeImage']['tmp_name']);

                //checks image size to prevent big uploads, dont allow bigger than 5 megabytes
                if ($_FILES['recipeImage']['size'] > 5000000) {
                    header("Location: share.php?error=filesize");
                    exit; 
                }

                //Checks the filetype, only allow jpeg and png files to upload: 
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                if (false === $ext = array_search(
                    $finfo->file($_FILES['recipeImage']['tmp_name']),
                    array(
                        'jpg' => 'image/jpeg',
                        'png' => 'image/png',
                    ),
                    true
                )) {
                    header("Location: share.php?error=filetype");  
                    exit;
                }
            }
        }
    
        $pictureID = rand(1,4); //this would be the result, instead we generate a random image.
        $sql = "INSERT INTO $dbName.recipe (name, time, description, difficulty, iduser, pictureid, genre) 
        VALUES (:nm, :ti, :dc, :di, :rID, :pID, :gr);"; 

        $stmt = $db->prepare($sql);
        //bind for sql: 
        $stmt->bindParam(':nm',$title);
        $stmt->bindParam(':ti', $minutes); 
        $stmt->bindParam(':dc', $desc); 
        $stmt->bindParam(':di', $difficulty); 
        $stmt->bindParam(':rID',$userID);
        $stmt->bindParam(':pID',$pictureID); 
        $stmt->bindParam(':gr',$genre); 

        //get the user's ID for db: 
        $userID = $_SESSION['ID'];

        //run stmt: 
        if ($row = $stmt->execute()) {
            $rID = $db->lastInsertId(); 
                       
            $sql2 = "UPDATE $dbName.recipe SET imagetype = '{$imageProperties['mime']}' , picture = '{$imgData}' WHERE idrecipe = :id;";
            $stmt2 = $db->prepare($sql2);
            $stmt2->bindParam(':id',$rID);
            if ($stmt2->execute()) {
                header("Location: recipe.php?rID=$rID&succesful=uploaded");
            } else {
                echo "\nPDO::errorInfo():\n";
                print_r($db->errorInfo());
            }        
        }
        
    }
            
    

    //profile picture upload
    if (isset($_POST['picture_upload']) and $_POST['picture_upload']=="profilepicture") {
        if (count($_FILES) > 0) {
            if (is_uploaded_file($_FILES['userImage']['tmp_name'])) {
                $imgData = addslashes(file_get_contents($_FILES['userImage']['tmp_name']));
                $imageProperties = getimageSize($_FILES['userImage']['tmp_name']);

                //checks image size to prevent big uploads, dont allow bigger than 5 megabytes
                if ($_FILES['userImage']['size'] > 5000000) {
                    header("Location: settings.php?error=filesize");
                    exit; 
                }

                //Checks the filetype, only allow jpeg and png files to upload: 
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                if (false === $ext = array_search(
                    $finfo->file($_FILES['userImage']['tmp_name']),
                    array(
                        'jpg' => 'image/jpeg',
                        'png' => 'image/png',
                    ),
                    true
                )) {
                    header("Location: settings.php?error=filetype");  
                    exit;
                }

                //if all passed, attempt to insert into database: 
                $sql = "UPDATE $dbName.users SET imagetype = '{$imageProperties['mime']}' , picture = '{$imgData}' WHERE id = :id;";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':id',$userID);
                $userID = $_SESSION['ID'];
                if ($stmt->execute()) {
                    //if succesful, change the seesion image to the new image and return to profile
                    $_SESSION['picture'] = getProfilePic($userID, $db, $dbName); 
                    header("Location: settings.php?succesful=uploaded");
                } else {
                    //give error
                    header("Location: settings.php?error=sqlerror");  
                    exit;
                }        
            }
        }
    }
    