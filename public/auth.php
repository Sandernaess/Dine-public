<?php 
    //This handles the login and registration of users
    session_start(); 
    include ("../include/dbh.php");
    include ("functions.php"); 

    //login: 
    if (isset($_POST['login']) && $_POST['login']=="user") {
        $username = $_POST['username']; 
        $password = $_POST['password']; 
        if (empty($username) || empty($password)) {
            header("Location: login.php?error=empty"); 
            exit; 
        }

        //Sql to check the database: 
        $sql = "SELECT * FROM $dbName.users WHERE username = :usn AND pwd = BINARY :pw";
        $stmt = $db->prepare($sql); 
        //bind: 
        $stmt->bindParam(':usn', $username); 
        $stmt->bindParam('pw', $password); 
        
        //Salt the password and hash: 
        $password = sha1($salt.$password); 
        $stmt->execute(); 

        //check if the combination exists: 
        if ($row = $stmt->fetch()) {
            //succesful login: 
            //grab the different info to the user from DB and store in sessions:
            $id = $row['id']; 
            $_SESSION['ID'] = $id;  
            $_SESSION['username'] = $row['username']; 
            $_SESSION['name'] = $row['realname']; 
            $_SESSION['picture'] = getProfilePic3($id, $db, $dbName); 
            $_SESSION['description'] = $row['description']; 
            //go to start page: 
            header("Location: index.php"); 

        } else {
            //give error to user: 
            header("Location: login.php?error=wrongpwd"); 
            exit; 
        }
    }

    //Sign up/registration of users: 
    if (isset($_POST['register']) && $_POST['register'] == "user-register") {
        $username = $_POST['username']; 
        $password = $_POST['password']; 
        $pwRepeat = $_POST['password-repeat']; 
        $name = $_POST['name']; 
        
        //first check for empty inputs: 
        if (empty($username) || empty($password) || empty($pwRepeat) || empty($name)) {
            header("Location: signup.php?error=empty"); 
            exit; 
        //check password length: 
        } elseif (strlen($password) < 6) {
            header("Location: signup.php?error=pwdlength");
            exit; 
        //check if passwords match: 
        } elseif ($password != $pwRepeat) {     
            header("Location: signup.php?error=pwd");
            exit; 
        } 

        //Check if username has already been taken: 
        $check = checkUsername($username, $db, $dbName); 
        if ($check == true) {
            header("Location: signup.php?error=username");
            exit;
        }
        
        //If all checks clear, then we can register the user: 
        $sql = "INSERT INTO $dbName.users(username,pwd,realname) VALUES(:usr, :pwd, :rn);"; 
        $stmt = $db->prepare($sql); 
        //binds: 
        $stmt->bindParam(':usr', $username); 
        $stmt->bindParam(':pwd', $password); 
        $stmt->bindParam(':rn', $name); 
        //Here we add the salt and hash the password before we insert into the database: 
        $password = sha1($salt.$password);  

        if ($row = $stmt->execute()) {
            //succesful registration, with auto-login the user: 
            $_SESSION['ID'] =  $db->lastInsertId(); //here we grab the created ID to the user
            $_SESSION['username'] = $username; 
            $_SESSION['name'] = $name; 
            header("Location: index.php");

        } else {
            //Not succesful registration: 
            header("Location: signup.php?error=sqlerror");
        }
    }

 




