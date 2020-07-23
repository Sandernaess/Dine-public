<?php 
    //this file contains different functions: 

    //function for creating errors to the user: 
    function error($get) {
        $error = ""; 
        switch($get) {  
            case "wrongpwd": 
                $error = "No user found for this username/password";
                break; 
            case "empty": 
                $error = "Fill in all the inputs"; 
                break;
            case "pwd": 
                $error = "Passwords do not match"; 
                break;
            case "pwdlength": 
                $error = "Password must be over 6 characters long";
                break; 
            case "username": 
                $error = "Username is already in use"; 
                break; 
            case "sqlerror": 
                $error = "Sorry, an error has occured. Please try again"; 
                break; 
            default: 
                $error = "";
                break; 
        }
        return $error; 
    }

    //this checks the username: 
    function checkUsername($username, $db, $dbName) {
        $check = false; 
        //Check if username has already been taken: 
        $sql = "SELECT username from $dbName.users WHERE username = :usr"; 
        $stmt = $db->prepare($sql); 
        //bind: 
        $stmt->bindParam(':usr', $username);    
        $stmt->execute(); 

        //if username exists, row will be 1: 
        if ($stmt->rowCount() > 0) {
            //username is in use:  
            $check = true; 
        }
        return $check; 
    }

    function getUsername($id, $db, $dbName) {
        $username = "unknown";
        $sql = "SELECT username from $dbName.users WHERE id = :id";
        $stmt = $db->prepare($sql); 
        $stmt->bindParam(':id', $id);
        $stmt->execute(); 
        if ($row = $stmt->fetch()) {
            $username = $row['username']; 
        }
        return $username; 
    }
   
    //function for getting profile pictures: 
    function getProfilePic($id, $db, $dbName) {
        $p = null; 
        $sql = "SELECT picture, imagetype FROM $dbName.users WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);
        if ($row = $stmt->execute()) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
                $p = $row['picture'];
                return $p;
            }
        } 
        return $p;
    }

    function getRecipePic($id, $db, $dbName) {
        $p = null; 
        $sql = "SELECT picture, imagetype FROM $dbName.recipe WHERE idrecipe = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);
        if ($row = $stmt->execute()) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
                $p = $row['picture'];       
            }
        }
        return $p;
    }

?>
