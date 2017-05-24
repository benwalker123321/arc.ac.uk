<?php
    
    session_start();
    $error= "";
    
    if(isset($_POST['submit'])){
                //check fields posted were not empty
           if(empty($_POST['username']) || empty($_POST['password'])){
               
                        $error = "You did no enter either username or password ";
           }else{
               
               $username=$_POST['username'];
               $password=$_POST['password'];
               
               
               //connect to server
               $db = mysql_connect("localhost","root","password"); 
               
               //securing against SQL injection
               $username = stripslashes($username); //unquoted the string
               $password = stripslashes($password);
               $username = mysql_real_escape_string($username); // escaping the special characters in string for SQL statments
               $password = mysql_real_escape_string($password);
               
                //connect database
               $db= mysql_select_db("angliaruskincollege", $connection);
               //check username and password valid in db
               $query = mysql_query("SELECT * from students where password='$password' AND user_name='$username'", $connection);
               $rows = mysql_num_rows($query);
               
               if ($rows == 1){
                   
                   $_SESSION['login_user']=$username;
                   header("Location: ../../../../../xampp/arc.ac.uk/index.php ");
               }else{
                   
                  echo $error = "Username or password is invalid";
                
               }
          //     mysql_close($connection);
                       
               
           } 
    
           
    
    }
    