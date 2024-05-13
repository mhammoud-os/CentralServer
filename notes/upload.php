<?php
   // check if an image file was uploaded
   if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
      $name = $_FILES['image']['name'];
      $type = $_FILES['image']['type'];
      $data = file_get_contents($_FILES['image']['tmp_name']);
      // connect to the database
      require_once('common.php');
      $db = connectToDB();
      //runSimpleQuery($db,"INSERT INTO images (name, data) VALUES ('$name','$data');");
      $pdo = new PDO('mysql:host=localhost;dbname=main', 'user', 'password');
      // insert the image data into the database
      $stmt = $pdo->prepare("INSERT INTO images (name,data) VALUES (?, ?)");
      $stmt->bindParam(1, $name);
      //$stmt->bindParam(2, $type);
      $stmt->bindParam(2, $data);
      $stmt->execute();
   }
?>
