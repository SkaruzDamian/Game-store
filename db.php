<?php
 $conn = new mysqli("localhost", "root", "", "projektzbd");
 if ($conn->connect_error) {
 exit("Error " . $conn->connect_error);
 }
?>