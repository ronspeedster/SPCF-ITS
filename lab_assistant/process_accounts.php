<?php
	include 'dbh.php';
	$update_account = false;
	$full_name='';
	$account_userName = '';
	$userName = $_SESSION['username'];
	
	if(isset($_POST['save'])){
		echo $fullName = $_POST['fullName'];
		echo $account_userName = $_POST['userName'];
		echo $password = $_POST['password'];
		echo $confirmPassword = $_POST['confirmPassword'];
		echo $account_type = $_POST['account_type'];
		if($confirmPassword!=$password){
			$_SESSION['message'] = "Password do not match! Please try again";
			$_SESSION['msg_type'] = "warning";
			header("location: accounts.php?fullName=".$fullName."&userName=". $account_userName);
			
		}
		else{
			$mysqli->query("INSERT INTO accounts (username, password, full_name, account_type) VALUES('$account_userName','$password','$fullName','$account_type')") or die ($mysqli->error());
			$_SESSION['message'] = "Account has been added!";
			$_SESSION['msg_type'] = "success";

			header("location: accounts.php");	
		}
		
	}

	if(isset($_GET['delete'])){
		$account_id = $_GET['delete'];
		$mysqli->query("DELETE FROM accounts WHERE id=$account_id") or die($mysqli->error());

		$_SESSION['message'] = "Record has been deleted!";
		$_SESSION['msg_type'] = "danger";
		header("location: building.php");
	}

	if(isset($_GET['edit'])){
		$update_account = true;
		$account_id= $_GET['edit'];
		$getEditAccount = $mysqli->query("SELECT * FROM accounts WHERE id=$account_id") or die ($mysqli->error());
		$neweditAccount = $getEditAccount->fetch_array();
		$full_name = $neweditAccount['full_name'];
		$account_userName = $neweditAccount['username'];
	}

	if(isset($_POST['update'])){
		echo $account_id = $_POST['account_id'];
		echo $password = $_POST['password'];
		echo $confirmPassword = $_POST['confirmPassword'];
		
		if($confirmPassword!=$password){
			$_SESSION['message'] = "Password do not match! Please try again";
			$_SESSION['msg_type'] = "warning";
			header("location: accounts.php?edit=".$account_id);
			
		}
		else{
			$mysqli->query("UPDATE accounts SET password='$password' WHERE id='$account_id'") or die ($mysqli->error());
			
			$_SESSION['message'] = "Password changed!";
			$_SESSION['msg_type'] = "success";

			header("location: accounts.php");	
		}
	}
?>