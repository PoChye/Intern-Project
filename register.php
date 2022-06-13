<?php
session_start();
include("dataconnection.php");

if(isset($_POST['registerbtn']) && isset($_FILES['image'])) {
	

	$message = NULL;
	
	$uname = mysqli_real_escape_string($connect, $_POST['usrname']);
	$upass = mysqli_real_escape_string($connect, $_POST['usrpasswrd']);
	$upnumber = mysqli_real_escape_string($connect, $_POST['usrpnumber']);
	$uemail = mysqli_real_escape_string($connect, $_POST['usremail']);
	$uconpass = mysqli_real_escape_string($connect, $_POST['confirm_usrpasswrd']);

	$imagename=$_FILES["image"]["name"];
	$imagesize=$_FILES["image"]["size"]; 
	$tempname = $_FILES["image"]["tmp_name"];
	$error = $_FILES['image']['error'];  

	$emailQuery = mysqli_query($connect, "SELECT * FROM customer WHERE Customer_Email = '".$_POST['usremail']."'");

	if ($error === 0) {
		if ($imagesize > 50000000) {

			$message .= '<p>Sorry, your file is too large!</p>';
		}
    	else if (empty($uname)) {

			$message .= '<p>Fullame is required!</p>';
		}
		else if(empty($upass)){

			$message .= '<p>Password is required!</p>';
		}
		else if(empty($uconpass)){

			$message .= '<p>Confirm Password is required!</p>';

		}
		else if(strlen($upass)<8){

			$message .= '<p>Password does not meet minimum requirements!</p>';
		}
		else if(strlen($uconpass)<8){

			$message .= '<p>Confirm Password does not meet minimum requirements!</p>';
		}
		else if(empty($upnumber)){

			$message .= '<p>Phone Number is required!</p>';
	
		}
		else if(empty($uemail)){

			$message .= '<p>Email is required!</p>';
		}
		else if(strlen($upnumber)<10)
		{

			$message .= '<p>Wrong phone number format or phone number is too short!</p>';

		}
		else if(strlen($upnumber)>11)
		{

			$message .= '<p>Wrong phone number format or phone number is too long!</p>';

		}
		else if($upass !== $uconpass){

			$message .= '<p>The confirmation password  does not match!</p>';

		}
		else if(mysqli_num_rows($emailQuery) > 0) {
	
			$message .= '<p>The email is taken, please try another email!</p>';
		}
		else {
			$img_ex = pathinfo($imagename, PATHINFO_EXTENSION);
			$img_ex_lc = strtolower($img_ex);

			$allowed_exs = array("jpg", "jpeg", "png"); 

			

			if(in_array($img_ex_lc, $allowed_exs)) {
				$img_upload_path = "images/".$imagename;
				move_uploaded_file($tempname, $img_upload_path);

				// Insert into Database
				$sql2 = "INSERT INTO customer(Customer_Name, Customer_Email, Customer_PNumber, Customer_Password, Customer_ConPassword, Customer_Profile_IMG) VALUES('$uname', '$uemail', '$upnumber', '$upass', '$uconpass', '$imagename')";
				$result2 = mysqli_query($connect, $sql2);

				if($result2) {
					echo '<script>alert("Register successfully!"); window.location.href = "login.php";</script>';
				}
				else {
					$message .= '<p>Unknown error occurred!</p>';

				}
			}
			else{
        		echo '<script>alert("Sorry, You only can upload jpg, jpeg or png type of these file only!"); window.location.href = "register.php";</script>';
			}
		}
	}
		else {
			$message .= '<p>Profile Image is required!</p>';

	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="css/stylel.css">
    
	<title>Responsive Register Form</title>

	<style>
        .error {
            background: #F2DEDE;
            color: #A94442;
            width: 95%;
            border-radius: 5px;
            margin: 20px auto;
        }
	</style>

</head>

<body>
	
	<div class="container">
		<form action="#" method="post" class="register active" enctype="multipart/form-data" autocomplete="off">
			<h2 class="title">Register your account</h2>
                <div class="error">
                    <?php
                            if (isset($message)) 
                            {
                        ?>
                                <p><?= $message; ?></p>
                    <?php
                            }

                    ?>
                </div>
			<div class="form-group">
				<label for="name">Name</label>
				<div class="input-group">
					<input type="text" id="name" name="usrname" placeholder="User Name" value="<?php if (isset($_POST['usrname'])) echo $_POST['usrname']; ?>">
					<i class='bx bx-envelope'></i>
				</div>
			</div>
			<div class="form-group">
				<label for="email">Email</label>
				<div class="input-group">
					<input type="email" id="email" name="usremail" placeholder="Email address" value="<?php if (isset($_POST['usremail'])) echo $_POST['usremail']; ?>" 
                    pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
					<i class='bx bx-envelope'></i>
				</div>
			</div>
			<div class="form-group">
				<label for="phonenumber">Phone Number</label>
				<div class="input-group">
					<input type="text" id="number" name="usrpnumber" min="10" max="11" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4,5}" placeholder="Phone Number" value="<?php if (isset($_POST['usrpnumber'])) echo $_POST['usrpnumber']; ?>">
					<i class='fa fa-phone'></i>
				</div>
                <span class="help-text">E.g: 012-345-6789</span>
			</div>
			<div class="form-group">
				<label for="password">Password</label>
				<div class="input-group">
					<input type="password" name="usrpasswrd" pattern="^(?=.{8,16}$)(?=.*?[a-z])(?=.*?[A-Z])(?=.*?[0-9])(?=.*?\W).*$" id="id_password" placeholder="Your password" value="<?php if (isset($_POST['usrpasswrd'])) echo $_POST['usrpasswrd']; ?>">
					<i class='bx bx-lock-alt' ></i> 
				</div>
				<span class="help-text">At least one uppercase, one lowercase, one special symbol and morethan 8 letter</span>
			</div>
			<div class="form-group">
				<label for="confirm-pass">Confirm password</label>
				<div class="input-group">
					<input type="password" name="confirm_usrpasswrd" id="id_conpassword" placeholder="Enter password again" value="<?php if (isset($_POST['confirm_usrpasswrd'])) echo $_POST['confirm_usrpasswrd']; ?>"
                    pattern="^(?=.{8,16}$)(?=.*?[a-z])(?=.*?[A-Z])(?=.*?[0-9])(?=.*?\W).*$">
					<i class='bx bx-lock-alt' ></i> 
				</div>
				<span class="help-text">Confirm password must be same with password</span>
			</div>
			<div class="form-group">
				<input class="" type="checkbox" style="margin-left:auto" onclick="myFunction()"> Show Password
				
			</div>
			<div class="form-group">
				<label for="phonenumber">Profile Image</label>
				<div class="input-group">
				<input  type="file" name="image" accept="image/png, image/jpg, image/jpeg" id="upload" placeholder="Choose a image" value="<?php if (isset($_POST['image'])) echo $_POST['image']; ?>">
					<i class='bx bx-envelope'></i>
				</div>
			</div>
			<button type="submit" name="registerbtn" class="btn-submit">Register</button>
			<p>I already have an account. <a href="login.php" >Login</a></p>
		</form>
	</div>

	<script src="js/script.js"></script>

	<!--==============================================Eye hide function=================================================-->
	<script>
		function myfunction() {
			var w = document.getElementById("password");
			if (w.type === "password") {
				w.type = "text";
			} else {
				w.type = "password";
			}
	
			
		}

	</script>
	
	<script>
		function myFunction() {
			var x = document.getElementById("id_password");
			if (x.type === "password") {
				x.type = "text";
			} else {
				x.type = "password";
			}
	
			var y = document.getElementById("id_conpassword");
			if (y.type === "password") {
					y.type = "text";
			}else {
				y.type = "password";
			}
		}

	</script>
</body>
</html>