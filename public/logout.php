<?php 
    //this file logs out the user
     
    session_start();
    //destroy all the sessions: 
    session_destroy(); 
    //go back to start page: 
    header("Location: index.php"); 


