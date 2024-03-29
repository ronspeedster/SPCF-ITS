<?php
$currentItem='for_repair';
include('sidebar.php');
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$getURI = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$_SESSION['getURI'] = $getURI;

$account_id = $_SESSION['account_id'];
include('process_misc_things.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>For Repair Fixtures</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<script src="../js/demo/datatables-demo.js"></script>
	<link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
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
		echo "<h5 style='color: blue;'>For Repair Fixtures</h5>";
	?>
	<!-- Add Building Here -->
	<div class="row justify-content-center">
	<form action="process_misc_things.php" method="POST">
	</form>
	</div>
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
	<h5 style="color: blue; display: none;" class="form-control">List of Fixtures For Repair</h5>
	<div class='row justify-content-center'>
	<?php
		$getFixtureForRepair = mysqli_query($mysqli, "SELECT * FROM fixture f
			JOIN laboratory l ON l.lab_id = f.lab_id
			JOIN building b ON f.building_id = b.building_id
			JOIN designation d ON d.building_id = b.building_id
			WHERE remarks='For Repair' AND d.account_id='$account_id' ");
	?>
	<table class="table" id="dataTable" width="100%" cellspacing="0">
	<thead>
		<tr>
			<th>Type</th>
			<th>Batch ID</th>
			<th>Serial ID</th>
			<th>Last Cleaned</th>
			<th>Condition</th>
			<th>Building</th>
			<th>Laboratory</th>
			<th style="display: none;">Actions</th>
		</tr>
	</thead>
			<?php
			if(mysqli_num_rows($getFixtureForRepair)==0){
				echo "<div class='alert alert-warning'>No Fixture(s) currently for repair</div>";
			}
			else{
				while($fixture_row=$getFixtureForRepair->fetch_assoc()){ ?>
		<tr>
			<td><?php echo strtoupper($fixture_row['type']); ?></td>
			<td><?php echo $fixture_row['batch_code']; ?></td>
			<td><?php if($fixture_row['serial_no']==''){echo "<font color='red'>NO SN</font>";}else{echo $fixture_row['serial_no'];} ?></td>
			<td><?php echo $fixture_row['date_last_clean']; ?></td>
			<td><?php echo $fixture_row['fixture_condition']; ?></td>
			<td><?php echo $fixture_row['building_name']; ?></td>
			<td><?php echo $fixture_row['lab_name']; ?></td>
			<td style="display: none;">
			<a style="display: none;" target="_blank" class="btn btn-success btn-secondary btn-sm" href="<?php echo 'report_fixture.php'.'?fixture_id='.$fixture_row['id'].'&is_fix=true'; ?>"><i class="far fa-edit"></i> Edit</a>
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

	<!-- End Here-->
	<?php
	include('footer.php');
?>