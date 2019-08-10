<?php
require_once('process_stock_room.php');
$currentItem = 'stock_room';
include('sidebar.php');
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$getURI = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$_SESSION['getURI'] = $getURI;

?>
<!DOCTYPE html>
<html>
<head>
	<title>View - Stock Room</title>

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
	?>
	<!-- Add Stock Item(s) Here -->
	<div class="row justify-content-center">

	</div>
	<br/>
	<h5 style="color: blue;">Stock Room Log View</h5>
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
			<td>Select Type</td>
			<td>
					
				<select class="form-control" onchange="location = this.value;">
					<option class='text-danger' disabled selected><?php echo $type; ?></option>
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
			</td>
		</tr>
	</table>
	<div class='row justify-content-center'>
	<?php
	if($current_type=="*"){
		$getStockRooms = mysqli_query($mysqli, "SELECT * FROM stock_room");
	}
	else{
		$getStockRooms = mysqli_query($mysqli, "SELECT * FROM stock_room WHERE item='$current_type'");
	}
	?>
	<table class="table" id="dataTable" width="100%" cellspacing="0">
		<thead>
		<tr>
			<th>Record ID</th>
			<th>Batch ID</th>
			<th>Date</th>
			<th>Item</th>
			<th style="display: none;">Description</th>
			<th>Beginning Inventory</th>
			<th>Purchased Item</th>
			<th>Requested Item</th>
			<th>Ending Inventory</th>
		</tr>
		</thead>
			<?php
			if(mysqli_num_rows($getStockRooms)==0){
				echo "<div class='alert alert-warning'>No ".$current_type." currently stored in stock room</div>";
			}
			else{
				while($newStockRooms=$getStockRooms->fetch_assoc()){
					$date = date_create($newStockRooms['date_added']);
					?>
		<tr>
			<td><?php echo $newStockRooms['id']; ?></td>
			<td style="text-align: right;"><?php echo $newStockRooms['batch_id']; ?></td>
			<td style="width: 20%;"><?php echo date_format($date, 'F j, Y, g:i a'); ?></td>
			<td><?php echo $newStockRooms['item']; ?></td>
			<td style="display: none;"><?php echo $newStockRooms['description']; ?></td>
			<td><?php echo $newStockRooms['beg_inventory']; ?></td>
			<td><?php echo $newStockRooms['purchased_item']; ?></td>
			<td><?php echo $newStockRooms['request_item']; ?></td>
			<td><?php echo number_format($newStockRooms['total_qty']); ?></td>

		</tr>
			<?php	
				}}
			?>
	</table>
		<center><a class='btn btn-info btn-sm' href="stock_room.php">Stock Room</a></center>
	</div>
<div class="separator" style="height: 200px;">
	
</div>
	<!-- End Here-->
	<?php
	include('footer.php');
?>