<?php
    $servername="localhost" ;
    $username="root";
    $password="";
    $db_name="restaurant_project";
    $conn=new mysqli($servername,$username,$password,$db_name);
    if($conn->connect_error){
        die("Connection failed!");
    }

    echo "APád cigan"

?>