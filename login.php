<?php
session_start();
include("dataconnection.php");

if(isset($_GET['Loginbtn'])){
	$message1 = NULL;

	if(empty($_GET["usremail"]))
	{

		$message1 .= '<p>Email is empty!</p>';
	}
	else if (empty($_GET["usrpasswrd"]))
	{

		$message1 .= '<p>Password is empty!</p>';
	}
	else
	{

		$email=$_GET["usremail"];
		$pass=$_GET["usrpasswrd"];
		
		$email = mysqli_real_escape_string($connect,$email);
		$pass = mysqli_real_escape_string($connect,$pass);
		//escape those special characters
		

	/*	$result=mysqli_query($connect,"SELECT * FROM customer WHERE Customer_Address='$email' AND Customer_Password='$pass' ");
		$count=mysqli_num_rows($result); */

		$result = mysqli_query($connect,"SELECT * FROM customer WHERE Customer_Email='$email' ");
		$row = mysqli_fetch_assoc($result);
		$email = $row["Customer_Email"];
		$pass = $row["Customer_Password"];
		$loginemail = $row["Customer_Password"];
		
			if($_GET["usremail"]!==$email)
			{
				$_SESSION["error"] = "Sorry, email is wrong! Please try again.";
				header("Location: login.php");
				exit();
				
			}
			
			if($_GET["usrpasswrd"]!==$pass)
			{
				$_SESSION["error"] = "Sorry, password is wrong! Please try again.";
				header("Location: login.php");
				exit();
				
			}

			if($_GET["usremail"]!==$email || $_GET["usrpasswrd"]!==$pass)
			{
				$_SESSION["error"] = "Sorry, email & password is wrong! Please try again.";
				header("Location: login.php");
				exit();
				
			}

			if($loginemail==$pass)
			{
				$_SESSION["id"] = $row["Customer_ID"];
				echo '<script>alert("Login successfully!"); window.location.href = "mainhome.php";</script>';

			}
	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="css/stylel.css">
	<title>Responsive Login Form</title>

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
		<form action="#" method="get" class="login active" autocomplete="off">
			<h2 class="title">Login with your account</h2>
			<?php
					if(isset($_SESSION['error']))
					{
						?>
							<p class="error"><?= $_SESSION['error']; ?></p>
						<?php
						unset($_SESSION['error']);
					}

				?>
			<div class="form-group">
				<label for="email">Email</label>
				<div class="input-group">
					<input type="email" id="email" name="usremail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="Email address">
					<i class='bx bx-envelope' style="margin-left: 100px; cursor: pointer;"></i>
				</div>
			</div>
			<div class="form-group">
				<label for="password">Password</label>
				<div class="input-group">
					<input type="password" name="usrpasswrd" pattern="^(?=.{8,16}$)(?=.*?[a-z])(?=.*?[A-Z])(?=.*?[0-9])(?=.*?\W).*$" id="password" placeholder="Your password">
					<i class='far fa-eye' id="togglePassword" ></i>
				</div>
				
				<span class="help-text">At least 8 characters</span>
			</div>
			<div class="form-group">
				<input class="" type="checkbox" style="margin-left:auto" onclick="myfunction()"> Show Password
			</div>

			<button type="submit" name="Loginbtn" class="btn-submit">Login</button>
			<a href="#">Forgot password?</a>
			<p>I don't have an account. <a href="register.php">Register</a></p>
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