<?php

	/* credits to http://github.com/armysick/LTWDasMalhas  [@ SignIn.php] */
	
	session_start(); //starts the session
	include_once("connection.php");
	if (empty($_POST['user']) || empty($_POST['pass'])) {
			echo'<script language="javascript">';
			echo 'alert("Incorrect username and/or password.")';
			echo '</script>';
			$redirectUrl = 'index.html';
			echo '<script type="application/javascript"> window.location.href = "'.$redirectUrl.'";</script>';
	}
	else
		{
			// Define $username and $password
			
			$username=$_POST['user'];
			$password=$_POST['pass'];
			$stmt =$db->prepare('SELECT password,salt,admin FROM "public"."Admins" WHERE username = :user LIMIT 1');  //removed idUser
			$stmt->bindParam(':user', $username);
			$stmt->execute();
			$chiclas = $stmt->fetch();
			$pwdhash= crypt($password,$chiclas['salt']);
			
			// Hashing the password with its hash as the salt returns the same hash
			if($pwdhash == $chiclas['password']){
				//$_SESSION['id_user']=$chiclas['idUser'];
				$_SESSION['login_user'] = $username;            	// store the username
				$_SESSION['admin'] = $chiclas['admin'];				//to check if user is admin or not
				echo'<script language="javascript">';
				echo 'alert("Correct username and/or password")';
				echo '</script>';
				$redirectUrl = 'profile.php';
				echo '<script type="application/javascript">window.location.href = "'.$redirectUrl.'";</script>';
				//header("location: index.php"); // Redirecting To Other Page
			} else {
				$error = "Username or Password is invalid";
				echo'<script language="javascript">';
				echo 'alert("Incorrect username and/or password.")';
				echo '</script>';
				$redirectUrl = 'index.php';
				echo '<script type="application/javascript">window.location.href = "'.$redirectUrl.'";</script>';
 			}
		}	
?>