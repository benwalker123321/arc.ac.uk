

   function  viewModuleAttendance(){
     
             document.getElementById('viewModuleAttendanceForm').style.display = 'inline', 
             document.getElementById('viewClassGroupSessionAttendanceForm').style.display = 'none', 
             document.getElementById('viewStudentAttendanceForm').style.display = 'none';
             document.getElementById('message').style.display = 'none';   
 }
 
 
  function  viewGroupAttendance(){
     
     document.getElementById('viewModuleAttendanceForm').style.display = 'none',
     document.getElementById('viewClassGroupSessionAttendanceForm').style.display = 'inline', 
     document.getElementById('viewStudentAttendanceForm').style.display = 'none';
     document.getElementById('message').style.display = 'none';
 }
 
 
  function  viewStudentAttendance(){
     
     document.getElementById('viewModuleAttendanceForm').style.display = 'none',
     document.getElementById('viewClassGroupSessionAttendanceForm').style.display = 'none',
     document.getElementById('viewStudentAttendanceForm').style.display = 'inline';
     document.getElementById('message').style.display = 'none';
 }

