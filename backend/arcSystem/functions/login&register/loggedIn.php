<?php

// setting the loggedin session ID 
$user_name = $_SESSION['user_session'];
    
    $selectUsername = $DB_con->prepare("SELECT * FROM users WHERE user_name=:username");
    $selectUsername->execute(array(":username"=>$user_name));
    $userRow=$selectUsername->fetch(PDO::FETCH_ASSOC);
    




