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
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <title>Dine | Login</title>
    <link rel="icon" href="img/chef7.svg">
</head>

<body onload="focus()">
    <!-- Nav -->
    <?php 
      include("../include/nav.php");
    ?>
    <section class="under-nav">
        <h3>Login</h3>
    </section>
    <main>
        <section class="login-box">
            <!-- Login part -->
            <article class="login">
                <h2>Login</h2>
                <?php 
                //this checks for errors: 
                if (isset($_GET['error'])) {
                  $error = error($_GET['error']);
                  if (!empty($error)) {
                      echo("<p class='error-message'> <img class='icon' src='img/error.svg' alt=''> $error </p>"); 
                  }    
                }    
            ?>
                <!-- Login Form -->
                <form action="auth.php" method="POST">
                    <label for="username">Username</label>
                    <input value="Demo" name="username" id="username" type="text" placeholder="Username" required>
                    <label for="username">Password</label>
                    <input value="Demo123" name="password" type="password" placeholder="Password" required>
                    <p><a href="">Forgot your password?</a></p>
                    <button value="user" name="login" class="btn dark">LOGIN</button>
                </form>
            </article>

            <!-- Sign Up part, if no exisiting account -->
            <article class="sign-up">
                <h2>No Account?</h2>
                <p>Create an account to share your own recipes and save your favorites.</p>
                <a href="signup.php"><button class="btn white">SIGN UP</button></a>
            </article>
        </section>
    </main>

    <?php 
        include("../include/footer.php");
    ?>
    <script src="../js/login.js"></script>
</body>

</html>