

   function viewOverallModuleClassTypeAttendanceForm(){
                
             document.getElementById('overallClassTypeModuleAttendanceForm').style.display = 'inline', 
             document.getElementById('roomUsageForm').style.display = 'none',         
             document.getElementById('changeStudentAttendanceStatusForm').style.display = 'none',  
             document.getElementById('viewStudentAttendanceForm').style.display = 'none';
             document.getElementById('message').style.display = 'none';
 }
 
 function viewRoomUsageForm(){
            
             document.getElementById('overallClassTypeModuleAttendanceForm').style.display = 'none', 
             document.getElementById('roomUsageForm').style.display = 'inline',         
             document.getElementById('changeStudentAttendanceStatusForm').style.display = 'none',
             document.getElementById('viewStudentAttendanceForm').style.display = 'none';
             document.getElementById('message').style.display = 'none';
 }
 
 function viewAmendStudentAttendanceStatusForm(){
            
             document.getElementById('overallClassTypeModuleAttendanceForm').style.display = 'none', 
             document.getElementById('roomUsageForm').style.display = 'none',        
             document.getElementById('changeStudentAttendanceStatusForm').style.display = 'inline', 
             document.getElementById('viewStudentAttendanceForm').style.display = 'none';
             document.getElementById('message').style.display = 'none';
 }
 
 
  function viewViewStudentAttendanceForm(){
            
             document.getElementById('overallClassTypeModuleAttendanceForm').style.display = 'none', 
             document.getElementById('roomUsageForm').style.display = 'none',        
             document.getElementById('changeStudentAttendanceStatusForm').style.display = 'none',
             document.getElementById('viewStudentAttendanceForm').style.display = 'inline';
             document.getElementById('message').style.display = 'none';
 }
 


