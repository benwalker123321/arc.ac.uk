
    <?php

        class Student{
            public $Name;
            private $StudentID;
            private $Email;
        }
        
        require_once 'authorise.php';
        
        authorise_user(array('Academics'));
        
        
        //connect to the DB
        $dsn = 'mysql:host=127.0.0.1;dbname=universityDB';
        $user = 'root';
        $password = '';
        
        try {
            $db = new PDO($dsn, $user, $password);
        } catch (PDOException $e) {
    //        echo 'Connection failed: ' . $e->getMessage();
            die('Sorry, database problem');
        }
        
        // create a query
        $query = "SELECT * FROM Students";
        
        //send the query to the db
        $result = $db->query($query);
        
        
 
        $result->setFetchMode(PDO::FETCH_CLASS, 'Student');
        while($object = $result->fetch()) {
            echo '<pre>', $object->Name, '</pre>';
        }
        
        
        // create the table
        print ("<table border='3'>");
        
        // add the rows to the table
        while($row = $result->fetch()) {
            
            //add a row
            print ("<tr>");
            
            //print a cell
            print ("<td> $row[StudentID] </td>");
            print ("<td> $row[Name] </td>");
            print ("<td> $row[Email] </td>");
//            print ("<td> $row[username] </td>");
            //close row
            print ("</tr>");
            
        }
        
        //close table
        print ("</table");
        

    
    ?>

