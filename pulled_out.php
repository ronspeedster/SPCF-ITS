<?php
require_once 'process_transfer_pc.php';
$currentItem = 'transfer';
include('sidebar.php');
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$getURI = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$_SESSION['getURI'] = $getURI;
$currentDate = date("Y/m/d");
//$getURI = $_SERVER['QUERY_STRING'];
//echo $query; // Outputs: Query String
?>
<!DOCTYPE html>
<html>
<head>
	<title>View Pulled Out Equipments</title>
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
		$getPulledOutPC = mysqli_query($mysqli, "SELECT et.type, et.id, et.equipment_id, et.date_added, b.building_name, l.lab_name/*, up.unit_name*/ FROM equipment_transfer et  
			JOIN building b ON b.building_id = et.from_building
			JOIN laboratory l ON l.lab_id = et.from_lab
			/*JOIN unit_pc up ON up.unit_id =  et.equipment_id*/
			WHERE et.status='pending'");
	?>

	<div class="car shadow row" style="padding: 1%;">

	<h5 style='color: blue;'>Pulled Out Equipments in storage room</h5>

	<table class="table" id="dataTable" width="100%" cellspacing="0">
		<thead>
			<th>Equipment ID</th>
			<th>Type</th>
			<th>From Building</th>
			<th>From Room / Laboratory</th>
			<th>Actions</th>
		</thead>
		<tbody>
			<?php while($newPulledOutPC=$getPulledOutPC->fetch_assoc()){ ?>
			<tr>
				<td><?php echo $newPulledOutPC['equipment_id']; ?></td>
				<td><?php echo $newPulledOutPC['type']; ?></td>
				<td><?php echo $newPulledOutPC['building_name']; ?></td>
				<td><?php echo $newPulledOutPC['lab_name']; ?></td>
				<td>
				<?php if($newPulledOutPC['type']=='PC'){ ?>
					<a target="_blank" href="deliver_pc.php?deliver=yes&equipment_id=<?php echo $newPulledOutPC['equipment_id']; ?>&transfer_id=<?php echo $newPulledOutPC['id']; ?>" class="btn btn-sm btn-success">Deliver To <i class="fas fa-truck"></i></a>
				<?php } else { ?>
					<a target="_blank" href="deliver_fixture.php?deliver=yes&equipment_id=<?php echo $newPulledOutPC['equipment_id']; ?>&type=<?php echo $newPulledOutPC['type'];?>&transfer_id=<?php echo $newPulledOutPC['id']; ?>" class="btn btn-sm btn-success">Deliver To <i class="fas fa-truck"></i></a>
				<?php } ?>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>	

	</div>

	<br/>
	<br/>
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
	td:nth-of-type(1):before { content: "Equipment ID:"; font-weight: bold;}
	td:nth-of-type(2):before { content: "Type:"; font-weight: bold; }
	td:nth-of-type(3):before { content: "From Building:"; font-weight: bold; }
	td:nth-of-type(4):before { content: "From Room / Laboratory:"; font-weight: bold; }
	td:nth-of-type(5):before { content: "Actions: "; font-weight: bold; }
}
</style>
<!-- EOF -->
