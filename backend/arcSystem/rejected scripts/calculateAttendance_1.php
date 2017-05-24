<?php

class user{
    private $db;

    function __construct($DB_con){
        
        $this->db = $DB_con;
        
    }

            $userChoice = $_POST['moduleSelect'];

                    if($userChoice >=1 && $userChoice <= 1000){

                    moduleAttendanceStudent(); // call function     

                    }else if($userChoice == "Overall"){

                        overallAttendanceStudent(); // call function overall

                    }

                    function moduleAttendanceStudent(){

                    //connect to DB    
                    $dsn = 'mysql:host=localhost;dbname=angliaruskincollege';
                    $user = 'root';
                    $password = 'password';

                    try{
                        $db = new PDO( $dsn, $user, $password);
                    } catch (PDOException $e){

                        die('Sorry DB connection has failed');

                    }

                        $module = $_POST['moduleSelect'];
                        $student = $_POST['studentid']; 

                    $studentsTallyQuery = "SELECT * FROM attendance INNER JOIN sessions ON sessions.session_id = attendance.session_id WHERE sessions.module_id = $module AND attendance.student_id=$student AND attendance.attended = 'YES' ";
                    $possibleAttendanceQuery  = "SELECT * FROM attendance INNER JOIN sessions ON sessions.session_id = attendance.session_id WHERE sessions.module_id = $module AND attendance.student_id= $student";


                     $possibleAttendanceResult = $db->prepare($possibleAttendanceQuery);
                     $studentsTallyResult = $db->prepare($studentsTallyQuery) ;

                     $possibleAttendanceResult->execute();
                     $studentsTallyResult->execute();

                     $paNumTotal = $possibleAttendanceResult->rowCount();
                     $stNumTotal = $studentsTallyResult->rowCount();

                    $attendance = ($stNumTotal / $paNumTotal ) * 100;
                    echo $attendance, "%";


                    }

                    function overallAttendanceStudent(){

                    //connect to DB    
                    $dsn = 'mysql:host=localhost;dbname=angliaruskincollege';
                    $user = 'root';
                    $password = 'password';

                    try{
                        $db = new PDO( $dsn, $user, $password);
                    } catch (PDOException $e){

                        die('Sorry DB connection has failed');

                    }

                        $student = $_POST['studentid']; 

                    $studentsTallyQuery = "SELECT * FROM attendance INNER JOIN sessions ON sessions.session_id = attendance.session_id WHERE  attendance.student_id=$student AND attendance.attended = 'YES' ";
                    $possibleAttendanceQuery = "SELECT * FROM attendance INNER JOIN sessions ON sessions.session_id = attendance.session_id WHERE attendance.student_id= $student";


                     $possibleAttendanceResult = $db->prepare($possibleAttendanceQuery);
                     $studentsTallyResult = $db->prepare($studentsTallyQuery) ;

                     $possibleAttendanceResult->execute();
                     $studentsTallyResult->execute();

                     $paNumTotal = $possibleAttendanceResult->rowCount();
                     $stNumTotal = $studentsTallyResult->rowCount();





                    $attendance = ($stNumTotal / $paNumTotal) * 100;
                    echo $attendance, "%";


                    }

