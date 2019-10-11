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
	<title>For Repair Fixtures</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<script src="js/demo/datatables-demo.js"></script>

	<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
	<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

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
<div class="card shadow row justify-content-center" style="padding: 2%; margin: 1%;">

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
		$getFixtureForRepair = mysqli_query($mysqli, "SELECT * FROM fixture WHERE remarks='For Repair'");
	?>

		<table class="table" id="dataTable" width="100%" cellspacing="0" role="table">
			<thead role="rowgroup">
				<tr role="row">
					<th role="columnheader">Type</th>
					<th role="columnheader">Batch ID</th>
					<th role="columnheader">Serial ID</th>
					<th role="columnheader">Last Cleaned</th>
					<th role="columnheader">Condition</th>
					<th role="columnheader">For Repair?</th>
					<th role="columnheader">Actions</th>
				</tr>
			</thead>
			<tbody role="rowgroup">
				<?php
				if(mysqli_num_rows($getFixtureForRepair)==0){
					echo "<div class='alert alert-warning'>No Fixture(s) currently for repair</div>";
				}
				else{
					while($fixture_row=$getFixtureForRepair->fetch_assoc()){ ?>
				
				<tr role="row">
					<td role="cell"><?php echo strtoupper($fixture_row['type']); ?></td>
					<td role="cell"><?php echo $fixture_row['batch_code']; ?></td>
					<td role="cell"><?php if($fixture_row['serial_no']==''){echo "<font color='red'>NO SN</font>";}else{echo $fixture_row['serial_no'];} ?></td>
					<td role="cell"><?php echo $fixture_row['date_last_clean']; ?></td>
					<td role="cell"><?php echo $fixture_row['fixture_condition']; ?></td>
					<td role="cell"><?php echo $fixture_row['remarks']; ?></td>
					<td role="cell">
					<a target="_blank" class="btn btn-success btn-secondary btn-sm" href="<?php echo 'report_fixture.php'.'?fixture_id='.$fixture_row['id'].'&is_fix=true'; ?>"><i class="far fa-edit"></i> Edit</a>
					<button style="display: none;" class="btn btn-danger btn-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="far fa-trash-alt"></i> Delete
							</button><div class="dropdown-menu" aria-labelledby="dropdownMenuButton btn-sm">
							You sure you want to delete? You cannot undo the changes<br/>
								<a href="process_misc_things.php?delete=<?php echo $perripheral_row['peripheral_id'] ?>" class='btn btn-danger btn-sm'><i class="far fa-trash-alt"></i> Confirm Delete</a>
								<a href="#" class='btn btn-success btn-sm'><i class="far fa-window-close"></i> Cancel</a> 
					</div>
					</td>
				</tr>
					<?php	
						}}
					?>
				</tbody>
		</table>

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
		padding-right: 5%;
		white-space: nowrap;
	}

	/*
	Label the data
	You could also use a data-* attribute and content for this. That way "bloats" the HTML, this way means you need to keep HTML and CSS in sync. Lea Verou has a clever way to handle with text-shadow.
	*/
	td:nth-of-type(1):before { content: "Type:"; font-weight: bold;}
	td:nth-of-type(2):before { content: "Batch ID:"; font-weight: bold; }
	td:nth-of-type(3):before { content: "Serial ID:"; font-weight: bold; }
	td:nth-of-type(4):before { content: "Last Cleaned:"; font-weight: bold; }
	td:nth-of-type(5):before { content: "Condition: "; font-weight: bold; }
	td:nth-of-type(6):before { content: "For Repair?: "; font-weight: bold; }
	td:nth-of-type(7):before { content: "Actions: "; font-weight: bold; }
}
</style>

<!-- EOF -->
