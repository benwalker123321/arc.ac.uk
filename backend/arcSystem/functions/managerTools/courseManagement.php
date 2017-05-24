        <?php
                        // ADD COURSE
                        if(isset($_POST['addCourse'])){
                                 echo  "<style> form#addCourseForm{                 
                                             display:inline;
                                       }</style> "; 
                            $courseID= "";
                            $courseName = trim(filter_input(INPUT_POST,'courseName'));
                            $degreeType = trim(filter_input(INPUT_POST,'degreeTypeSelect'));;     
                            if(!$courseName || !$degreeType){
                               echo "<br>";     
                               echo "<p id='message'>Enter all details </p>";
                            }else{

                                         try{

                                            $checkCourseQuery = $DB_con->prepare(" SELECT * FROM courses WHERE course_name= '$courseName' AND degree_id= '$degreeType' ");
                                            $checkCourseQuery->execute();
                                            $checkCourse = $checkCourseQuery->rowCount(); 

                                            if($checkCourse > 0){
                                                echo "<br>";     
                                                 echo "<p id='message'>This Course already exists!</p>";

                                            }else{
                                                
                                                if($manager->addCourse($courseID,$courseName,$degreeType)){}
                                                        
                                                        echo "<br>";     
                                                        echo "<p id='message'>The Course has been Added to The Unviersity Database</p>";
                                                      
                                                }

                                            }  
                                        catch(PDOException $e){

                                            echo $e->getMessage();

                                        }
                            }
                                                    //Some of the code is copied over too the view pages so the feedback in it a better place
                        }

                                // ADD MODULE
                                if(isset($_POST['addModule'])){
                                     echo  "<style> form#addModuleForm{                 
                                             display:inline;
                                       }</style> "; 

                                    $moduleID= "";
                                    $moduleCode = trim(filter_input(INPUT_POST,'moduleCode'));
                                    $moduleName = trim(filter_input(INPUT_POST,'moduleName'));

                                    if(!$moduleCode || !$moduleName){
                                          echo "<br>";     
                                          echo "<p id='message'>Enter All Fields!</p>";
                                    }else{

                                                 try{

                                                    $checkModuleCodeQuery = $DB_con->prepare("SELECT module_code FROM modules WHERE module_code=:moduleCode");
                                                    $checkModuleCodeQuery->execute(array(':moduleCode'=> $moduleCode));
                                                    $MCrow=$checkModuleCodeQuery->fetch(PDO::FETCH_ASSOC);

                                                    if($MCrow['module_code'] == $moduleCode){
                                                      echo "<br>";     
                                                      echo "<p id='message'>This Module Code has already been taken</p>";

                                                    }else if($MCrow['module_code'] != $moduleCode) { 

                                                        if($manager->addModule($moduleID,$moduleCode,$moduleName)){

                                                            $manager->addModule();           
                                                        }

                                                       echo "<br>";     
                                                         echo "<p id='message'> This Module has been Added to The Unviersity Database</p>";

                                                        }

                                                    }  
                                                catch(PDOException $e){

                                                    echo $e->getMessage();

                                                }
                                     }

                                }

                                    // PUT A MODULE ON A COURSE BY LINKING
                if(isset($_POST['createCourseModLink'])){
                             echo  "<style> form#createCourseModuleLinkForm{                 
                                             display:inline;
                                       }</style> "; 
                    $moduleID= trim(filter_input(INPUT_POST,'moduleID'));
                    $courseID = trim(filter_input(INPUT_POST,'courseID'));
                    $year = trim(filter_input(INPUT_POST,'yearSelect'));
                    $semTri = trim(filter_input(INPUT_POST,'semTriSelect'));
                        if(!$moduleID || !$courseID || !$year || $semTri){

                            echo "<br>";     
                               echo "<p id='message'>Enter All Fields!</p>";
                             
                        }else{

                                 try{

                                    $checkRelationshipExistsQuery = $DB_con->prepare("SELECT module_id,course_id FROM course_modules WHERE module_ID='$moduleID' AND course_id='$courseID' AND year='$year' AND semester_trimester='$semTri'");
                                    $checkRelationshipExistsQuery->execute();
                                    $checkCourseModuleRelationship = $checkRelationshipExistsQuery->rowCount();

                                    if($checkCourseModuleRelationship > 0){
                                     echo "<br>";     
                                          echo "<p id='message'>This Course and Module relationship already exists check the year and semester or trimester are right.</p>";

                                    }else{ 

                                        if($manager->createCourseModuleLink($moduleID,$courseID,$year,$semTri)){}


                                        echo "<br>";     
                                            echo "<p id='message'>This Course and Module Link has been Added to The Unviersity Database</p>";
                                       
                                        }

                                    }  
                                catch(PDOException $e){

                                    echo $e->getMessage();

                                }

                    }

                }
                
                        // VIEW ALL UNIVERSITY COURSES
                      if(isset($_POST['viewCourses'])){
                           echo  "<style> form#viewCoursesForm{                 
                                             display:inline;
                                       }</style> "; 

                            $numResults = trim(filter_input(INPUT_POST,'numResults'));

                            if(!$numResults){

                              echo "<br>";     
                               echo "<p id='message'>Enter a Number!</p>";

                            } else{

                                   if($manager->viewCourses($numResults)){}
                                    

                                }     
                             }
                             
                                    // VIEW ALL UNIVERSITY MODULES
                                   if(isset($_POST['viewModules'])){
                                    echo  "<style> form#viewModulesForm{                 
                                             display:inline;
                                       }</style> ";      
                            $numResults = trim(filter_input(INPUT_POST,'numResults'));

                            if(!$numResults){

                                echo "<br>";     
                               echo "<p id='message'> Enter a Number!</p>";

                            } else{

                                   if($manager->viewModules($numResults)){}   

                                }     
                             }

                              // VIEW COURSES AND THEIR MODULES
                              if(isset($_POST['viewCoursesModules'])){
                                     echo  "<style> form#viewCourseModulesForm{                 
                                             display:inline;
                                       }</style> "; 
                                    $courseID = trim(filter_input(INPUT_POST,'courseID'));

                                    if(!$courseID){

                                       echo "<br>";     
                               echo "<p id='message'>Enter A Course ID!</p>";
                                    }else{

                                 try{

                                    $checkCourseExistsQuery = $DB_con->prepare("SELECT course_id FROM courses WHERE course_id=:courseID");
                                    $checkCourseExistsQuery->execute(array(':courseID'=> $courseID));
                                    $CErow=$checkCourseExistsQuery->fetch(PDO::FETCH_ASSOC);

                                    if($CErow['course_id'] == $courseID){
                                       echo "<br>";     
                                        echo "<p id='message'>This Course exists </p>";
                                        if($manager->viewCourseModules($courseID)){}

                                        
                                        
                                    }else if($CRErow['course_id'] != $courseID) { 
                                        echo "<br>";     
                                             echo "<p id='message'>The Course ID you entered does not exist</p>";

                                        }

                                    }  
                                catch(PDOException $e){

                                    echo $e->getMessage();

                                }

                    }

                }       

                        // VIEW COURSES THART FEATURE THE SELECTED MODULE
                        if(isset($_POST['viewModulesCourses'])){
                                     echo  "<style> form#viewModulesCoursesForm{                 
                                             display:inline;
                                       }</style> "; 

                                    $moduleID = trim(filter_input(INPUT_POST,'moduleID'));

                                    if(!$moduleID){

                                      echo "<br>";     
                                             echo "<p id='message'>Enter A Module ID!</p>";
                                    }else{

                                 try{

                                    $checkModuleExistsQuery = $DB_con->prepare("SELECT module_id FROM modules WHERE module_id=:moduleID");
                                    $checkModuleExistsQuery->execute(array(':moduleID'=> $moduleID));
                                    $MErow=$checkModuleExistsQuery->fetch(PDO::FETCH_ASSOC);

                                    if($MErow['module_id'] == $moduleID){
                                        echo "<br>";     
                                         echo "<p id='message'>This module exists</p>";
                                        if($manager->viewModulesCourses($moduleID)){}

                                    }else if($MErow['module_id'] != $moduleID) { 
                                        echo "<br>";     
                                          echo "<p id='message'>The Module ID you entered does not exist </p>";

                                        }

                                    }  
                                catch(PDOException $e){

                                    echo $e->getMessage();

                                }

                    }

                }       