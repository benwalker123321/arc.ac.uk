<?php
defined('BASEPATH') OR exit('No direct script access allowed');

 include_once 'backend/arcSystem/core/dbConfig.php';
 include_once 'backend/arcSystem/functions/admin/authoriseLecturer.php'; 
 
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?=base_url()?>public/styles/bootstrap-3.3.6/bootstrap-3.3.6/favicon.ico">

    <title>ARC Lecturer Attendance Info</title>
    
     <link href="<?=base_url()?>public/styles/main.css" type=text/css rel="stylesheet">
     <link href="<?=base_url()?>public/styles/lecturerAttendanceInfo.css" type=text/css rel="stylesheet">
     
     <script src="<?=base_url()?>public/scripts/attendanceInfo.js"></script>

    <!-- Bootstrap core CSS -->
    <link href="<?=base_url()?>public/styles/bootstrap-3.3.6/bootstrap-3.3.6/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="<?=base_url()?>public/styles/bootstrap-3.3.6/bootstrap-3.3.6/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?=base_url()?>public/styles/bootstrap-3.3.6/bootstrap-3.3.6/docs/examples/starter-template/starter-template.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="<?=base_url()?>public/styles/bootstrap-3.3.6/bootstrap-3.3.6/assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
         <a class="navbar-brand" href="../../../../../xampp/arc.ac.uk/index.php/">ARC</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
                            <?php
            include_once 'backend/arcSystem/functions/admin/authoriseContent.php';      
	if($user->is_loggedin()){
            
	?> 

            <?php     
         if ($roleIDa == "2"){   
         
         ?>
          <li><a href="../../../../../xampp/arc.ac.uk/index.php/lecturerHomePage">Home</a></li> 
          <li><a href="../../../../../xampp/arc.ac.uk/index.php/courses">Courses</a></li>
          <li class="active"><a href="../../../../../xampp/arc.ac.uk/index.php/lecturerAttendanceInfo"> Attendance Information </a></li> 
          <li><a href="../../../../../xampp/arc.ac.uk/index.php/lecturerClassRegistration"> Class Registration</a></li> 
          <li><a href="../../../../../xampp/arc.ac.uk/index.php/lecturerTimetable"> Timetable</a></li> 
        <?php
         }
        }  
 ?>
          
          </ul>
                    <?php 

                    if($user->is_loggedin()){
                        include_once 'backend/arcSystem/functions/login&register/loggedIn.php';
                        ?>
         <label id="welcomeLbl"> Welcome <?php print($userRow['user_name']); ?> </label>
         <?php   
                                echo '<br>';
                        ?>
                   <label id="logoutLbl"><a href="<?=base_url()?>../../../../../xampp/arc.ac.uk/index.php/logout?logout=true "><i class="glyphicon glyphicon-log-out"></i> Logout</a></label>
                 <?php
                    }else{
                      ?>
                      <label id="welcomeLbl">Welcome Guest</label>
                      <?php
                    }  
            ?>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
        
      <div id="content">
      
        <h1>ARC Lecturer Attendance Information</h1>

         <table id="attendanceInfoNavTable" border="2">

                                 <tr>
                                     <th> Attendance Topics</th> 
                                 </tr>
                                 
                                 <tr>
                                     <td><button type="button" id="moduleAttendance" onclick="viewModuleAttendance()"> Module Attendance</button> </td>
                                 </tr>
                                 
                                  <tr>
                                      <td><button type="button" id="groupAttendance" onclick="viewGroupAttendance()"> Group Attendance</button> </td>
                                 </tr>
                                 
                                  <tr>
                                      <td><button type="button" id="studentAttendance" onclick="viewStudentAttendance()"> Student Attendance</button> </td>
                                 </tr>
                             </table>

                          <center>      
                         <form method="post" id="viewModuleAttendanceForm">
                                                        <h3> Module Attendance</h3>
                             <select id="selectModule" name="selectModule">

                             <option>Please choose a Module </option>

                                    <?php
                                            $staffID = $userRow['staff_id'];
                                            $lecturer->loadLecturerModules($staffID); 
                                    ?>

                             </select>
                             
                                      <input type="radio" hidden name="staffID" id="staffID" value="<?php  include_once 'backend/arcSystem/functions/login&register/loggedIn.php'; print ($userRow['staff_id'])?>" checked>         
                                      <br> <br>
                                      <input type="submit" id="selectModuleBtn" name="selectModuleBtn" value="Confirm Module Selection">

                             </form>


                         <form method="post" id="viewClassGroupSessionAttendanceForm">
                                                        <h3> Group Attendance</h3> 
                             <select id="selectClass" name="selectClass">

                             <option>Please choose a Group </option>
                                <?php 
                                        $staffID = $userRow['staff_id'];
                                        $lecturer->loadLecturerGroups($staffID); 
                                ?>
                             </select>
                             
                                      <input type="radio" hidden name="staffID" id="staffID" value="<?php  include_once 'backend/arcSystem/functions/login&register/loggedIn.php'; print ($userRow['staff_id'])?>" checked>         
                                      <br> <br>
                                      <input type="submit" id="selectClassGroupBtn" name="selectClassGroupBtn" value="Confirm Group Selection">

                             </form>
                 
                                                               
                         <form method="post" id="viewStudentAttendanceForm">   
                                                     <h3>  Students Attendance</h3> 
                                                    Select One of your Students ID <br>
                                                    <select id="selectStudent" name="selectStudent">
                                                        <option> Select a student </option>
                                                        
                                                        <?php
                                                            $staffID = $userRow['staff_id'];    
                                                            $lecturer->loadLecturerStudents($staffID); 
                                                        
                                                        ?>
                                                     </select>   
                             
                             <input type="radio" hidden name="staffID" id="staffID" value="<?php  include_once 'backend/arcSystem/functions/login&register/loggedIn.php'; print ($userRow['staff_id'])?>" checked>
                             <br>
                             <input type="submit" id="viewStudentAttendanceBtn" name="viewStudentAttendanceBtn" value="View Student Attendance">
            
                         </form>
                      </center> 
        
                          <?php	include_once 'backend/arcSystem/functions/lecturerTools/attendanceInfo.php'; ?>					
                                                                                     
        
      </div>
        
  
        


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?=base_url()?>https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="<?=base_url()?>public/styles/bootstrap-3.3.6/bootstrap-3.3.6/dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?=base_url()?>public/styles/bootstrap-3.3.6/bootstrap-3.3.6/assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
