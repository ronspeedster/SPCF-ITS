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
	<title>Fixed Peripherals</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<script src="js/demo/datatables-demo.js"></script>
	<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
	<script type="text/javascript">
		$(document).ready(function() {
    $('#periheralTable').DataTable( {
        "order": [[ 7, "desc" ]]
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
	<?php } ?>
	<!-- Fixed PC Peripherals and Components -->

	<div class="card shadow row justify-content-center" style="padding: 1%;">
	<h5 style='color: blue;'>Fixed PC Peripherals and Components</h5>
	<form action="process_misc_things.php" method="POST">
	</form>

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

	<table class="table">
		<tr>
			<th><center>Select Type: </center></th>
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
	<h5 style="color: blue;" class="form-control">List of PC Equipments Fixed</h5>
	<?php
	if($current_type=="*"){
		//$getStockRooms = mysqli_query($mysqli, "SELECT * FROM peripherals WHERE unit_id='StockRoom' AND remarks='ForRepair'");
		$getStockRooms = mysqli_query($mysqli, "SELECT p.*, fr.* FROM peripherals p
			/* LEFT */ JOIN fix_report fr
			ON p.peripheral_id = fr.item_id
			WHERE remarks='Fixed'
			AND fr.type='peripheral' ");
	}
	else{
		//$getStockRooms = mysqli_query($mysqli, "SELECT * FROM peripherals WHERE unit_id='StockRoom' AND peripheral_type='$current_type' AND remarks='ForRepair'");
		$getStockRooms = mysqli_query($mysqli, "SELECT p.*, fr.* FROM peripherals p 
			/* LEFT */ JOIN fix_report fr 
			ON p.peripheral_id = fr.item_id 
			WHERE remarks='Fixed'
			AND peripheral_type='$current_type'
			AND fr.type='peripheral' ");
	}
	?>
	<table class="table" id="periheralTable" width="100%" cellspacing="0" role="table">
		<thead role="rowgroup">
			<tr role="row">
				<th role="columnheader">ID</th>
				<th role="columnheader">Type</th>
				<th role="columnheader">Brand</th>
				<th role="columnheader">Description</th>
				<th role="columnheader">Serial ID</th>
				<th style="display: none;">Date Purchased</th>
				<th role="columnheader">Date Issued</th>
				<th role="columnheader">Remarks</th>
				<th role="columnheader">Date Fixed</th>
				<th role="columnheader">Cost</th>
				<th role="columnheader">Receipt</th>

			</tr>
		</thead>
		<tbody role="rowgroup">
			<?php
			$totalRepairCost = 0;
			if(mysqli_num_rows($getStockRooms)==0){
				echo "<div class='alert alert-warning'>No ".$current_type." fixed</div>";
			}
			else{
				while($perripheral_row=$getStockRooms->fetch_assoc()){
					$totalRepairCost += $perripheral_row['repair_cost'];?>
		<tr>
			<td role="cell"><?php echo $perripheral_row['id']; ?></td>
			<td role="cell"><?php echo $perripheral_row['peripheral_type']; ?></td>
			<td role="cell"><?php echo $perripheral_row['peripheral_brand']; ?></td>
			<td role="cell"><?php echo $perripheral_row['peripheral_description']; ?></td>
			<td role="cell"><?php echo $perripheral_row['peripheral_serial_no']; ?></td>
			<td role="cell" style="display: none;"><?php echo $perripheral_row['peripheral_date_purchased']; ?></td>
			<td role="cell"><?php echo $perripheral_row['peripheral_date_issued']; ?></td>
			<td role="cell"><?php echo $perripheral_row['remarks'] ?></td>
			<td role="cell"><?php echo $perripheral_row['date_added']; ?></td>
			<td role="cell"><?php echo "₱ ".number_format($perripheral_row['repair_cost'],2,".",","); ?></td>
			<td role="cell"><a class="btn btn-sm btn-info" href="img/assets/<?php echo $perripheral_row['file_name'] ?>" target="_blank"><i class="far fa-image"></i> Image</a></td>
		</tr>
			<?php	
				}}
			?>
		</tbody>
	</table>
	<span class="text-danger font-weight-bold"><center>Total Repair Cost: ₱ <?php echo $totalRepairCost; ?></center></span>
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
		background: #fcfce3;
	}

	tr:nth-child(odd) {
		padding: 1%;
		width: 100%;
		border-bottom: 2px solid grey;
		border-top: 2px solid grey;
		background: none;
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
	td:nth-of-type(3):before { content: "Brand:"; font-weight: bold; }
	td:nth-of-type(4):before { content: "Description:"; font-weight: bold; }
	td:nth-of-type(5):before { content: "Serial ID:"; font-weight: bold; }
	td:nth-of-type(6):before { content: "Date Purchased:"; font-weight: bold; }
	td:nth-of-type(7):before { content: "Date Issued:"; font-weight: bold; }
	td:nth-of-type(8):before { content: "Remarks:"; font-weight: bold; }
	td:nth-of-type(9):before { content: "Date Fixed:"; font-weight: bold; }
	td:nth-of-type(10):before { content: "Cost:"; font-weight: bold; }
	td:nth-of-type(11):before { content: "Receipt:"; font-weight: bold; }
}
</style>
<!-- EOF -->