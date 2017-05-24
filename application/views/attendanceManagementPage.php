<?php
defined('BASEPATH') OR exit('No direct script access allowed');
        include_once 'backend/arcSystem/core/dbConfig.php';
        include_once 'backend/arcSystem/functions/admin/authoriseManager.php';
           
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

    <title>ARC Attendance Management</title>
    
     <link href="<?=base_url()?>public/styles/main.css" type=text/css rel="stylesheet">
     <link href="<?=base_url()?>public/styles/attendancemanagement.css" type=text/css rel="stylesheet">
     <script src="<?=base_url()?>public/scripts/attendanceManagement.js"></script>
    <!-- Bootstrap core CSS ------->
    
    <link href="<?=base_url()?>public/styles/main.css" type=text/css rel="stylesheet">
    
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
                   if($roleIDa == "3") {
                   ?> 
                     <li><a href="../../../../../xampp/arc.ac.uk/index.php/managementHomePage">Home</a>
                     <li><a href="../../../../../xampp/arc.ac.uk/index.php/studentManagementPage">Student Management</a></li> 
                     <li><a href="../../../../../xampp/arc.ac.uk/index.php/staffManagementPage">Staff Management</a></li> 
                     <li><a href="../../../../../xampp/arc.ac.uk/index.php/courseManagementPage">Course Management</a></li> 
                     <li><a href="../../../../../xampp/arc.ac.uk/index.php/classManagementPage">Class Management</a></li> 
                     <li class="active"><a href="../../../../../xampp/arc.ac.uk/index.php/attendanceManagementPage">Attendance Management</a></li>              
                     
                     </li> 

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
           
        <h1>ARC Attendance Management</h1>
             
        <table id="attendanceManagementNavTable" border="2">
            
                                 <tr>
                                     <th> Attendance Management</th> 
                                 </tr>
         
                                  <tr>
                                     <td><button type="button" id="viewModuleAttendanceBtn" onclick="viewOverallModuleClassTypeAttendanceForm()"> View Module Attendance</button> </td>
                                 </tr>
                                 
                                  <tr>
                                      <td><button type="button" id="viewRoomUsageBtn" onclick="viewRoomUsageForm()">View A Rooms Usage</button> </td>
                                 </tr>
                                 
                                     <tr>
                                        <td><button type="button" id="amendStudentAttendanceStatusBtn" onclick="viewAmendStudentAttendanceStatusForm()">   Amend A Students Attendance</button> </td>
                                     </tr>
                                     
                                     <tr>
                                        <td><button type="button" id="viewStudentAttendanceBtn" onclick="viewViewStudentAttendanceForm()">   View Students Attendance</button> </td>
                                     </tr>
               
        </table>    

               <center>
                    <form method="post"  id="overallClassTypeModuleAttendanceForm">

                        <h3> View Module Class Type Attendance</h3>
                                       Enter Module ID <br>
                        <input type="text" id="moduleID" name="moduleID"> <br>
                                       Choose a Class Type <br>
                       <input type="radio" id="lecture" name="choice" value="1"> Lecture <br>
                          <input type="radio" id="lab" name="choice" value="2"> Lab  <br>
                       <input type="radio" id="seminar" name="choice" value="2"> Seminar <br>

                      <input type="submit" id="viewModuleSessionsAttendance" name="viewModuleSessionsAttendanceBtn" value="View Attendance" >

                    </form>           
    
        
        <form method="post" id="changeStudentAttendanceStatusForm">
                            <h3>Change Student Attendance Status By A Session</h3>
                                    <br>
                                        <label>Student ID </label> <br>
                                <input type="text" id="studentID" name="studentID" autocomplete="off"> <br>
                                         <label>Session ID </label> <br>
                                <input type="text" id="sessionID" name="sessionID" autocomplete="off"> <br>
                                          <label>New Attendance Status </label> <br>   
                                <input type="text" id="attendanceStatus" name="attendanceStatus" autocomplete="off"> <br> <br>
                                
                                <input type="submit" id="changeStudentAttendance" name="changeStudentAttendanceBtn" value="Change Status">
                
        </form>


                      <form method="post" id="roomUsageForm">
                
                <h3>Room Usage</h3>
                 
                        Enter Room ID <br>
                    <input type="text" id="roomID" name="roomID" > <br> 
                            Enter Session ID <br>
                    <input type="text" id="sessionID" name="sessionID"> <br> <br>
                            
                    <input type="submit" id="roomUsageButton" name="roomUsageBtn" value="Check Room Usage">

            </form>
                   
                   <form method="post" id="viewStudentAttendanceForm">
                       <h3> View A Students Attendance</h3>                     
                                            Enter in  A Student ID <br>
                                <input type="text" id="studentID" name="studentID"> <br><br>
                                <input type="submit" id="viewStudentAttendanceBtn" name="viewStudentAttendanceBtn" value="View Attendance">
                                <input type="reset" id="clearBtn" name="clearBtn" value="Clear">        
                   </form>
                       
                   
       </center>
                <?php   include_once 'backend/arcSystem/functions/managerTools/attendanceManagement.php';  ?>
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
