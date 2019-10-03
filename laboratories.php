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
		<table class="table" >
			<thead>
				<tr>
						<th>ID</th>
						<th>Name</th>
						<th>Description</th>
						<th>Building</th>
						<th>Actions</th>
				</tr>
				<tr>
						<td><input style="width: 50px;" type="text" name="lab_id" class="form-control" value='<?php if(isset($_GET['edit'])){echo $lab_id;}else echo ++$fetchid;?>' readonly></td>
						<td><input type="text" name="lab_name" class="form-control" placeholder="Enter Lab / Room Name" value="<?php echo $lab_name?>" required></td>
						<td><textarea style="min-height: 40px; height: 40px;" type="text" class="form-control" name="lab_description" class="form-control" placeholder="Enter Lab / Room Description" value="" required><?php echo $lab_description ?></textarea> </td>
						<td>
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
								?> value="<?php echo $building_row['building_id'] ;?>"><?php echo $building_row['building_name']; ?></option>
								
						<?php	}
						?>
						</select>
						</td>
						<td>
						<?php
							if($update_laboratory==true){
						?>
							<button type="submit" class="btn btn-primary btn-sm mb-1" name="update">UPDATE</button>
						<?php
							}
						else{ 
						?>
						<button type="submit" class="btn btn-primary btn-sm mb-1" name="save"><i class="far fa-save"></i> Save</button>
						<?php } ?>
						<a href="laboratories.php" id="refresh" class='btn btn-danger btn-sm mb-1'><i class="fas as fa-sync"></i> Clear/Refresh</a>
					</td>
				</tr>
			</thead>
		</table>
	</form>
			
	<!-- End Building Here -->
	<!-- Show Added laboratories Here-->
	<h4 style='color: blue;' class="form-control">List of Rooms and Laboratories</h4>	
	<br/>
	<div class="table-responsive">
	<table class="table" id="dataTable" width="100%" cellspacing="0">
		<thead>
			<tr>
				<th>Lab Code</th>
				<th>Name</th>
				<th>Description</th>
				<th>Building</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php while($row=$result->fetch_assoc()){ ?>
			<tr>
				<td><?php echo $row['lab_code']; ?></td>
				<td><?php echo $row['lab_name']; ?></td>
				<td><?php echo $row['lab_description']; ?></td>
				<td><?php 
						 $setBuildingName = $row['building_id'];
						 $getBuildingName = mysqli_query($mysqli, "SELECT building_name FROM building where building_id = $setBuildingName");
						 while ($getBuildingNameArray = $getBuildingName->fetch_assoc()) {
							echo $getBuildingNameArray['building_name'];
						}
						 ?></td>
				<td>
					<a href="laboratories.php?edit=<?php echo $row['lab_id']; ?>" class="btn btn-info btn-sm mb-1"><i class="far fa-edit"></i> Edit</a>
					<!-- Start Drop down Delete here -->
					<button class="btn btn-danger dropdown-toggle btn-sm mb-1" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="far fa-trash-alt"></i> Delete
					</button>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton btn-sm mb-1">
						You sure you want to delete? You cannot undo the changes<br/>
						<a href="process_laboratories.php?delete=<?php echo $row['lab_id'] ?>" class='btn btn-danger btn-sm mb-1'><i class="far fa-trash-alt"></i> Confirm Deletion</a>
						<a href="#" class='btn btn-success btn-sm mb-1'><i class="far fa-window-close"></i> Cancel</a>
					</div></td>
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
<!-- EOF -->
