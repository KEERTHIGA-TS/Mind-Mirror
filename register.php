<?php
include 'includes/db.php';

if($_SERVER["REQUEST_METHOD"]=="POST"){
$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'],PASSWORD_DEFAULT);

$stmt=$conn->prepare("INSERT INTO users(username,email,password_hash)VALUES(?,?,?)");
$stmt->bind_param("sss",$username,$email,$password);

if($stmt->execute())
	echo"<div>Registration successful. <a href='login.php'>  Login here</a></div>";
else
	echo"Error: ".$conn->error;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mind Mirror - Register</title>
    <link rel="icon" type="image/jpeg" href="images/mindmirror-logo.png">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
	<style>
		body{
			margin:0;
			padding:0;
			height:100vh;
			display:flex;
			flex-direction:column;
			align-items:center;
			justify-content:center;
			background-color:rgb(248, 219, 210);
			font-family:'Montserrat',sans-serif;
			color: #4E3D42;
		}
		div{
			color: rgb(70, 175, 21);
			margin-bottom: 25px;
		}
		.register{
			display:inline-block;
			text-align: center;
			padding: 12px;
			font-size: 1.1rem;
			background-color: rgb(57, 57, 211);
			color: aliceblue;
			border:none;
			border-radius: 10px;
			text-decoration: none;
			cursor: pointer;
		}
		.register:hover{
			background-color: rgb(106, 106, 211);
		}
		input{
			width:300px;
			height:40px;
			border:none;
			padding:10px;
			border-radius:12px;
		}
		input:focus{
			outline:none;
		}
		form{
			text-align:center;
			background-color: #F7C1B2;
			padding:30px;
			border-radius:15px;
		}
		@media screen and (max-width:769px) {
			input{
				width:140px;
				height:10px;
				border:none;
				padding:10px;
				border-radius: 5px;
				font-size:9px;
			}
			input:focus{
				outline:none;
			}
			form{
				text-align:center;
				background-color: #F7C1B2;
				padding:10px;
				border-radius:5px;
			}
			p{
				font-size:9px;
			}
			h3{
				font-size:15px;
			}
			.register{
				display:inline-block;
				text-align: center;
				padding: 8px;
				font-size: 12px;
				background-color: rgb(57, 57, 211);
				color: aliceblue;
				border:none;
				border-radius: 5px;
				text-decoration: none;
				cursor: pointer;
			}
			div{
				font-size: 11px;
			}
		}
		@media screen and (max-width:426px) {
			input{
				width:160px;
				height:10px;
				border:none;
				padding:10px;
				border-radius: 5px;
				font-size:12px;
			}
			input:focus{
				outline:none;
			}
			form{
				text-align:center;
				background-color: #F7C1B2;
				padding:10px;
				border-radius:5px;
			}
			p{
				font-size:11px;
			}
			h3{
				font-size:16px;
			}
			.register{
				display:inline-block;
				text-align: center;
				padding: 6px;
				font-size: 10px;
				background-color: rgb(57, 57, 211);
				color: aliceblue;
				border:none;
				border-radius: 5px;
				text-decoration: none;
				cursor: pointer;
			}
			
		}
		
	</style>
</head>
<body>
	<form method="post">
	<h3>Registration</h3>
	<input type="text" name="username" placeholder="Username" required><br><br>
	<input type="email" name="email" placeholder="Email-id" required><br><br>
	<input type="password" name="password" placeholder="Password" required><br><br><br>
	<button class="register" >Register</button>
	<p>Already have an account? <a class="login" href="login.php">Login here</a> 	
	</form>
</body>
</html>




