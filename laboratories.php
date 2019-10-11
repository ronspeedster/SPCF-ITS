<?php
include 'process_laboratories.php';
$currentItem = 'building';
include('sidebar.php');
//include('topbar.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Add / Edit Laboratories and Rooms</title>
	
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
   	include('topbar.php');
	$fetchid=0;
	$result = mysqli_query($mysqli, "SELECT * FROM laboratory");
	while ($res = mysqli_fetch_array($result)) {
	$res['lab_id'];
	$fetchid = $res['lab_id'];
}
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
		$result = $mysqli->query('SELECT * FROM laboratory') or die ($mysqli->error);
		$building_result = $mysqli->query('SELECT * FROM building') or die ($mysqli->error);


	?>
	
	<!-- Add Building Here -->
	<div class="card shadow row justify-content-center" style="padding: 1%;">

	<form action="process_laboratories.php" method="POST">
	<h2><?php
		
		if(mysqli_num_rows($building_result)==0){
			?>
			<h5 class="alert alert-danger" role="alert">WARNING! PLEASE ADD BUILDING FIRST!</h5>
			<?php
		}

		if($update_laboratory==true){
			echo "<h4>Edit ".$lab_name."</h4>";
		}
		else{
			echo "<h5 style='color: blue;'><center>Add Laboratories and Rooms</center></h5>";
		}
		?>
	</h2>
	<!-- Responsive Form -->
	<div class="row col-md-12 mb-2" style="">
		<div class="col-md-2 mb-1" style="padding: 1%; margin: auto;">
			<span class="font-weight-bold" style=""><center>ID</center></span>
			<input style="" type="text" name="lab_id" class="form-control" value='<?php if(isset($_GET['edit'])){echo $lab_id;}else echo ++$fetchid;?>' readonly>
		</div>
		<div class="col-md-2 mb-1" style="padding: 1%; margin: auto;">
			<span class="font-weight-bold" style=""><center>Name</center></span>
			<input type="text" name="lab_name" class="form-control" placeholder="Enter Lab / Room Name" value="<?php echo $lab_name?>" required>
		</div>
		<div class="col-md-2 mb-1" style="padding: 1%; margin: auto;">
			<span class="font-weight-bold" style=""><center>Description</center></span>
			<textarea style="min-height: 32px; height: 32px;" type="text" class="form-control" name="lab_description" class="form-control" placeholder="Enter Lab / Room Description" value="" required><?php echo $lab_description ?></textarea>
		</div>
		<div class="col-md-2 mb-1" style="padding: 1%; margin: auto;">
			<span class="font-weight-bold" style=""><center>Building</center></span>
			<select class="form-control" name="building_id"><?php
				while($building_row=$building_result->fetch_assoc()){
				?>
				<option <?php
					if(isset($_GET['edit'])){
						if($lab_building_id==$building_row['building_id'] ){
							echo "selected = 'selected'";
						}
					}
					//Addition in Adding Lab using view
					else if(isset($_GET['addLab'])){
						$labBuildingID=$_GET['addLab'];
						if($labBuildingID==$building_row['building_id']){
							echo "selected='selected'";
						}
					}
					//Addition in Adding Lab using view
					?> value="<?php echo $building_row['building_id'] ;?>"><?php echo $building_row['building_name']; ?>
				</option>
				<?php	}
				?>
			</select>
		</div>
		<div class="col-md-2 mb-1" style="padding: 1%; margin: auto;">
			<span class="font-weight-bold" style=""><center>Actions</center></span>
			<center>
			<?php
			if($update_laboratory==true){
				?>
				<button type="submit" class="btn btn-primary btn-sm mb-1" name="update">UPDATE</button>
				<?php
			}
			else{
				?>
				<button type="submit" class="btn btn-primary btn-sm mb-1" name="save"><i class="far fa-save"></i> Save</button>
			<?php }
			?>
			<a href="laboratories.php" id="refresh" class='btn btn-danger btn-sm mb-1'><i class="fas as fa-sync"></i> Clear/Refresh</a>
			</center>
		</div>		
	</div>
	<!-- Responsive Form End-->
	</form>
			
	<!-- End Building Here -->
	<!-- Show Added laboratories Here-->
	<h4 style='color: blue;' class="form-control">List of Rooms and Laboratories</h4>	
	<br/>
	<div class="table-responsive">
	<table class="table" id="dataTable" width="100%" cellspacing="0" role="table">
		<thead role="rowgroup">
			<tr role="row">
				<th role="columnheader">Lab Code</th>
				<th role="columnheader">Name</th>
				<th role="columnheader">Description</th>
				<th role="columnheader">Building</th>
				<th role="columnheader">Actions</th>
			</tr>
		</thead>
		<tbody role="rowgroup">
			<?php while($row=$result->fetch_assoc()){ ?>
			<tr role="row">
				<td role="cell"><?php echo $row['lab_code']; ?></td>
				<td role="cell"><?php echo $row['lab_name']; ?></td>
				<td role="cell"><?php echo $row['lab_description']; ?></td>
				<td role="cell"><?php 
						 $setBuildingName = $row['building_id'];
						 $getBuildingName = mysqli_query($mysqli, "SELECT building_name FROM building where building_id = $setBuildingName");
						 while ($getBuildingNameArray = $getBuildingName->fetch_assoc()) {
							echo $getBuildingNameArray['building_name'];
						}
						?>
				</td>
				<td role="cell">
					<a href="laboratories.php?edit=<?php echo $row['lab_id']; ?>" class="btn btn-info btn-sm mb-1"><i class="far fa-edit"></i> Edit</a>
					<!-- Start Drop down Delete here -->
					<button class="btn btn-danger dropdown-toggle btn-sm mb-1" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="far fa-trash-alt"></i> Delete
					</button>
					<div class="dropdown-menu shadow" aria-labelledby="dropdownMenuButton btn-sm mb-1" style="padding: 10px !important; font-size: 14px;">
						You sure you want to delete? Deleting will also delete the contents associated to this room / laboratory (Computers, Fixtures, etc.) You cannot undo the changes.<br/>
						<a href="process_laboratories.php?delete=<?php echo $row['lab_id'] ?>" class='btn btn-danger btn-sm mb-1'><i class="far fa-trash-alt"></i> Confirm Deletion</a>
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
		background: #fcfce3;
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
	td:nth-of-type(1):before { content: "Lab Code:"; font-weight: bold;}
	td:nth-of-type(2):before { content: "Lab Name:"; font-weight: bold; }
	td:nth-of-type(3):before { content: "Description:"; font-weight: bold; }
	td:nth-of-type(4):before { content: "Building:"; font-weight: bold; }
	td:nth-of-type(5):before { content: "Actions: "; font-weight: bold; }
}
</style>
<!-- EOF -->
