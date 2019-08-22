<?php
require_once 'process_accounts.php';
$currentItem = 'accounts';
include('sidebar.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Add / Edit Accounts</title>

	<script src="libs/js/bootstrap.min.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>
<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper" style="width: 100% !important;">
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
        <div id="content">
	<?php //require_once 'process.php';
	$result = mysqli_query($mysqli, "SELECT * FROM building");
	$fetchid =0;
	while ($res = mysqli_fetch_array($result)) {
	$res['building_id'];
	$fetchid = $res['building_id'];
}
	include('topbar.php');
?>
<div class="container-fluid">
	<?php
		if(isset($_SESSION['message'])):
	?>
	<div class="alert alert-<?=$_SESSION['msg_type']?> alert-dismissible">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<?php
			echo $_SESSION['message'];
			unset($_SESSION['message']);

		?>
	</div>
	<?php
		endif
	?>
	<!--<div class="container">-->
	<?php
		$mysqli = new mysqli($host,$username,$password,$database) or die(mysql_error($mysqli));
		$getAccounts = $mysqli->query('SELECT * FROM accounts') or die ($mysqli->error);

	?>
	
	<!-- Add Building Here -->
	<div class="row justify-content-center">
	<form action="process_accounts.php" method="POST">
		<?php if($update_account){ ?>
			<input type="text" name="account_id" value="<?php echo $account_id; ?>" class='form-control' readonly style='visibility: hidden;'>
		<?php } ?>
	<h2><?php
			echo "<h5 style='color: blue;'><center>Add Accounts</centr></h5>";
		?>
	</h2>
	<table class='table'>
		<thead>
			<tr>
				<th>Full Name</th>
				<th>Username</th>
				<th>Set Password</th>
				<th>Confirm Password </th>
				<th>Account Type</th>
				<td>Actions</td>
			</tr>
			</thead>
			<tr>
				<td><input type="text" name="fullName" class="form-control" placeholder="Full Name" value="<?php if(isset($_GET['fullName'])){echo $_GET['fullName'];}else{echo $full_name;} ?>" required <?php if($update_account){echo 'readonly';} ?>></td>
				<td><input type="text" name="userName" class="form-control" placeholder="Username" value="<?php if(isset($_GET['userName'])){echo $_GET['userName'];}else{echo $account_userName;} ?>" required <?php if($update_account){echo 'readonly';} ?>></td>
				<td><input type="password" name="password" class="form-control" placeholder="*****" minlength="4" required></td>
				<td><input type="password" name="confirmPassword" class="form-control" placeholder="*****" minlength="4" required></td>
				<td><select name='account_type' class="form-control" <?php if($update_account){echo 'disabled';} ?>>
						<option value='lab_assistant'>Lab Assistant</option>
						<option value='admin'>Administrator</option>
						<option value='ppfo'>PPFO</option>
						<option value='maintenance'>Maintenance</option>
						<option value='president'>President</option>
					</select></td>
				<td>
					<?php if(!$update_account){?>
						<button type="submit" name="save" class="btn btn-sm btn-primary"><i class="far fa-save"></i> Add Account</button>
					<?php } else{ ?>
						<button type="submit" name="update" class="btn btn-sm btn-success"><i class="far fa-save"></i> Update Password</button>
					<?php } ?>
					<a href="accounts.php" id="refresh" class='btn btn-danger btn-sm'><i class="fas as fa-sync"></i> Clear/Refresh</a>
				</td>
			</tr>

	</table>

	</form>
	</div>		
	<!-- End Building Here -->
	<!-- Show Added Building Here-->
	<br/>
	<h5 style='color: blue;' class="form-control">List of Accounts</h4>
	<table class="table" id="dataTable" width="100%" cellspacing="0">
			<thead>
				<tr>
					<th>ID</th>
					<th>Full Name</th>
					<th>Username</th>
					<th>Account Type</th>
					<th>Actions</th>
				</tr>
			</thead>
		<tbody>
			<?php while($newAccounts=$getAccounts->fetch_assoc()){ ?>
			<tr>
				<td><?php echo $newAccounts['id']; ?></td>
				<td><?php echo $newAccounts['full_name']; ?></td>
				<td><?php echo $newAccounts['username']; ?></td>
				<td><?php echo $newAccounts['account_type']; ?></td>
				<td>
					<a href="accounts.php?edit=<?php echo $newAccounts['id']; ?>" class="btn btn-info btn-sm"><i class="far fa-edit"></i> Edit</a>
					<!-- Start Drop down Delete here -->
					<button class="btn btn-danger btn-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="far fa-trash-alt"></i> Delete
					</button>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton btn-sm">
					You sure you want to delete? You cannot undo the changes<br/>
						<a href="process_building.php?delete=<?php echo $row['building_id'] ?>" class='btn btn-danger btn-sm'><i class="far fa-trash-alt"></i> Confirm Delete</a>
						<a href="#" class='btn btn-success btn-sm'><i class="far fa-window-close"></i> Cancel</a> 
					</div>
				</td>
			</tr>
		<?php } ?>
		</tbody>
	</table>

	
	<br/>
	<?php
		function pre_r($array){
			echo "<pre>";
			print_r($array);
			echo "</pre>";
		}
	?>
	<!-- End Added Building Here-->
	<?php
	include('footer.php');
?>