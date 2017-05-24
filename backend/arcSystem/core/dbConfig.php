<?php
        // STARTS SESSION 
        session_start();
        //SETTING UP DATABASE USING PDO    
        $DB_host = "localhost";
        $DB_user = "root";
        $DB_pass = "password";
        $DB_name = "angliaruskincollege";

            try{
                $DB_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}",$DB_user,$DB_pass);
                $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $e){
                echo $e->getMessage();
            }
                // AUTOLOADING CLASS SCRIPTS
        spl_autoload_register(function ($class_name) {
             include  '/../classes/'.$class_name . 'Class.php';
        });
                // CREATING CLASS DB CONNECTIONS 
                $user = new user($DB_con);
                $student = new student($DB_con);
                $lecturer = new lecturer($DB_con);
                $manager = new manager($DB_con);    
