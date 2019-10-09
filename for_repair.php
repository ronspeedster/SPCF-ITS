<?php
$currentItem='for_repair';
include('sidebar.php');
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$getURI = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$_SESSION['getURI'] = $getURI;
include('process_misc_things.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>For Repair Peripherals</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<script src="js/demo/datatables-demo.js"></script>
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
		echo "<h5 style='color: blue;'>For Repair PC Components and Peripherals</h5>";
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
	?>

	<!-- Responsive Form -->
	<div class="row col-md-12 mb-2" style="">
		<div class="col-md-6 mb-1" style="padding: 1%; margin: auto;">
			<center><b>Select Type:</b></center>
		</div>
		<div class="col-md-6 mb-1" style="padding: 1%; margin: auto;">
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
		</div>
	</div>
	<!-- End Responsive Form -->

	<h5 style="color: blue;" class="form-control">List of Components and Peripherals currentlty in For Repair</h5>
	<div class='row justify-content-center'>
	<?php
	if($current_type=="*"){
		//$getStockRooms = mysqli_query($mysqli, "SELECT * FROM peripherals WHERE unit_id='StockRoom' AND remarks='ForRepair'");
		$getStockRooms = mysqli_query($mysqli, "SELECT * FROM peripherals WHERE remarks='For Repair'");
	}
	else{
		//$getStockRooms = mysqli_query($mysqli, "SELECT * FROM peripherals WHERE unit_id='StockRoom' AND peripheral_type='$current_type' AND remarks='ForRepair'");
		$getStockRooms = mysqli_query($mysqli, "SELECT * FROM peripherals WHERE peripheral_type='$current_type' AND remarks='For Repair'");
	}
	?>
	<div class="table-responsive row" style="padding: 1%;">
		<table class="table" id="dataTable" width="100%" cellspacing="0">
		<thead>
			<tr>
				<th>Type</th>
				<th>Brand</th>
				<th>Description</th>
				<th>Serial ID</th>
				<th>Date Purchased</th>
				<th>Date Issued</th>
				<th>Condition</th>
				<th>For Repair?</th>
				<th>Actions</th>
			</tr>
		</thead>
				<?php
				if(mysqli_num_rows($getStockRooms)==0){
					echo "<div class='alert alert-warning'>No ".$current_type." currently for repair</div>";
				}
				else{
					while($perripheral_row=$getStockRooms->fetch_assoc()){ ?>
			<tr>
				<td><?php echo $perripheral_row['peripheral_type']; ?></td>
				<td><?php echo $perripheral_row['peripheral_brand']; ?></td>
				<td><?php echo $perripheral_row['peripheral_description']; ?></td>
				<td><?php echo $perripheral_row['peripheral_serial_no']; ?></td>
				<td><?php echo $perripheral_row['peripheral_date_purchased']; ?></td>
				<td><?php echo $perripheral_row['peripheral_date_issued']; ?></td>
				<td><?php echo $perripheral_row['peripheral_condition']; ?></td>
				<td><?php echo $perripheral_row['remarks']; ?></td>
				<td>
				<a class="btn btn-success btn-secondary btn-sm" href="<?php echo 'report_peripherals.php?peripheral_id='.$perripheral_row['peripheral_id'].'&is_fix=true'; ?>"><i class="far fa-edit"></i> Edit</a>
				<button style="display: none;" class="btn btn-danger btn-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="far fa-trash-alt"></i> Delete
						</button><div class="dropdown-menu" aria-labelledby="dropdownMenuButton btn-sm">
						You sure you want to delete? You cannot undo the changes<br/>
							<a href="process_misc_things.php?delete=<?php echo $perripheral_row['peripheral_id'] ?>" class='btn btn-danger btn-sm'><i class="far fa-trash-alt"></i> Confirm Delete</a>
							<a href="#" class='btn btn-success btn-sm'><i class="far fa-window-close"></i> Cancel</a> 
				</div></td>
			</tr>
				<?php	
					}}
				?>
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
		padding-right: 1%;
		white-space: nowrap;
	}

	/*
	Label the data
	You could also use a data-* attribute and content for this. That way "bloats" the HTML, this way means you need to keep HTML and CSS in sync. Lea Verou has a clever way to handle with text-shadow.
	*/
	td:nth-of-type(1):before { content: "Type:"; font-weight: bold;}
	td:nth-of-type(2):before { content: "Brand:"; font-weight: bold; }
	td:nth-of-type(3):before { content: "Description:"; font-weight: bold; }
	td:nth-of-type(4):before { content: "Serial ID:"; font-weight: bold; }
	td:nth-of-type(5):before { content: "Date Purchased:"; font-weight: bold; }
	td:nth-of-type(6):before { content: "Date Issued:"; font-weight: bold; }
	td:nth-of-type(7):before { content: "Condition:"; font-weight: bold; }
	td:nth-of-type(8):before { content: "Remarks:"; font-weight: bold; }
	td:nth-of-type(9):before { content: "Actions:"; font-weight: bold; }
}
</style>

<!-- EOF -->
