	
<?php
        
        $host = "localhost";
            
        $username = "root";
            
        $password = "";
            
        $database = "beasiswa";
            
         
            
        return new PDO("mysql:host=$host;dbname=$database", $username, $password, array(
            
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            
        ));
        ?>