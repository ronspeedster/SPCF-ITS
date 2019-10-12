<?php
require_once 'process_vehicles.php';
$currentItem = 'vehicles';
include('sidebar.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Add / Edit Vehicles</title>
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
<?php
	$getVehicles = mysqli_query($mysqli, "SELECT * FROM vehicle");
	$fetchid=0;
	while ($newVehicles = mysqli_fetch_array($getVehicles)) {
		$fetchid = $newVehicles['id'];
	}
	$getVehicles = mysqli_query($mysqli, "SELECT * FROM vehicle");
	include('topbar.php');
?>
<div class="container-fluid">
	<?php
		if(isset($_SESSION['message'])){
	?>
	<div class="alert alert-<?=$_SESSION['msg_type']?> alert-dismissible">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<?php
			echo $_SESSION['message'];
			unset($_SESSION['message']);
		?>
	</div>
	<?php
		}
	?>

	<!-- Add Building Here -->
	<div class="card shadow row justify-content-center" style="padding: 2%;">
	<form action="process_vehicles.php" method="POST" class="mb-1">
	<h2><?php
		if($update_building==true){
			echo "<h4>Edit ".$vehicle_name." Vehicle</h4>";
		}
		else{
			echo "<h5 style='color: blue;'><center>Add Vehicle</centr></h5>";
		}
		?>
	</h2>
	<!-- Creating a responsive alternative -->
	<div class="row col-md-12 mb-2" style="">
		<div class="col-md-2 mb-1" style="padding: 1%; margin: auto;">
			<span class="font-weight-bold" style=""><center>ID</center></span>
			<input type="text" name="vehicle_id" class="form-control" value="<?php if(isset($_GET['edit'])){echo $vehicle_id;}else echo ++$fetchid;?>" style="width: 100%;" readonly>
		</div>
		<div class="col-md-2 mb-1" style="padding: 1%; margin: auto;">
			<span class="font-weight-bold"><center>Vehicle Name</center></span>
			<input type="text" name="vehicle_name" class="form-control" placeholder="ex: Mazda Sedan" value="<?php echo $vehicle_name; ?>" required>
		</div>
		<div class="col-md-2 mb-1" style="padding: 1%; margin: auto;">
			<span class="font-weight-bold"><center>Type</center></span>
			<select class="form-control text-uppercase" name="vehicle_type">
				<option value="motorcycle">MOTORCYCLE</option>
				<option value="car">CAR</option>
				<option value="truck">TRUCK</option>
				<option value="buses">BUS</option>
			</select>
		</div>
		<div class="col-md-2 mb-1" style="padding: 1%; margin: auto;">
			<span class="font-weight-bold"><center>Plate No.</center></span>
			<input type="text" name="vehicle_plate_no" class="form-control" placeholder="ex: 234-093" required value="<?php echo $vehicle_plate_no; ?>" >
		</div>		
		<div class="col-md-2 mb-1" style="padding: 1%; margin: auto;">
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
			<a href="vehicle.php" id="refresh" class='btn btn-danger btn-sm mb-1'><i class="fas as fa-sync"></i> Clear/Refresh</a>
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
					<th role="columnheader">ID</th>
					<th role="columnheader">Vehicle Name</th>
					<th role="columnheader">Type</th>
					<th role="columnheader">Plate No.</th>
					<th role="columnheader">Actions</th>
				</tr>
			</thead>
		<tbody role="rowgroup">
			<?php while($newVehicles=$getVehicles->fetch_assoc()){ ?>
			<tr role="row">
				<td role="cell"><?php echo $newVehicles['id']; ?></td>
				<td role="cell"><?php echo $newVehicles['name']; ?></td>
				<td role="cell"><?php echo $newVehicles['type']; ?></td>
				<td role="cell"><?php echo $newVehicles['plate_no']; ?></td>
				<td role="cell">
					<a href="vehicle.php?edit=<?php echo $newVehicles['id']; ?>" class="btn btn-info btn-sm mb-1"><i class="far fa-edit"></i> Edit</a>
					<!-- Start Drop down Delete here -->
					<button class="btn btn-danger btn-secondary dropdown-toggle btn-sm mb-1" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="far fa-trash-alt"></i> Delete
					</button>
					<div class="dropdown-menu mb-1 shadow" aria-labelledby="dropdownMenuButton btn-sm" style="padding: 10px !important; font-size: 14px;">
					You sure you want to delete? Deleting will also delete the contents associated to this vehicle (transaction records / receipt) You cannot undo the changes.<br/>
						<a href="process_vehicles.php?delete=<?php echo $newVehicles['id'] ?>" class='btn btn-danger btn-sm mb-1'><i class="far fa-trash-alt"></i> Confirm Delete</a>
						<a class="btn btn-success btn-sm mb-1" style="color: white;"><i class="far fa-window-close"></i> Cancel</a> 
					</div>
				</td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	</div>
</div>

	<!-- End Added Vehicle Here-->
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
		padding: 1%;
		width: 100%;
		border-bottom: 2px solid grey;
		border-top: 2px solid grey;
		background: #fcfce3;
	}
	    
	td {
		border-bottom: 1px solid #eee;
		position: relative;
	}

	td:before {
		top: 0;
		width: 45%;
		padding-right: 1%;
		white-space: nowrap;
	}

	/*
	Label the data
	You could also use a data-* attribute and content for this. That way "bloats" the HTML, this way means you need to keep HTML and CSS in sync. Lea Verou has a clever way to handle with text-shadow.
	*/
	td:nth-of-type(1):before { content: "ID:"; font-weight: bold;}
	td:nth-of-type(2):before { content: "Vehicle Name:"; font-weight: bold; }
	td:nth-of-type(3):before { content: "Type:"; font-weight: bold; }
	td:nth-of-type(4):before { content: "Plate No:"; font-weight: bold; }
	td:nth-of-type(5):before { content: "Actions: "; font-weight: bold; }
}
</style>
<!-- EOF -->