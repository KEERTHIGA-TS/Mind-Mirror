<?php
include 'includes/db.php';
session_start();

if($_SERVER["REQUEST_METHOD"]=="POST"){
	$email=$_POST['email'];
	$password=$_POST['password'];

	$stmt=$conn->prepare("SELECT id,username,password_hash FROM users WHERE email=?");
	$stmt->bind_param("s",$email);
	$stmt->execute();
	$stmt->store_result();

	if($stmt->num_rows==1){
		$stmt->bind_result($id,$username,$password_hash);		
		$stmt->fetch();
		
		if(password_verify($password,$password_hash)){
			$_SESSION['user_id']=$id;
			$_SESSION['username']=$username;
			header("Location: dashboard.php");
		}
		else
			echo"<div>Wrong password!</div>";
	}
	else
		echo"<div>Email not found!</div>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mind Mirror - Login</title>
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
		.login{
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
		.login:hover{
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
		div{
			color: rgb(234, 37, 23);
			margin-bottom: 25px;
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
			h2{
				font-size:15px;
			}
			.login{
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
				font-size:11px;
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
			h2{
				font-size:16px;
			}
			.login{
				display:inline-block;
				text-align: center;
				padding: 6px;
				font-size: 11px;
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
	<h2>Login</h2>
	<input type="email" name="email" placeholder="Email-id" required><br><br>
	<input type="password" name="password" placeholder="Password" required><br><br><br>
	<button class="login">Login</button>
	<p>New User? <a href="register.php">Register here</a> 
	</form>
	
</body>
</html>
