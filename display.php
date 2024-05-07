<?php
   // get the ID of the image from the URL
   $id = $_GET['id'];
   // connect to the database
   $pdo = new PDO('mysql:host=localhost;dbname=main', 'user', 'password');
   // retrieve the image data from the database

//$stmt = $pdo->prepare("SELECT COUNT(*) FROM images;");
//$num = $stmt->fetch(PDO::FETCH_ASSOC);
   $stmt = $pdo->prepare("SELECT name, data FROM images WHERE id=?");
   $stmt->bindParam(1, $id);
   $stmt->execute();
   // set the content type header
   header("Content-Type: image/png");
   // output the image data
   $row = $stmt->fetch(PDO::FETCH_ASSOC);
   echo $row['data'];
?>
