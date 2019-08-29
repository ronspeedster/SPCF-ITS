<?php
require_once 'process_accounts.php';
$currentItem = 'accounts';
include('sidebar.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Add Building Designation (For Lab Assistant's only)</title>

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
		$getAccounts = $mysqli->query("SELECT * FROM accounts WHERE account_type='lab_assistant' ") or die ($mysqli->error);
		$getBuilding = $mysqli->query("SELECT * FROM building") or die ($mysqli->error);
		$getDesignations = $mysqli->query("SELECT * FROM designation d
			JOIN building b ON b.building_id = d.building_id
			JOIN accounts a ON a.id = d.account_id") or die ($mysqli->error);
		//print_r($getDesignations);
	?>
	
	<!-- Add Building Here -->
	<div class="card shadow row justify-content-center" style="padding: 1%;">
	<form action="process_accounts.php" method="POST">
		<?php if($update_account){ ?>
			<input type="text" name="account_id" value="<?php echo $account_id; ?>" class='form-control' readonly style='visibility: hidden;'>
		<?php } ?>
	<h2><?php
			echo "<h5 style='color: blue;'><center>Designate an Account (For Lab Assistant's only)</centr></h5>";
		?>
	</h2>
	<table class='table'>
		<thead>
			<tr>
				<th>Full Name</th>
				<th>Building</th>
				<th>Actions</th>
			</tr>
		</thead>
			<tr>
				<td>
					<select name='account_id' class="form-control">
						<?php while($newAccounts=$getAccounts->fetch_assoc()){?>
						<option value="<?php echo $newAccounts['id']; ?>"><?php echo $newAccounts['id'].' - '.$newAccounts['full_name']; ?></option>
						<?php } ?>
					</select>
				</td>
				<td>
					<select name='building_id' class="form-control">
						<?php while($newBuilding=$getBuilding->fetch_assoc()){?>
						<option value="<?php echo $newBuilding['building_id']; ?>"><?php echo $newBuilding['building_name']; ?></option>
						<?php } ?>
					</select>
				</td>
				<td>
					<button type="submit" class="btn btn-sm btn-primary" name="designate_building"><i class="far fa-save"></i> Set Building and Account Designation</button>
				</td>

			</tr>

	</table>

	</form>
	
	<!-- End Building Here -->
	<!-- Show Added Building Here-->
	<br/>
	<h5 style='color: blue;' class="form-control">List of Lab Assistants</h4>
	<table class="table" id="dataTable" width="100%" cellspacing="0">
			<thead>
				<tr>
					<th>ID</th>
					<th>Full Name</th>
					<th>Username</th>
					<th>Building</th>
					<th style="display: none;">Actions</th>
				</tr>
			</thead>
		<tbody>
			<?php while($newDesignations=$getDesignations->fetch_assoc()){ ?>
			<tr>
				<td><?php echo $newDesignations['account_id']; ?></td>
				<td><?php echo $newDesignations['full_name']; ?></td>
				<td><?php echo $newDesignations['username']; ?></td>
				<td><?php echo $newDesignations['building_name']; ?></td>
				<td style="display: none;">
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
	</div>	
	
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