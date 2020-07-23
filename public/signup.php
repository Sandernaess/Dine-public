<?php 
    include("functions.php"); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- General CSS --> 
    <link rel="stylesheet" type="text/css" href="css/styling.css">
    <!-- CSS for index -->
    <link rel="stylesheet" type="text/css" href="css/signup.css">
    <title>Dine | Register</title>
    <link rel="icon" href="img/chef7.svg">
</head>
<body onload="focus()">
    <!-- Nav -->
    <?php 
      include("../include/nav.php");
    ?>
    <section class="under-nav">
        <h3>Sign Up</h3>
    </section>
    <main>
        <section class="register-box">    
            <h2>Sign Up</h2>
            <p>For this demo, you can also log into a demo account instead if you want to.</p>
            <?php 
                //this checks for errors: 
                if (isset($_GET['error'])) {
                    $error = error($_GET['error']);
                    if (!empty($error)) {
                        echo("<p class='error-message'> <img class='icon' src='img/error.svg' alt=''> $error </p>"); 
                    }    
                }    
            ?>
            <!-- Register form -->
            <form action="auth.php" method="POST">
                <label for="username">Username</label>
                <input name="username" id="username" type="text" placeholder="Username" required>
                
                <label for="username">Real name</label>
                <input name="name" type="text" placeholder="Real Name" required>

                <label for="password">Password</label>
                <input onkeyup="test(), test2()" id="password" name="password" type="password" placeholder="Type in password">
                <p id="password-rule" class="password-rule"></p>

                <label for="password-repeat">Repeat password</label>
                <input onkeyup="test2()" name="password-repeat" id="password2" type="password" placeholder="Repeat password">
                <p id="password-rule2" class="password-rule"></p>

                <p>Already have an account? <a href="login.php">Log in</a></p>
                <button value="user-register" name="register" class="btn dark">Sign Up</button>
            </form>
        </section>
    </main>

    <?php 
        include("../include/footer.php");
    ?>
    <script src="js/register.js"></script>
</body>
</html>