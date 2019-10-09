<?php
require_once 'process_building.php';
$currentItem = 'building';
include('sidebar.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Add / Edit Buildings</title>
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
		$result = $mysqli->query('SELECT * FROM building') or die ($mysqli->error);
		#pre_r($result);

		#pre_r($result->fetch_assoc());
	?>
	
	<!-- Add Building Here -->
	<div class="card shadow row justify-content-center" style="padding: 2%;">
	<form action="process_building.php" method="POST" class="mb-1">
	<h2><?php
		if($update_building==true){
			echo "<h4>Edit ".$building_name." Building</h4>";
		}
		else{
			echo "<h5 style='color: blue;'><center>Add Building</centr></h5>";
		}
		?>
	</h2>
	<!-- Creating a responsive alternative -->
	<div class="row col-md-12 mb-2" style="">
		<div class="col-md-3 mb-1" style="padding: 1%; margin: auto;">
			<span class="font-weight-bold" style=""><center>ID</center></span>
			<input type="text" name="building_id" class="form-control" value="<?php if(isset($_GET['edit'])){echo $building_id;}else echo ++$fetchid;?>" style="width: 100%;" readonly>
		</div>
		<div class="col-md-3 mb-1" style="padding: 1%; margin: auto;">
			<span class="font-weight-bold"><center>Building Name</center></span>
			<input type="text" id="nameBuilding" name="building_name" class="form-control" placeholder="Enter Building Name" value="<?php echo $building_name?>" required>
		</div>
		<div class="col-md-3 mb-1" style="padding: 1%; margin: auto;">
			<span class="font-weight-bold"><center>Building Description</center></span>
			<textarea style="min-height: 32px; height: 32px;" type="text" class="form-control" name="building_description" class="form-control" placeholder="Enter Building Description" value="" required><?php echo $building_description ?></textarea>
		</div>
		<div class="col-md-3 mb-1" style="padding: 1%; margin: auto;">
			<span class="font-weight-bold"><center>Actions</center></span>
			<center>
			<?php
			if($update_building==true){
				?>
				<button type="submit" class="btn btn-primary btn-sm mb-1" name="update">Update</button>
				<?php
			}
			else{
				?>
				<button type="submit" class="btn btn-primary btn-sm mb-1" name="save"><i class="far fa-save"></i> Save</button>
			<?php } ?>
			<a href="building.php" id="refresh" class='btn btn-danger btn-sm mb-1'><i class="fas as fa-sync"></i> Clear/Refresh</a>
			</center>
			</div>						
	</div>
	<!-- End Here responsive alternative -->
</form>
	<!-- End Building Here -->
	<!-- Show Added Building Here-->
	<h5 style='color: blue;' class="form-control">List of Buildings</h5>
	<div class="table-responsive" >
	<table class="table" id="dataTable" width="100%" cellspacing="0" role="table">
			<thead role="rowgroup">
				<tr role="row">
					<th role="columnheader">Building ID</th>
					<th role="columnheader">Building Code</th>
					<th role="columnheader">Building Name</th>
					<th role="columnheader">Building Description</th>
					<th role="columnheader">Actions</th>
				</tr>
			</thead>
		<tbody role="rowgroup">
			<?php while($row=$result->fetch_assoc()){ ?>
			<tr role="row">
				<td role="cell"><?php echo $row['building_id']; ?></td>
				<td role="cell"><?php echo $row['building_code']; ?></td>
				<td role="cell"><?php echo $row['building_name']; ?></td>
				<td role="cell"><?php echo $row['building_description']; ?></td>
				<td role="cell">
					<a href="building.php?edit=<?php echo $row['building_id']; ?>" class="btn btn-info btn-sm mb-1"><i class="far fa-edit"></i> Edit</a>
					<!-- Start Drop down Delete here -->
					<button class="btn btn-danger btn-secondary dropdown-toggle btn-sm mb-1" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="far fa-trash-alt"></i> Delete
					</button>
					<div class="dropdown-menu mb-1 shadow" aria-labelledby="dropdownMenuButton btn-sm" style="padding: 10px !important; font-size: 14px;">
					You sure you want to delete? Deleting will also delete the contents associated to this building (Computers, Fixtures, etc.) You cannot undo the changes.<br/>
						<a href="process_building.php?delete=<?php echo $row['building_id'] ?>" class='btn btn-danger btn-sm mb-1'><i class="far fa-trash-alt"></i> Confirm Delete</a>
						<a class="btn btn-success btn-sm mb-1" style="color: white;"><i class="far fa-window-close"></i> Cancel</a> 
					</div>
				</td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	</div>
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
<style type="text/css">
	/*
	Max width before this PARTICULAR table gets nasty. This query will take effect for any screen smaller than 760px and also iPads specifically.
	*/
@media
only screen
and (max-width: 760px), (min-device-width: 768px)
and (max-device-width: 1024px)  {

	/* Force table to not be like tables anymore */
	table, thead, tbody, th, td, tr {
		display: block;
	}

	thead tr {
		position: absolute;
		top: -9999px;
		left: -9999px;
	}

	tr {
		margin: 0 0 1rem 0;
	}

	tr:nth-child(odd) {
		background: none;
		padding: 1%;
		width: 100%;
		border-bottom: 2px solid grey;
		border-top: 2px solid grey;
	}
	    
	td {
		border-bottom: 1px solid #eee;
		position: relative;
	}

	td:before {
		top: 0;
		width: 45%;
		padding-right: 5%;
		white-space: nowrap;
	}

	/*
	Label the data
	You could also use a data-* attribute and content for this. That way "bloats" the HTML, this way means you need to keep HTML and CSS in sync. Lea Verou has a clever way to handle with text-shadow.
	*/
	td:nth-of-type(1):before { content: "Building ID:"; font-weight: bold;}
	td:nth-of-type(2):before { content: "Building Code:"; font-weight: bold; }
	td:nth-of-type(3):before { content: "Building Name:"; font-weight: bold; }
	td:nth-of-type(4):before { content: "Building Description:"; font-weight: bold; }
	td:nth-of-type(5):before { content: "Actions: "; font-weight: bold; }
}
</style>
<!-- EOF -->