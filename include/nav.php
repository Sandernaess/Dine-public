<nav>
    <article>
        <a class="logo" href="index.php">Dine</a>
    </article>

    <article class="nav-links">
        <?php 
      if (isset($_SESSION['ID'])) {
        ?>
        <a href="profile.php">
        <?php 
          if (isset($_SESSION['picture'])) {
              echo('<img class="nav-picture" src="data:image/jpeg;base64,'.base64_encode($_SESSION['picture']).'"/>');
          } else {
              echo('<img class="nav-picture" src="img/profile-picture.png" />');
          }
        ?>
        <a href='#'> My recipes </a>
        <a href='logout.php'> Log out </a>
        <?php 
      } else {
        echo("<a id='login' href='login.php'> Login</a>");
        echo("<a id='signup' href='signup.php'> Signup </a>"); 
        echo("<a href='#'> About </a>"); 
      }
    ?>
    </article>

</nav>

<!-- the navbar for mobile -->
<nav class="mobile-nav">
    <article class="mobile-logo">
        <a class="logo" href="index.php">Dine</a>
    </article>

    <article class="hamburger-menu">
        <?php 
            if (isset($_SESSION['ID'])) {
        ?>
        <a href="profile.php"><img class="nav-picture" src="<?php if (isset($_SESSION['picture'])) {
            echo $_SESSION['picture']; } else {
            echo ("img/profile-picture.jpg");
            } ?>" alt=""></a>
        <?php 
            }
        ?>
        <img onclick="openNav()" class="hamburger" src="img/hbmenu.svg" alt="">
    </article>
</nav>

<!-- the menu that opens for for mobile -->
<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <article class="hamburger-links">
    <?php 
      if (isset($_SESSION['ID'])) {
        ?>
        <a href='profile.php'> <?php echo($_SESSION['username']); ?> </a>
        <a href='#'> My recipes </a>
        <a href='logout.php'> Log out </a>
        <?php 
      } else {
        echo("<a href='login.php'> Login</a>");
        echo("<a href='signup.php'> Signup </a>"); 
        echo("<a href='#'> About </a>"); 
      }
    ?>
    </article>
</div>