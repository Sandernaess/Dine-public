<?php 
    session_start(); 
    include ("../include/dbh.php");
    include ("functions.php"); 

    //edit the personal info to the user: 
    if (isset($_POST['edit']) && $_POST['edit'] == "personal") {
        $name = $_POST['username']; 
        $real = $_POST['name']; 
        $desc = $_POST['desc']; 

        if (empty($name) || empty($real)) {
            header("Location: settings.php?error=empty"); 
            exit; 
        }

        //check if user attempts to change their username: 
        if ($name != $_SESSION['username']) {
            //check if new username is taken: 
            $check = checkUsername($name, $db); 
            //if null then the username is taken: 
            if ($check) {
                header("Location: settings.php?error=username"); 
                exit; 
            }
        }
    
        //update the database: 
        $sql = "UPDATE users SET username = :uname, realname = :nm, description = :dc WHERE id = :id";
        $stmt = $db->prepare($sql);
        //bind for ny bruker: 
        $stmt->bindParam(':id',$id); 
        $stmt->bindParam(':uname',$name); 
        $stmt->bindParam(':dc',$desc);  
        $stmt->bindParam(':nm',$real);
        $id = $_SESSION['ID']; 

        //execute
        if ($row = $stmt->execute()) {
            $_SESSION['username'] = $name;
            $_SESSION['name'] = $real; 
            $_SESSION['description'] = $desc;
            header("Location: settings.php?succesful=uploaded"); 
        }

    }

