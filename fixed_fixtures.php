<?php
$currentItem='fixed_equipment';
include('sidebar.php');
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$getURI = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$_SESSION['getURI'] = $getURI;
include('process_misc_things.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Fixed Fixtures</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<script src="js/demo/datatables-demo.js"></script>
	<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
	<script type="text/javascript">
		$(document).ready(function() {
		$('#dataTable').DataTable( {
		    responsive: true
			} );
		};
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
	<div class="card shadow row justify-content-center" style="padding: 1%;">
		<h5 style='color: blue;'>Fixed Fixtures</h5>
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
	?>

	<table class="table" style="display: none;">
		<tr>
			<th style="text-align: right;">Select Type: </th>
			<th>
					
				<select class="form-control" onchange="location = this.value;">
					<option class="text-danger" disabled selected><?php echo $type; ?></option>
					<option value="<?php echo $fileName.'?type=*';?>">All Types</option>
					<option value="<?php echo $fileName.'?type=Monitor';?>">Monitor</option>
					<option value="<?php echo $fileName.'?type=Keyboard';?>">Keyboard</option>
					<option value="<?php echo $fileName.'?type=Mouse';?>">Mouse</option>
					<option value="<?php echo $fileName.'?type=AVR';?>">AVR</option>
					<option value="<?php echo $fileName.'?type=Headset';?>">Headset</option>
					<option value="<?php echo $fileName.'?type=CPU';?>">CPU</option>
					<option value="<?php echo $fileName.'?type=Motherboard';?>">Motherboard</option>
					<option value="<?php echo $fileName.'?type=GPU';?>">GPU</option>
					<option value="<?php echo $fileName.'?type=RAM';?>">RAM</option>
					<option value="<?php echo $fileName.'?type=HDD';?>">HDD</option>
				</select>
			</th>
		</tr>
	</table>
	<h5 class="form-control" style="color: blue;">List of Fixtures For Repair</h5>
	<?php
		$getFixtureForRepair = mysqli_query($mysqli, "SELECT f.*, fr.*
				FROM fixture f
				JOIN fix_report fr
				ON fr.item_id = f.id
				WHERE f.remarks = 'Fixed'
				AND fr.type = 'fixture' ");
	?>
	<table class="table" id="dataTable" width="100%" cellspacing="0">
	<thead>
		<tr>
			<th>ID</th>
			<th>Type</th>
			<th>Batch ID</th>
			<th>Serial ID</th>
			<th>Last Cleaned</th>
			<th>Condition</th>
			<th>Remarks</th>
			<th>Date Fixed</th>
			<th>Cost</th>
			<th>Receipt</th>
		</tr>
	</thead>
			<?php
			$totalRepairCost=0;
			if(mysqli_num_rows($getFixtureForRepair)==0){
				echo "<div class='alert alert-warning'>No Fixture(s) currently fixed</div>";
			}
			else{
				while($fixture_row=$getFixtureForRepair->fetch_assoc()){
					$totalRepairCost += $fixture_row['repair_cost'];
				 ?>
		<tr>
			<td><?php echo strtoupper($fixture_row['id']); ?></td>
			<td><?php echo strtoupper($fixture_row['type']); ?></td>
			<td><?php echo $fixture_row['batch_code']; ?></td>
			<td><?php if($fixture_row['serial_no']==''){echo "<font color='red'>NO SN</font>";}else{echo $fixture_row['serial_no'];} ?></td>
			<td><?php echo $fixture_row['date_last_clean']; ?></td>
			<td><?php echo $fixture_row['fixture_condition']; ?></td>
			<td><?php echo $fixture_row['remarks']; ?></td>
			<td><?php echo $fixture_row['date_added']; ?></td>
			<td><?php echo "₱ ".number_format($fixture_row['repair_cost'],2,".",","); ?></td>
			<td><a class="btn btn-sm btn-info" href="img/assets/<?php echo $fixture_row['file_name'] ?>" target="_blank"><i class="far fa-image"></i> Image</a></td>
		</tr>
			<?php	
				}}
			?>
	</table>
	<span class="text-danger font-weight-bold"><center>Total Repair Cost: ₱ <?php echo number_format($totalRepairCost,2,".",","); ?></center></span>
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
	td:nth-of-type(2):before { content: "Type:"; font-weight: bold; }
	td:nth-of-type(3):before { content: "Batch ID:"; font-weight: bold; }
	td:nth-of-type(4):before { content: "Serial ID:"; font-weight: bold; }
	td:nth-of-type(5):before { content: "Last Cleaned:"; font-weight: bold; }
	td:nth-of-type(6):before { content: "Condition:"; font-weight: bold; }
	td:nth-of-type(7):before { content: "Remarks:"; font-weight: bold; }
	td:nth-of-type(8):before { content: "Date Fixed:"; font-weight: bold; }
	td:nth-of-type(9):before { content: "Cost:"; font-weight: bold; }
	td:nth-of-type(10):before { content: "Receipt:"; font-weight: bold; }
}
</style>
<!-- EOF -->
