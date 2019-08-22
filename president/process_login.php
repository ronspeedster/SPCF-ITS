<?php
	include 'dbh.php';
	if(isset($_POST['login'])){
		$username= $_POST['username'];
		$password= $_POST['password'];
		$checkAccount = $mysqli->query("SELECT * FROM accounts WHERE username='$username' AND password='$password'");
		if(mysqli_num_rows($checkAccount)>0){
		$newAccoount = $checkAccount->fetch_array();
			$_SESSION['account'] = $newAccoount['account_type'];
			$_SESSION['username'] = $newAccoount['full_name'];
			$_SESSION['account_id'] = $newAccoount['id'];
			if($_SESSION['account']=="admin"){
				header("location: index.php");
			}
			else{
				header("location: index.php");
			}
		}
		else{
			$_SESSION['logInError'] = "Credentials do not match our records. Login failed. Please try again";
			header("location: login.php");
		}
	}
?>