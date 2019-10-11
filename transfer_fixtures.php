<?php
require_once 'process_fixture.php';
$currentItem = 'transfer';
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
	<title>Pull Out Fixtures</title>
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

	<h5 style='color: blue;'><center>Pull Out Fixtures</center></h5>
	<!-- Add Fixtures Here -->
	<div class="card shadow row justify-content-center" style="padding: 1%;">
		<label style='color: blue;'class="form-control">List of Fixtures</label>
		<?php
			$fileName = basename($_SERVER['PHP_SELF']);
			if(!isset($_GET['type'])){
				$current_type = '*';
				$type='All Types';
			}
			else{
				$current_type = $_GET['type'];
				if($current_type=='*'){
					$type = 'All Types';
				}
				else{
					$type = $current_type;
				}
			}
			// Get Categories
			$getCategories = mysqli_query($mysqli, "SELECT DISTINCT type FROM fixture ");
		?>
		<div class="row col-md-12">
			<div class="col-md-6 mb-1" style="text-align: center;"><b>Select Type:</b> </div>
			<div class="col-md-6 mb-1" style="text-align: center;">
				<select class="form-control" onchange="location = this.value;">
					<option disabled selected>Select Fixture</option>
					<?php while($newCategories=$getCategories->fetch_assoc()){  ?>
					<option value="<?php echo $fileName.'?type='.$newCategories['type'];?>" <?php if($current_type==$newCategories['type']){echo "selected";} ?> >
						<?php echo strtoupper($newCategories['type']); ?>
					</option>
					<?php } ?>
					<option value="<?php echo $fileName.'?type=*';?>">All Type</option>
				</select>
			</div>
		</div>
		<!-- Show Added Fixtures -->
		<table class="table" id="dataTable" width="100%" cellspacing="0">
			<thead>
				<th>Type</th>
				<th>Batch ID</th>
				<th>Serial No</th>
				<th>Building</th>
				<th>Room / Laboratory</th>
				<th>Remarks</th>
				<th>Actions</th>
			</thead>
			<tbody>
				<?php
				if($current_type=="*"){
					$getFixtures = mysqli_query($mysqli, "SELECT fe.id, fe.date_added, fe.serial_no, fe.type, fe.batch_code, fe.building_id, fe.lab_id, fe.remarks, bg.building_id, bg.building_name, ly.lab_id, ly.lab_name
						FROM fixture fe
						JOIN building bg
						ON bg.building_id = fe.building_id
						JOIN laboratory ly
						ON ly.lab_id = fe.lab_id
						WHERE fe.lab_id <> 'stock_room'
						ORDER BY fe.date_added DESC
						");
				}
				else{
					$getFixtures = mysqli_query($mysqli, "SELECT fe.id, fe.date_added, fe.serial_no, fe.type, fe.batch_code, fe.building_id, fe.lab_id, fe.remarks, bg.building_id, bg.building_name, ly.lab_id, ly.lab_name
					FROM fixture fe
					JOIN building bg
					ON bg.building_id = fe.building_id
					JOIN laboratory ly
					ON ly.lab_id = fe.lab_id
					WHERE fe.lab_id <> 'stock_room' AND
					fe.type = '$current_type'
					ORDER BY fe.date_added DESC
					");
				}
			while($newFixtures=$getFixtures->fetch_assoc()){
			?>
				<tr>
					<td><?php echo strtoupper($newFixtures['type']); ?></td>
					<td><?php echo $newFixtures['batch_code']; ?></td>
					<td><?php if($newFixtures['serial_no']==''){echo "<font color='red'>NO SN</font>";}else{echo $newFixtures['serial_no'];} ?></td>
					<td><?php echo $newFixtures['building_name']; ?></td>
					<td><?php echo $newFixtures['lab_name']; ?></td>
					<td><?php if($newFixtures['remarks']=='For Repair'){echo "<font color='red'>".$newFixtures['remarks']."</font>";}else{echo $newFixtures['remarks'];} ?></td>
					<td>
						<!-- Start Drop down Delete here -->
						<button class="btn btn-warning btn-sm dropdown-toggle" href="#" style="color: #5D4037;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-outdent"></i>  Pull out </button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="padding: 10px !important; font-size: 14px;">Proceed? You cannot undo the changes<br/>
							<a class="btn btn-primary btn-sm" style="" href="process_transfer_pc.php?pull_out_fixture=yes&unit_id=<?php echo $newFixtures['id']; ?>&building=<?php echo $newFixtures['building_id']; ?>&laboratory=<?php echo $newFixtures['lab_id']; ?>&type=<?php echo strtoupper($newFixtures['type']);  ?>"><i class="fas fa-outdent"></i>  Proceed</a>
							<a href="#" class='btn btn-success btn-sm'><i class="far fa-window-close"></i> Cancel</a>
						</div>
					</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>

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
		padding-right: 5%;
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
	td:nth-of-type(5):before { content: "Room Laboratory: "; font-weight: bold; }
	td:nth-of-type(6):before { content: "Remarks: "; font-weight: bold; }
	td:nth-of-type(7):before { content: "Actions: "; font-weight: bold; }
}
</style>
<!-- EOF -->