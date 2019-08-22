<?php
require_once 'process_building.php';
$currentItem = 'building';
include('sidebar.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Add / Edit Buildings</title>

	<script src="../libs/js/bootstrap.min.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
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
		$result = $mysqli->query('SELECT * FROM building') or die ($mysqli->error);
		#pre_r($result);

		#pre_r($result->fetch_assoc());
	?>
	
	<!-- Add Building Here -->
	<div class="row justify-content-center">
	<form action="process_building.php" method="POST">
	<h2><?php
		if($update_building==true){
			echo "<h4>Edit ".$building_name." Building</h4>";
		}
		else{
			echo "<h5 style='color: blue;'><center>Add Building</centr></h5>";
		}
		?>
	</h2>
	<table class='table'>
		<thead>
			<tr>
					<th width="10%">ID</th>
					<th>Building Name</th>
					<th>Building Description</th>
					<th colspan="2">Actions </th>
			</tr>
					<td><input type="text" name="building_id" class="form-control" value='<?php if(isset($_GET['edit'])){echo $building_id;}else echo ++$fetchid;?>' readonly></td>
					<td><input type="text" id="nameBuilding" name="building_name" class="form-control" placeholder="Enter Building Name" value="<?php echo $building_name?>" required></td>
					<td><textarea style="min-height: 40px; height: 40px;" type="text" class="form-control" name="building_description" class="form-control" placeholder="Enter Building Description" value="" required><?php echo $building_description ?></textarea></td>
					<td><?php
							if($update_building==true):
							?>
							<button type="submit" class="btn btn-primary btn-sm" name="update">Update</button>
					<?php
						else: 
						?>
					<button type="submit" class="btn btn-primary btn-sm" name="save"><i class="far fa-save"></i> Save</button>
					<?php endif;?></td>
					<td><a href="building.php" id="refresh" class='btn btn-danger btn-sm'><i class="fas as fa-sync"></i> Clear/Refresh</a></th></td>
			</tr>
		</thead>
	</table>

	</form>
	</div>		
	<!-- End Building Here -->
	<!-- Show Added Building Here-->
	<br/>
	<h5 style='color: blue;' class="form-control">List of Buildings</h4>
	<table class="table" id="dataTable" width="100%" cellspacing="0">
			<thead>
				<tr>
					<th>Building ID</th>
					<th>Building Code</th>
					<th>Building Name</th>
					<th>Building Description</th>
					<th>Actions</th>
				</tr>
			</thead>
		<tbody>
			<?php while($row=$result->fetch_assoc()){ ?>
			<tr>
				<td><?php echo $row['building_id']; ?></td>
				<td><?php echo $row['building_code']; ?></td>
				<td><?php echo $row['building_name']; ?></td>
				<td><?php echo $row['building_description']; ?></td>
				<td>
					<a href="building.php?edit=<?php echo $row['building_id']; ?>" class="btn btn-info btn-sm"><i class="far fa-edit"></i> Edit</a>
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