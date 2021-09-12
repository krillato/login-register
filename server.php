<?php 
    /********  Connect Server ***********/
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ducking";  //name database

    // Create Connection สร้างตัวแปรขึ้นมารับ
    $conn = mysqli_connect($servername, $username, $password, $dbname); 

    // Check connection
    if (!$conn) { //ถ้าไม่มีการเชื่อต่อ
        die("Connection failed" . mysqli_connect_error()); //แจ้งเตือนถ้าเกิด error
    } 
    
?>
