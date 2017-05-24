<?php
        if(isset($_POST['createSession'])){
                 createClassSession();      
        }
        
            function createClassSession(){

                        //connect to DB    
                    $dsn = 'mysql:host=localhost;dbname=angliaruskincollege';
                    $user = 'root';
                    $password = 'password';

                    try{
                        $db = new PDO( $dsn, $user, $password);
                    } catch (PDOException $e){
                        die('Sorry DB connection has failed');
                    }

                        $sessionID = " ";
                        $groupID = $_POST['groupID'];
                        $staffID = $_POST['staffID'];
                        $roomID = $_POST['roomID'];
                        $moduleID = $_POST['moduleID'];
                        $sessionDate = $_POST['sessionDate'];
                        $sessionStartTime = $_POST['sessionStartTime'];
                        $sessionEndTime = $_POST['sessionEndTime'];
                        $classID = $_POST['classID'];

                        $createClassSessionQuery = " INSERT INTO sessions VALUES('". $sessionID ."','". $groupID ."','". $staffID ."', '". $roomID ."','". $moduleID ."', '". $sessionDate ."', '". $sessionStartTime ."', '". $sessionEndTime ."', '". $classID ."')";
                        $createClassSessionResult = $db->query($createClassSessionQuery);

                        if($createClassSessionResult){
                            echo 'Class Session Was created', "<br>";
                                createAttendanceCard();
                           }else{
                            echo 'Class session failed to be created';
                        }

            }
/*
            function createAttendanceCard(){
                        //connect to DB    
                    $dsn = 'mysql:host=localhost;dbname=angliaruskincollege';
                    $user = 'root';
                    $password = 'password';

                    try{
                        $db = new PDO( $dsn, $user, $password);
                    } catch (PDOException $e){
                        die('Sorry DB connection has failed');
                    }

                  $groupID = $_POST['groupID'];  
                  $attendanceCardID="";
           //       $studentID = 62;
                  $attended = "";
                  $link = mysqli_connect('localhost','root','password','angliaruskincollege');  
                  $sessionIDQuery = "SELECT session_id FROM sessions ORDER BY session_id DESC LIMIT 1";
                  $sessionIDResult = mysqli_query($link,$sessionIDQuery);

                  // Find the Newly created session ID a put it on the attendance card.

                    $sessionIDB = "";
                    while ($row = mysqli_fetch_array($sessionIDResult)){
                        $sessionIDB .= $row['session_id'] . ", ";                
                    }
                    $sessionIDB = substr($sessionIDB, 0, -2);

                // find the students that belong to the groupID selected in the form. 

                    $studentIDsQuery = "SELECT student_id FROM student_groups WHERE group_id = $groupID ";
                    $studentIDsResult = mysqli_query($link, $studentIDsQuery);

                    $studentID = "";
                    while($row = mysqli_fetch_array($studentIDsResult)){
                        $studentID .= $row['student_id'] . ", ";
                    }
                    $studentIDa = substr($studentID, 0, -6); //views first id
                    $studentIDb = substr($studentID, 2, -2); // views second id

                    echo $studentIDa;
                    echo $studentIDb;

                     // create the attendance card based on the variable set above   
                     $createAttendanceCard = "INSERT INTO attendance VALUES('" . $attendanceCardID . "', '". $sessionIDB ."', '".$studentIDa."','".$attended."')";
                     $createAttendanceCard2 = "INSERT INTO attendance VALUES('" . $attendanceCardID . "', '". $sessionIDB ."', '".$studentIDb."','".$attended."')";
                     $result1 = $db->query($createAttendanceCard); 
                     $result2 = $db->query($createAttendanceCard2);      

                    if($result){

                                   echo "Attendance Card Created!", "<br>";
                                   header("Location: managerPage");     
                                   // stops the session and Attendance card from being created again if the page is refreshe 
                                   //redirecting clears the details 

                             }else{

                      echo "Attendance Card Not created";
                  }       
            
              
            }
    */


