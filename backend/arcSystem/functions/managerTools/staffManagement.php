
    <?php
                    // CREATE NEW STAFF MEMBER
                    if(isset($_POST['registerStaff'])){                    
                            
                                $staffID = "";
                                $SID = 0;
                                $userID= "";
                                $userName = trim(filter_input(INPUT_POST,'userName'));
                                $fullName = trim(filter_input(INPUT_POST,'fullName'));
                                $email = trim(filter_input(INPUT_POST,'email'));
                                $userPassword =trim(filter_input(INPUT_POST,'staffPassword'));
                                $confirmUserPassword = trim(filter_input(INPUT_POST,'confirmStaffPassword'));
                                $userRole = trim(filter_input(INPUT_POST,'userRole'));
                            
                                // check that boxes have been filled in 
                                if( !$userName || !$fullName ||!$email ||!$userPassword ||!$confirmUserPassword || !$userRole) {
                                           
                                     echo "<br>";
                                        echo "<p id='message'>One or more fields are empty.</p>";
                                    return;
                                } else{

                                    try{
                                        $checkUserName = $DB_con->prepare("SELECT user_name FROM users WHERE user_name=:userName");
                                        $checkUserName->execute(array(':userName'=> $userName));
                                        $row=$checkUserName->fetch(PDO::FETCH_ASSOC);

                                        if($row['user_name'] == $userName){
                                             echo "<br>";
                                                echo "<p id='message'>This User Name is already taken</p>";

                                        }else{      
                                                        if( $userPassword != $confirmUserPassword){ // check password match

                                                 echo "<br>";
                                                     echo "<p id='message'>Passwords do not match!</p>";

                                                return; 
                                            }
                                            else {
                                                // escape special characters in a string for use in the SQL statement 
                                                $userPassword = md5($userPassword);
                                           } 

                                         if($manager->registerStaff($userID,$SID,$staffID,$userName,$fullName,$email,$userPassword,$userRole)){

                                                $manager->redirect('home.php');

                                           }

                                        }  
                                    }catch(PDOException $e){

                                        echo $e->getMessage();

                                    }
                                }
                              }

           
     



                