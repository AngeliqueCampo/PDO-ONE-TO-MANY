<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Veterinary_Clinic";

try {
    // create PDO 
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    
    // set error exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // display error message
    echo "Connection failed: " . $e->getMessage();
}
?>
