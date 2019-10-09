<?php
$currentItem='equipments';
include('sidebar.php');
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$getURI = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$_SESSION['getURI'] = $getURI;
include('process_misc_things.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>View Other Fixtures</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<script src="js/demo/datatables-demo.js"></script>
	<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
	<script type="text/javascript">
		$(document).ready(function() {
			$('#fixtureTable').DataTable( {
				responsive: true,
				"pageLength": 25,	
				"order": [[ 4, "desc" ]]
			} );
		} );
	</script>
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
				?>
				<div class="card shadow row justify-content-center" style="padding: 1%; margin: 1%;">
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
					endif;
					echo "<h5 style='color: blue;'>View Other Fixtures</h5>";
					?>
					<!-- Add Building Here -->
					<br/>
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
					$getCategories = mysqli_query($mysqli, "SELECT DISTINCT type FROM fixture WHERE type <> 'airconditioner' ");
					?>
					<div class="row col-md-12">
								<div class="col-md-6 mb-1" style="text-align: center;"><b>Select Type:</b> </div>
								<div class="col-md-6 mb-1">
									<select class="form-control" onchange="location = this.value;">
										<option disabled selected>Select Fixture</option>
										<?php while($newCategories=$getCategories->fetch_assoc()){  ?>
											<option value="<?php echo $fileName.'?type='.$newCategories['type'];?>"><?php echo strtoupper($newCategories['type']); ?></option>
										<?php } ?>
										<option value="<?php echo $fileName.'?type=*';?>">All Type</option>
									</select>
								</div>
					</div>
					<h5 style="color: blue;" class="form-control mb-1">List of Fixtures</h5>
					<div class='row justify-content-center'>
						<?php
						if($current_type=="*"){
						//$getStockRooms = mysqli_query($mysqli, "SELECT * FROM peripherals WHERE unit_id='StockRoom' AND remarks='ForRepair'");
							$getFixture = mysqli_query($mysqli, "SELECT f.*, f.id AS fixture_id, b.building_name, l.lab_name FROM fixture f
								JOIN building b
								ON b.building_id = f.building_id
								JOIN laboratory l
								ON l.lab_id = f.lab_id WHERE type <> 'airconditioner' ");
						}
						else{
						//$getStockRooms = mysqli_query($mysqli, "SELECT * FROM peripherals WHERE unit_id='StockRoom' AND peripheral_type='$current_type' AND remarks='ForRepair'");
							$getFixture = mysqli_query($mysqli, "SELECT f.*, f.id AS fixture_id, b.building_name, l.lab_name FROM fixture f
								JOIN building b
								ON b.building_id = f.building_id
								JOIN laboratory l
								ON l.lab_id = f.lab_id
								WHERE type='$current_type' AND type <> 'airconditioner' ");
						}
						?>
						<div class="table-responsive">
							<table class="table" id="fixtureTable" width="100%" cellspacing="0" role="table">
								<thead role="rowgroup"> 
									<tr role="row" class="">
										<th role="columnheader">Type</th>
										<th style="display: none;">Batch Code</th>
										<th role="columnheader">Serial Code</th>
										<th role="columnheader">Building</th>
										<th role="columnheader">Room / Laboratory</th>
										<th role="columnheader" style="display: none;" role="columnheader">Condition</th>
										<th role="columnheader" width="20%" >Actions</th>
									</tr>
								</thead>
								<tbody role="rowgroup">
								<?php
								if(mysqli_num_rows($getFixture)==0){
									echo "<div class='alert alert-warning'>No ".$current_type." currently for repair</div>";
								}
								else{
									while($newFixture=$getFixture->fetch_assoc()){
										?>

									<tr role="row">
										<td role="cell"><?php echo strtoupper($newFixture['type']); $getFixtureID = $newFixture['id']; ?></td>
										<td role="cell" style="display: none;"><?php echo $newFixture['batch_code']; ?></td>
										<td role="cell"><?php if($newFixture['serial_no']==''){echo "<span class='text-danger'>NO SC</span>";}else{echo $newFixture['serial_no'];} //echo $newFixture['serial_no']; ?></td>
										<td role="cell"><?php echo $newFixture['building_name']; ?></td>
										<td role="cell"><?php echo $newFixture['lab_name']; ?></td>
										<td role="cell" style="display: none;"><?php echo strtoupper($newFixture['fixture_condition']); ?></td>
										<td role="cell">
											<a class="btn btn-success btn-secondary btn-sm mb-1" href="edit_fixture.php?type=<?php echo $newFixture['type']; ?>&id=<?php echo $newFixture['id'];?>&building_id=<?php echo $newFixture['building_id']; ?>"><i class="far fa-edit"></i> Edit</a>
											<!-- Update 2019-09-25 add QR -->
											<!-- While the subdomain is not available, change the ip address -->
											<a class="btn btn-primary btn-sm mb-1" href="generate_qr.php?data=https://192.168.2.1/spcf-its/scan_qr.php?isfixture=true$id=<?php echo $getFixtureID; ?>"><i class="fas fa-qrcode"></i> QR Code</a>
											<a style='color: #5D4037;' class='btn btn-sm btn-warning mb-1' href="report_fixture.php?fixture_id=<?php echo $newFixture['id']?>" target='_blank'><i class="fas fa-bug"></i> Report</a>
											<button class="btn btn-danger btn-secondary dropdown-toggle btn-sm mb-1" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<i class="far fa-trash-alt"></i> Delete</button>
												<div class="dropdown-menu" aria-labelledby="dropdownMenuButton btn-sm">
													You sure you want to delete? You cannot undo the changes<br/>
													<a href="process_misc_things.php?delete_fixture=<?php echo $newFixture['fixture_id'] ?>" class='btn btn-danger btn-sm mb-1'><i class="far fa-trash-alt"></i> Confirm Delete</a>
													<a href="#" class='btn btn-success btn-sm mb-1'><i class="far fa-window-close"></i> Cancel</a> 
												</div>
											</td>
									</tr>
									<?php
									}
							}
							?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- End Here-->
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
	td:nth-of-type(1):before { content: "Type:"; font-weight: bold;}
	td:nth-of-type(2):before { content: "Batch Code:"; font-weight: bold; }
	td:nth-of-type(3):before { content: "Serial Code:"; font-weight: bold; }
	td:nth-of-type(4):before { content: "Building:"; font-weight: bold; }
	td:nth-of-type(5):before { content: "Room: "; font-weight: bold; }
	td:nth-of-type(6):before { content: "Condition: "; font-weight: bold; }
	td:nth-of-type(7):before { content: "Actions: "; font-weight: bold; }
}
</style>			
<!-- EOF -->
