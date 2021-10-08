<?php
	require_once 'process_fixture.php';
	$currentItem = 'equipments';
	include('sidebar.php');
	$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	$getURI = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	$_SESSION['getURI'] = $getURI;
	//$getURI = $_SERVER['QUERY_STRING'];
	//echo $query; // Outputs: Query String
?>
<!DOCTYPE html>
<html>
<head>
	<title>Add / Edit Fixtures</title>
	<script src="libs/js/bootstrap.min.js"></script>
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
<?php include('topbar.php'); ?>
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

	$getBuilding = $mysqli->query('SELECT * FROM building ORDER BY building_name') or die ($mysqli->error);
	//print_r($getBuilding);
	?>

	<h5 style='color: blue;'><center>Add / Edit Fixtures</center></h5>
	<!-- Add Fixtures Here -->
	<div class="card shadow row justify-content-center" style="padding: 1%;">
		<!-- Responsive Form -->
		<form action="process_fixture.php" method="POST">
		<div class="row col-md-12 mb-2" style="">
			<div class="col-md-2 mb-1" style="padding: 1%; margin: auto;">
				<span class="font-weight-bold" style=""><center><i class="fas fa-fw fa-building"></i> Building</center></span>
				<select class="form-control" onchange="location = this.value;">
					<option disabled selected>Select Building</option>
					<?php
						$building_id = 0;
						if(isset($_GET['building_id'])){
							$building_id = $_GET['building_id'];
						}
						while($newBuilding=$getBuilding->fetch_assoc()){ ?>
					<option value="<?php echo 'fixtures.php?building_id='. $newBuilding['building_id']; ?>" <?php if($building_id==$newBuilding['building_id']){echo 'selected';} ?> ><?php echo $newBuilding['building_name']; ?></option>
					<?php
						}
					?>
				</select>				
			</div>
			<div class="col-md-2 mb-1" style="padding: 1%; margin: auto;">
				<span class="font-weight-bold" style=""><center><i class="fa fa-home" aria-hidden="true"></i> Room / Laboratory</center></span>
				<select name="laboratory" class="form-control" required>
					<?php
					if(isset($_GET['building_id'])){
						$building_id = $_GET['building_id'];
						$getLaboratory = $mysqli->query("SELECT * FROM laboratory WHERE building_id='$building_id'") or die ($mysqli->error);
						if(mysqli_num_rows($getLaboratory)==0){
							echo "<option selected disabled>WARNING! Please add a lab or room to this building first</option>";
						}
						while($newLaboratory=$getLaboratory->fetch_assoc()){
							?>
					<option value="<?php echo $newLaboratory['lab_id']; ?>"><?php echo $newLaboratory['lab_name']; ?></option>	
					<?php
						}
					}
					?>
					<option disabled>Select Room / Laboratory</option>					
				</select>
			</div>
			<div class="col-md-2 mb-1" style="padding: 1%; margin: auto;">
				<span class="font-weight-bold" style=""><center><i class="fas fa-couch"></i> Fixture Type</center></span>
				<select name="type" class="form-control">
					<option value="airconditioner">Air Conditioner</option>
					<option value="computerTable">Computer Table</option>
					<option value="monoBlocChair">Mono Bloc Chair</option>
					<option value="officeTable">Office Table</option>
					<option value="chair">chair</option>
					<option value="lights">Lights</option>
					<option value="electronics">Electronics</option>
					<option value="comfortRoom">Comfort Room</option>
					<option value="flooring">FLooring</option>
					<option disabled>Select Type</option>
				</select>
			</div>
			<div class="col-md-2 mb-1" style="padding: 1%; margin: auto;">
				<span class="font-weight-bold" style=""><center>Qty</center></span>
				<input type="number" name="qty" class="form-control" min='1' max='999999999999' placeholder="0" required>
			</div>
			<div class="col-md-2 mb-1" style="padding: 1%; margin: auto;">
				<span class="font-weight-bold" style=""><center>Actions</center></span>
				<center>
				<button class="btn btn-primary btn-sm mb-1" type="submit" name="save"><i class="far fa-save" ></i> Save</button>
				<a href="fixtures.php" id="refresh" class="btn btn-danger btn-sm mb-1"><i class="fas as fa-sync"></i> Clear/Refresh</a></center>
			</div>
		</div>
		<?php if(isset($_GET['building_id'])){
			$building_id = $_GET['building_id'];
			echo "<input name='building' style='visibility: hidden;' type='text' value=".$building_id.">";
			}
		?>
		</form>
		<!-- Responsive Form -->
		
		<label style='color: blue;'class="form-control">List of Fixtures (Preview - Latest Addition)</label>
	
	<!-- Show Added Fixtures -->
	
		<table class="table" id="fixtureTable" width="100%" cellspacing="0" role="table">
			<thead role="rowgroup">
				<th role="columnheader">Type</th>
				<th style="display: none;" role="columnheader">Batch ID</th>
				<th role="columnheader">Serial No</th>
				<th role="columnheader">Building</th>
				<th role="columnheader">Room / Laboratory</th>
				<th role="columnheader">Remarks</th>
				<th role="columnheader">Actions</th>
			</thead>
			<tbody role="rowgroup">
				<?php $getFixtures = mysqli_query($mysqli, "SELECT fe.id, fe.date_added, fe.serial_no, fe.type, fe.batch_code, fe.building_id, fe.lab_id, fe.remarks, bg.building_id, bg.building_name, ly.lab_id, ly.lab_name
					FROM fixture fe
					JOIN building bg
					ON bg.building_id = fe.building_id
					JOIN laboratory ly
					ON ly.lab_id = fe.lab_id
					ORDER BY fe.date_added DESC
					LIMIT 10
					"); 
				while($newFixtures=$getFixtures->fetch_assoc()){
			?>
				<tr>
					<td role="cell"><?php echo strtoupper($newFixtures['type']); ?></td>
					<td style="display: none;" role="cell"><?php echo $newFixtures['batch_code']; ?></td>
					<td role="cell"><?php if($newFixtures['serial_no']==''){echo "<font color='red'>NO SN</font>";}else{echo $newFixtures['serial_no'];} ?></td>
					<td role="cell"><?php echo $newFixtures['building_name']; ?></td>
					<td role="cell"><?php echo $newFixtures['lab_name']; ?></td>
					<td role="cell"><?php if($newFixtures['remarks']=='For Repair'){echo "<font color='red'>".$newFixtures['remarks']."</font>";}else{echo $newFixtures['remarks'];} ?></td>
					<td role="cell">
						<a class="btn btn-info btn-sm mb-1" target="_blank" href="edit_fixture.php?type=<?php echo $newFixtures['type']; ?>&id=<?php echo $newFixtures['id'];?>&building_id=<?php echo $newFixtures['building_id']; ?>"><i class="far fa-edit"></i> Edit</a>
						<a style='color: #5D4037;' class="btn btn-sm btn-warning mb-1" href="report_fixture.php?fixture_id=<?php echo $newFixtures['id']?>" target='_blank'><i class="fas fa-bug"></i> Report</a>
						<!-- Start Drop down Delete here -->
						<button class="btn btn-danger btn-secondary dropdown-toggle btn-sm mb-1" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="far fa-trash-alt"></i> Delete
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton btn-sm">
							You sure you want to delete? You cannot undo the changes<br/>
						<a href="process_fixture.php?delete=<?php echo $newFixtures['id'] ?>" class='btn btn-danger btn-sm'><i class="far fa-trash-alt"></i> Confirm Delete</a>
						<a href="#" class='btn btn-success btn-sm'><i class="far fa-window-close"></i> Cancel</a> 
					</div>
					</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	
	</div>

	<br/>
	<br/>
<script type="text/javascript">
	$(document).ready(function() {
		$('#fixtureTable').DataTable( {
			"pageLength": 50
		} );
	} );
</script>
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
		padding-right: 1%;
		white-space: nowrap;
	}

	/*
	Label the data
	You could also use a data-* attribute and content for this. That way "bloats" the HTML, this way means you need to keep HTML and CSS in sync. Lea Verou has a clever way to handle with text-shadow.
	*/
	td:nth-of-type(1):before { content: "Type:"; font-weight: bold;}
	td:nth-of-type(2):before { content: "Batch ID:"; font-weight: bold; }
	td:nth-of-type(3):before { content: "Serial No:"; font-weight: bold; }
	td:nth-of-type(4):before { content: "Building:"; font-weight: bold; }
	td:nth-of-type(5):before { content: "Room:"; font-weight: bold; }
	td:nth-of-type(6):before { content: "Remarks:"; font-weight: bold; }
	td:nth-of-type(6):before { content: "Actions:"; font-weight: bold; }
}
</style>

<!-- EOF -->
