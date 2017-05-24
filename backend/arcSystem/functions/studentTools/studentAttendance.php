<?php

                                    if(isset($_POST['attendanceBtn'])){
                                            $userChoice = trim(filter_input(INPUT_POST, 'moduleSelect'));
                                            $module = trim(filter_input(INPUT_POST, 'moduleSelect'));
                                            $studentID = trim(filter_input(INPUT_POST,'studentid'));                            
                                    } 