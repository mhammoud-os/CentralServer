<html>
<head>
<title>"Adding a Patron"</title>
</head>
<body>
<?php
    require_once('common.php');
    $name =  $_POST['name'];
    $city=  $_POST['city'];
    $prov =  $_POST['prov'];
    $address=  $_POST['address'];
    $postal=  $_POST['postalCode'];
    $contact=  $_POST['contact'];
    $birthdate=  $_POST['birthdate'];
    $form=  $_POST['form'];
	$db = connectToDB();

	$name = ucwords($name);
	$partName= explode(" ", $name);
	$prov = strtoupper($prov);	
	$address = ucwords($address);
	$postal = strtoupper($postal);
	$contactInfo = explode(",",$contact);
	foreach ($contactInfo as $info){
		$contact_array = str_split($info);
		foreach ($contact_array as $char){
			if ($char == "@"){
				$isEmail = True;
				break;
			}else{
				$isEmail =False ;
			}
		}
			if($isEmail){$email = $info;}else{$phone = $info;}
	}
	if ($form == ''){
		$error = True;
	}else{$error = False;}
	if (strlen($phone)>20){
		$error = True;
		$fix = "Try Using a valid phone number";
	}
	if (strlen($email)>50){
		$error = True;
		$fix = "Your email is too long, try using another one";
	}
	if (sizeof($partName) != 2){
		$error = True;
		$fix = "Try using a first and last name separated by a space.";
	}
	if(strlen($partName[0])>30){
		$error = True;
		$fix = "Your first name appears to be too long. Please try abbreviating it.";
	}
	if(strlen($partName[0])>10){
		$error = True;
		$fix = "Your last name appears to be too long. Please try abbreviating it.";
	}
	if ($form != '' and ! $error ) {
		echo "<h1>Hello ".$partName[0]." you have beed added to the database.</h1>";
  		echo "Name:".$name."<br>";
  		echo "City:".$city."<br>";
 		echo "Province:".$prov."<br>";
  		echo "Address:".$address."<br>";
  		echo "Postal Code:".$postal."<br>";
  		echo "Birthdate:".$birthdate."<br>";
		foreach ($contactInfo as $info){
			$contact_array = str_split($info);
			foreach ($contact_array as $char){
				if ($char == "@"){
					$isEmail = True;
					break;
				}else{
					$isEmail =False ;
				}
			}
				if($isEmail){$email = $info;}else{$phone = $info;}
		}
		if ($contact != ""){
			if($phone != Null){
				echo "phone ".$phone;		
				echo "<br>";
			}
			if($email != Null){
				echo "email ".$email;		
			}
		}else{echo "Contact Info: Not specified<br>";}

		if( $email== "" and $phone == ""){
			runSimpleQuery($db,"INSERT INTO patron (firstname,lastname, address,city, prov, postalCode, birthdate) VALUES ('$partName[0]', '$partName[1]', '$address', '$city', '$prov', '$postal','$birthdate');");
		}
		else if( $email== "" and $phone != ""){
			runSimpleQuery($db,"INSERT INTO patron (firstname,lastname, address,city, prov, postalCode,phone, birthdate) VALUES ('$partName[0]', '$partName[1]', '$address', '$city', '$prov', '$postal','$phone','$birthdate');");
		}
		else if( $email!= "" and $phone == ""){
			runSimpleQuery($db,"INSERT INTO patron (firstname,lastname, address,city, prov, postalCode,email, birthdate) VALUES ('$partName[0]', '$partName[1]', '$address', '$city', '$prov', '$postal','$email','$birthdate');");

		}
		else if( $email!= "" and $phone != ""){
			runSimpleQuery($db,"INSERT INTO patron (firstname,lastname, address,city, prov, postalCode,phone,email, birthdate) VALUES ('$partName[0]', '$partName[1]', '$address', '$city', '$prov', '$postal','$phone','$email','$birthdate');");
		}
 	header( "refresh:5;url=https://webdev.iquark.ca/~mhammoud/Library-demo/listPatron.php" );
	echo "<h3> You will soon be redirected back to the main page...</h3>";
		
	}
?>
<form method = "post" action="" >
  <?php
    if ($error) {
     echo "<p>
            First and Last Name <input name=\"name\" type=\"text\" value = \"$name\" maxlength = \"61\"required>
            <br> Street address: <input type =\"name\" name =\"address\" value = \"$address\" maxlength = \"255\" required>
            <br> City: <input type =\"name\" name =\"city\"value = \"$city\"  maxlength = \"100\" required>
            <br> Provence: <input type =\"name\" name =\"prov\"  value = \"$prov\" maxlength = \"2\"required>
            <br> Postal Code: <input type =\"postal\" name =\"postalCode\" value = \"$postal\" maxlength = \"6\"required>
            <br> Contact info (phone or email seperated by a comma): <input type =\"name\" name =\"contact\" value - \"$contact\"><sup>*Not required</sup>
            <br> Birthdate: <input type =\"date\" name =\"birthdate\"value = \"$birthdate\" required>
            <br><input type =\"hidden\" name =\"form\" value =\"submited\">
          </p>";
    echo '<button type = "submit" name ="submit">SUBMIT</button>';
  }
 ?>
 </form>
</html>
