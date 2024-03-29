<?php
include('sidebar.php');
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$getURI = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$_SESSION['getURI'] = $getURI;
include('process_misc_things.php');
$counterEquipment = 0;
?>
<!DOCTYPE html>
<html>
<head>
	<title>Add / Edit Misc. Things</title>

	<script src="libs/js/bootstrap.min.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>
<body>
<div class="container">
	<?php
	include('topbar.php');
?>

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
		if($update_equipment){
			echo "<h5 style='color: blue;'>Update ".$peripheral_type."</h5>";
		}
		else{
			echo "<h5 style='color: blue;'>Add PC Equipments for stock rooms</h5>";
		}
	?>
	<!-- Add Building Here -->
	<div class="row justify-content-center">
	<form action="process_misc_things.php" method="POST">
	<table class='table'>
		<thead>
			<tr>
					
					<th>Equipment Type</th>
					<th>Brand</th>
					<th>Description</th>
					<th>Serial ID</th>
					<th>Date Purchased</th>
			</tr>
					
				<td><select class="form-control" name="equipment-type" <?php //if($update_equipment){echo 'disabled';} ?>>
						<option value="<?php echo $monitor='Monitor';?>" <?php if($update_equipment==true&&$monitor==$peripheral_type){echo "selected";}?>>Monitor</option>
						<option value="<?php echo $keyboard='Keyboard'?>" <?php if($update_equipment==true&&$keyboard==$peripheral_type){echo "selected";}?>>Keyboard</option>
						<option value="<?php echo $mouse='Mouse';?>" <?php if($update_equipment==true&&$mouse==$peripheral_type){echo "selected";}?>>Mouse</option>
						<option value="<?php echo $AVR='AVR';?>" <?php if($update_equipment==true&&$AVR==$peripheral_type){echo "selected";}?>>AVR</option>
						<option value="<?php echo $headset='Headset'; ?>"  <?php if($update_equipment==true&&$headset==$peripheral_type){echo "selected";}
							?>>Headset</option>
						<option value="<?php echo $CPU='CPU';?>" <?php if($update_equipment==true&&$CPU==$peripheral_type){echo "selected";}?>>CPU</option>
						<option value="<?php echo $motherboard='Motherboard'; ?>">Motherboard</option>
						<option value="<?php echo $GPU='GPU'; ?>" <?php if($update_equipment==true&&$GPU==$peripheral_type){echo "selected";}?>>GPU</option>
						<option value="<?php echo $RAM='RAM'; ?>" <?php if($update_equipment==true&&$RAM==$peripheral_type){echo "selected";}?>>RAM</option>
						<option value="<?php echo $HDD='HDD'; ?>" <?php if($update_equipment==true&&$HDD==$peripheral_type){echo "selected";}?>>HDD</option>
					</select>
				</td>
				<td><input class="form-control" type="text" name="brand" required value="<?php if($update_equipment==true){echo $peripheral_brand;}
					?>"></td>
				<td><textarea  style="min-height: 40px; height: 40px; min-width: 150px;" type="text" class="form-control" name="equipment-description" class="form-control" placeholder="Enter Building Description" value="" required><?php echo $equipment_description ?><?php if($update_equipment==true){echo $peripheral_description;}?></textarea></td>
				<td><input class="form-control" type="text" name="serial-id" value="<?php if($update_equipment==true){echo $peripheral_serial_no;} ?>" required></td>
				<td><input class="form-control" type="date" name="date-of-purchased" value="<?php if($update_equipment==true){echo $peripheral_date_purchased;} ?>" required></td>
			</tr>
			<tr>
					<th>Amount</th>
					<th>Date Issued</th>
					<th>Condition</th>
					<th>For Repair?</th>
					<th>Actions </th>
			</tr>
			<tr>
				<td><input class="form-control" type="number" name="amount" value="<?php if($update_equipment==true){echo $peripheral_amount;} ?>" required></td>
				<td><input class="form-control" type="date" name="date-issued" value="<?php if($update_equipment==true){echo $peripheral_date_issued;} ?>" required></td>
				<td><select class="form-control" name="condition">
						<option value="<?php echo $working='working';?>" <?php if($update_equipment==true&&$working==$peripheral_condition){echo 'selected';}?>>Working</option>
						<option value="<?php echo $notWorking='Not Working';?>" <?php if($update_equipment==true&&$notWorking==$peripheral_condition){echo 'selected';}?>>Not Working</option>
					</select>
				</td>
				<td><select class="form-control" name="forRepair">
						<option value="<?php echo $notForRepair='Not For Repair';?>" <?php if($update_equipment==true&&$notForRepair==$remarks){echo 'selected';} ?>>No</option>
						<option value="<?php echo $forRepair='Yes'; ?>" <?php if($update_equipment==true&&$forRepair==$remarks){echo 'selected';} ?>>Yes</option>
					</select></td>
				<td><?php
					if($update_equipment==true):
							?>
							<button type="submit" class="btn btn-info btn-sm" name="update"><i class="far fa-save"></i> Update</button>
					<?php
						else: 
						?>
					<button type="submit" class="btn btn-primary btn-sm" name="save"><i class="far fa-save"></i> Save</button>
					<?php endif;?>
					<a href="misc_things.php" id="refresh" class='btn btn-danger btn-sm'><i class="fas as fa-sync"></i> Clear/Refresh</a>
				</td>
				<td></th></td>				
			</tr>
		</thead>
	</table>
	</form>
	</div>
	<br/>
	<h5 style="color: blue;">List of Equipments in Stock Room</h5>
	<?php
		$fileName = basename($_SERVER['PHP_SELF']);
		if(!isset($_GET['type'])){
			$current_type = '*';
		}
		else{
			$current_type = $_GET['type'];	
		}



	?>
	<table class="table">
		<tr>
			<td>Select Type</td>
			<td>
					
				<select class="form-control" onchange="location = this.value;">
					<option>Equipments</option>
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
		$getStockRooms = mysqli_query($mysqli, "SELECT * FROM peripherals WHERE unit_id='StockRoom'");
	}
	else{
		$getStockRooms = mysqli_query($mysqli, "SELECT * FROM peripherals WHERE unit_id='StockRoom' AND peripheral_type='$current_type'");
	}
	?>
	<table class="table" id="dataTable" width="100%" cellspacing="0">
		<thead>
			<tr>
			<th>No.</th>
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
				echo "<div class='alert alert-warning'>No ".$current_type." currently stored in stock room</div>";
			}
			else{
				while($perripheral_row=$getStockRooms->fetch_assoc()){ ?>
		<tr>
			<td><?php echo ++$counterEquipment; ?></td>
			<td><?php echo $perripheral_row['peripheral_type']; ?></td>
			<td><?php echo $perripheral_row['peripheral_brand']; ?></td>
			<td><?php echo $perripheral_row['peripheral_description']; ?></td>
			<td><?php echo $perripheral_row['peripheral_serial_no']; ?></td>
			<td><?php echo $perripheral_row['peripheral_date_purchased']; ?></td>
			<td><?php echo $perripheral_row['peripheral_date_issued']; ?></td>
			<td><?php echo $perripheral_row['peripheral_condition']; ?></td>
			<td><?php echo $perripheral_row['remarks']; ?></td>
			<td>
			<a class="btn btn-success btn-secondary btn-sm" href="<?php echo $fileName.'?edit='.$perripheral_row['peripheral_id']; ?>"><i class="far fa-edit"></i> Edit</a>
			<button class="btn btn-danger btn-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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