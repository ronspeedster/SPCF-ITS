<?php
require_once 'process_add_peripheral.php';
$currentItem = 'equipments';
include('sidebar.php');
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$getURI = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$_SESSION['getURI'] = $getURI;
$isUpdate = false;
?>
<!DOCTYPE html>
<html>
<head>
	<title>Add / Edit Peripheral(s) to PC</title>
	<script src="libs/js/bootstrap.min.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

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
	if(!isset($_GET['PcId'])){?>
		No PC is selected. Redirecting you now to the selection page
		<meta http-equiv="Refresh" content="3; url=edit_pc_equipment.php"/>
	<?php
	}
	else{
		$PcId = $_GET['PcId'];
		$checkUnitExistence = $mysqli->query("SELECT * FROM unit_pc WHERE unit_id = $PcId") or die ($mysqli->error);
		if(mysqli_num_rows($checkUnitExistence)==0){?>
			No PC is selected. Redirecting you now to the selection page
			<meta http-equiv="Refresh" content="0; url=edit_pc_equipment.php"/>
		<?php
	}
			$getPCName = $mysqli->query("SELECT * FROM unit_pc WHERE unit_id = $PcId") or die ($mysqli->error);
		while($newGetPCName=$getPCName->fetch_assoc()){
			$PcName=$newGetPCName['unit_name'];
		}
	}


	if(isset($_SESSION['message'])){
?>
	<div class="alert alert-success alert-dismissible">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<?php
			echo $_SESSION['message'];
			unset($_SESSION['message']);
		?>
	</div>
<?php
	}
	?>
	<div class="car shadow row justify-content-center" style="padding: 1%;">
	<form style="width: 100%;" action="process_add_peripheral.php" method="POST">
	<h5 style="color: blue;" >
	<?php 
	if(!isset($_GET['PcId'])){
		//Do nothing
	}
	else{
		echo $PcName." Peripherals</h5>";
		?>
		<input type="form-control" name="unit_id" style="visibility: hidden;" value="<?php echo $PcId; ?>">
		<strong class="float-left">Instructions:</strong><br>A. Please fill out the fields carefully.<br>B. Type NA if not applicable.
		<!-- Start Monitor -->
		<table class='table' width="100%" style="" role="table">
			<thead>
				<tr>
						<th>Type</th>
						<th>Brand<font color="red">*</font></th>
						<th>Description</th>
						<th>Serial Number<font color="red">*</font></th>
						<th>Date Purchased<font color="red" >*</font></th>
						<th style="width: 10%;">Amount<font color="red">*</font></th>
						<th>Date Issued<font color="red">*</font></th>
						<th style="width: 25%;">Remarks<font color="red">*</font></th>
				</tr>
			</thead>
			<?php
				$getMonitor=$mysqli->query("SELECT * FROM peripherals WHERE unit_id=$PcId AND peripheral_type='Monitor'") or die ($mysqli->error());
				$newMonitor = $getMonitor->fetch_array();
				if(mysqli_num_rows($getMonitor)==0){
					$isMonitor = false;
				}
				else{
					$isMonitor = true;
					$isUpdate = true;
				}
			?>
			<tr>
				<td>Monitor</td>
				<td><input class="form-control" type="text" name="monitor-brand" value="<?php if($isMonitor){echo $newMonitor['peripheral_brand'];}else{/*Do nothing*/}?>" required	></td>
 				<td><textarea  class="form-control" name="monitor-description" style="min-height: 40px; height: 40px;" required><?php if($isMonitor){echo $newMonitor['peripheral_description'];}else{/*Do nothing*/}?></textarea></td>
 				<td><input class="form-control" type="text" name="monitor-serialno" value="<?php if($isMonitor){echo $newMonitor['peripheral_serial_no'];}else{/*Do nothing*/}?>" required></td>
 				<td><input class="form-control" type="date" name="monitor-datepurchase" value="<?php if($isMonitor){echo $newMonitor['peripheral_date_purchased'];}else{/*Do nothing*/}?>" required></td>
 				<td><input class="form-control" type="number" min="0" name="monitor-amount" value="<?php if($isMonitor){echo $newMonitor['peripheral_amount'];}else{echo '1';/*Do nothing*/}?>"></td>
 				<td><input class="form-control" type="date" name="monitor-dateissue" value="<?php if($isMonitor){echo $newMonitor['peripheral_date_issued'];}else{/*Do nothing*/}?>" required></td>
 				<td><input style="display: none;" class="form-control" type="text" value="<?php if($isMonitor){echo $newMonitor['remarks'];}else{/*Do nothing*/}?>">
 					<select class='form-control' name='monitor-remarks'	disabled>
 						<option class='text-danger' value='<?php if($isMonitor){echo $newMonitor['remarks'];}else{echo 'Not For Repair';} ?>' selected><?php if($isMonitor){echo $newMonitor['remarks'];}else{echo 'Not For Repair';} ?></option>
 						<option value='Not For Repair'>Not For Repair</option>
 						<option value='For Repair'>For Repair</option>
 					</select>
 				</td>
 				<td>
 					<?php if($isMonitor){ ?>
 						<a style='color: #5D4037;' class='btn btn-sm btn-warning' href="report_peripherals.php?peripheral_id=<?php echo $newMonitor['peripheral_id']?>" target='_blank'><i class="fas fa-bug"></i> Report</a>
 					<?php } ?>
 				</td>
			</tr>
			<!-- End MONITOR -->
			<!-- Start Keyboard -->
			<?php
				$getKeyboard=$mysqli->query("SELECT * FROM peripherals WHERE unit_id=$PcId AND peripheral_type='Keyboard'") or die ($mysqli->error());
				$newKeyboard = $getKeyboard->fetch_array();
				if(mysqli_num_rows($getKeyboard)==0){
					$isKeyboard = false;
				}
				else{
					$isKeyboard = true;
				}
			?>
			<tr>
				<td>Keyboard</td>
				<td><input class="form-control" type="text" name="keyboard-brand" value="<?php if($newKeyboard){echo $newKeyboard['peripheral_brand'];}else{/*Do nothing*/}?>"></td>
 				<td><textarea class="form-control" name="keyboard-description" style="min-height: 40px; height: 40px;"><?php if($newKeyboard){echo $newKeyboard['peripheral_description'];}else{/*Do nothing*/}?></textarea></td>
 				<td><input class="form-control" type="text" name="keyboard-serialno" value="<?php if($newKeyboard){echo $newKeyboard['peripheral_serial_no'];}else{/*Do nothing*/}?>"></td>
 				<td><input class="form-control" type="date" name="keyboard-datepurchase" value="<?php if($newKeyboard){echo $newKeyboard['peripheral_date_purchased'];}else{/*Do nothing*/}?>" required></td>
 				<td><input class="form-control" type="number" min="0" name="keyboard-amount" value="<?php if($newKeyboard){echo $newKeyboard['peripheral_amount'];}else{echo '1';/*Do nothing*/}?>"></td>
 				<td><input class="form-control" type="date" name="keyboard-dateissue" value="<?php if($newKeyboard){echo $newKeyboard['peripheral_date_issued'];}else{/*Do nothing*/}?>" required></td>
 				<td><input style="display: none;" class="form-control" type="text" name="" value="<?php if($newKeyboard){echo $newKeyboard['remarks'];}else{/*Do nothing*/}?>">
					<select class='form-control' name='keyboard-remarks' disabled>
 						<option class='text-danger' value='<?php if($isKeyboard){echo $newKeyboard['remarks'];}else{echo 'Not For Repair';} ?>' selected><?php if($isKeyboard){echo $newKeyboard['remarks'];}else{echo 'Not For Repair';} ?></option>						
 						<option value='Not For Repair'>Not For Repair</option>
 						<option value='For Repair'>For Repair</option>
 					</select>
 				</td>
 				<td>
 					<?php if($isKeyboard){ ?>
 						<a style='color: #5D4037;' class='btn btn-sm btn-warning' href="report_peripherals.php?peripheral_id=<?php echo $newKeyboard['peripheral_id']?>" target='_blank'><i class="fas fa-bug"></i> Report</a>
 					<?php } ?> 					
 				</td>
			</tr>
			<!-- End Keyboard -->
			<!-- Start Mouse -->
			<?php
				$getMouse=$mysqli->query("SELECT * FROM peripherals WHERE unit_id=$PcId AND peripheral_type='Mouse'") or die ($mysqli->error());
				$newMouse = $getMouse->fetch_array();
				if(mysqli_num_rows($getMouse)==0){
					$isMouse = false;
				}
				else{
					$isMouse = true;
				}
			?>
			<tr>
				<td>Mouse</td>				
				<td><input class="form-control" type="text" name="mouse-brand" value="<?php if($isMouse){echo $newMouse['peripheral_brand'];}else{/*Do nothing*/}?>"></td>
 				<td><textarea class="form-control" name="mouse-description" style="min-height: 40px; height: 40px;"><?php if($isMouse){echo $newKeyboard['peripheral_description'];}else{/*Do nothing*/}?></textarea></td>
 				<td><input class="form-control" type="text" name="mouse-serialno" value="<?php if($isMouse){echo $newMouse['peripheral_serial_no'];}else{/*Do nothing*/}?>"></td>
 				<td><input class="form-control" type="date" name="mouse-datepurchase" value="<?php if($isMouse){echo $newMouse['peripheral_date_purchased'];}else{/*Do nothing*/}?>" required></td>
 				<td><input class="form-control" type="number" min="0" name="mouse-amount" value="<?php if($isMouse){echo $newMouse['peripheral_amount'];}else{echo '1';/*Do nothing*/}?>"></td>
 				<td><input class="form-control" type="date" name="mouse-dateissue" value="<?php if($isMouse){echo $newMouse['peripheral_date_issued'];}else{/*Do nothing*/}?>" required></td>
 				<td><input style="display: none;" class="form-control" type="text" name="" value="<?php if($isMouse){echo $newMouse['remarks'];}else{/*Do nothing*/}?>">
 					<select class='form-control' name='mouse-remarks' disabled>
 						<option class='text-danger' value='<?php if($isMouse){echo $newMouse['remarks'];}else{echo 'Not For Repair';} ?>' selected><?php if($isMouse){echo $newMouse['remarks'];}else{echo 'Not For Repair';} ?></option>
 						<option value='Not For Repair'>Not For Repair</option>
 						<option value='For Repair'>For Repair</option>
 					</select>
 				</td>
 				<td>
 					<?php if($isMouse){ ?>
 						<a style='color: #5D4037;' class='btn btn-sm btn-warning' href="report_peripherals.php?peripheral_id=<?php echo $newMouse['peripheral_id']?>" target='_blank'><i class="fas fa-bug"></i> Report</a>
 					<?php } ?> 					
 				</td>
			</tr>
			<!-- End Mouse -->
			<!-- Start AVR -->
			<?php
				$getAVR=$mysqli->query("SELECT * FROM peripherals WHERE unit_id=$PcId AND peripheral_type='AVR'") or die ($mysqli->error());
				$newAVR = $getAVR->fetch_array();
				if(mysqli_num_rows($getAVR)==0){
					$isAVR = false;
				}
				else{
					$isAVR = true;
				}
			?>
			<tr>
				<td>AVR</td>
				<td><input class="form-control" type="text" name="AVR-brand" value="<?php if($isAVR){echo $newAVR['peripheral_brand'];}else{/*Do nothing*/}?>"></td>
				<td><textarea class="form-control" name="AVR-description" style="min-height: 40px; height: 40px;"><?php if($isAVR){echo $newAVR['peripheral_description'];}else{/*Do nothing*/}?></textarea></td>
 				<td><input class="form-control" type="text" name="AVR-serialno" value="<?php if($isAVR){echo $newAVR['peripheral_serial_no'];}else{/*Do nothing*/}?>"></td>
 				<td><input class="form-control" type="date" name="AVR-datepurchase" value="<?php if($isAVR){echo $newAVR['peripheral_date_purchased'];}else{/*Do nothing*/}?>" required></td>
 				<td><input class="form-control" type="number" min="0" name="AVR-amount" value="<?php if($isAVR){echo $newAVR['peripheral_amount'];}else{echo '1';/*Do nothing*/}?>"></td>
 				<td><input class="form-control" type="date" name="AVR-dateissue" value="<?php if($isAVR){echo $newAVR['peripheral_date_issued'];}else{/*Do nothing*/}?>" required></td>
 				<td><input style="display: none;" class="form-control" type="text" name="" value="<?php if($isAVR){echo $newAVR['remarks'];}else{/*Do nothing*/}?>">
 					<select class='form-control' name='AVR-remarks' disabled>
 						<option class='text-danger' value='<?php if($isAVR){echo $newAVR['remarks'];}else{echo 'Not For Repair';} ?>' selected><?php if($isAVR){echo $newAVR['remarks'];}else{echo 'Not For Repair';} ?></option>
 						<option value='Not For Repair'>Not For Repair</option>
 						<option value='For Repair'>For Repair</option>
 					</select>
 				</td>
 				<td>
 					<?php if($isAVR){ ?>
 						<a style='color: #5D4037;' class='btn btn-sm btn-warning' href="report_peripherals.php?peripheral_id=<?php echo $newAVR['peripheral_id']?>" target='_blank'><i class="fas fa-bug"></i> Report</a>
 					<?php } ?> 					
 				</td>
			</tr>
			<!-- End AVR -->
			<!-- Start Headset -->
			<?php
				$getHeadset=$mysqli->query("SELECT * FROM peripherals WHERE unit_id=$PcId AND peripheral_type='Headset'") or die ($mysqli->error());
				$newHeadset = $getHeadset->fetch_array();
				if(mysqli_num_rows($getHeadset)==0){
					$isHeadset = false;
				}
				else{
					$isHeadset = true;
				}
			?>
			<tr>
				<td>Headset</td>
				<td><input class="form-control" type="text" name="headset-brand" value="<?php if($isHeadset){echo $newHeadset['peripheral_brand'];}else{/*Do nothing*/}?>"></td>
				<td><textarea class="form-control" name="headset-description" style="min-height: 40px; height: 40px;"><?php if($isHeadset){echo $newHeadset['peripheral_description'];}else{/*Do nothing*/}?></textarea></td>
 				<td><input class="form-control" type="text" name="headset-serialno" value="<?php if($isHeadset){echo $newHeadset['peripheral_serial_no'];}else{/*Do nothing*/}?>"></td>
 				<td><input class="form-control" type="date" name="headset-datepurchase" value="<?php if($isHeadset){echo $newHeadset['peripheral_date_purchased'];}else{/*Do nothing*/}?>" required></td>
 				<td><input class="form-control" type="number" min="0" name="headset-amount" value="<?php if($isHeadset){echo $newHeadset['peripheral_amount'];}else{echo '1';/*Do nothing*/}?>"></td>
 				<td><input class="form-control" type="date" name="headset-dateissue" value="<?php if($isHeadset){echo $newHeadset['peripheral_date_issued'];}else{/*Do nothing*/}?>" required></td>
 				<td><input style="display: none;" class="form-control" type="text"  value="<?php if($isHeadset){echo $newHeadset['remarks'];}else{/*Do nothing*/}?>">
 					<select class='form-control' name="headset-remarks" disabled>
 						<option class='text-danger' value='<?php if($isHeadset){echo $newHeadset['remarks'];}else{echo 'Not For Repair';} ?>' selected><?php if($isHeadset){echo $newHeadset['remarks'];}else{echo 'Not For Repair';} ?></option>
 						<option value='Not For Repair'>Not For Repair</option>
 						<option value='For Repair'>For Repair</option>
 					</select>
 				</td>
 				<td>
 					<?php if($isHeadset){ ?>
 						<a style='color: #5D4037;' class='btn btn-sm btn-warning' href="report_peripherals.php?peripheral_id=<?php echo $newHeadset['peripheral_id']?>" target='_blank'><i class="fas fa-bug"></i> Report</a>
 					<?php } ?> 					
 				</td>
			</tr>
			<!-- End Headset -->
			<tr>
				<th colspan="7"><h5 class="" style="color: blue;"><?php echo $PcName." Components</h5>"; ?></th>
			</tr>
			<!-- Start Processor -->
			<?php
				$getCPU=$mysqli->query("SELECT * FROM peripherals WHERE unit_id=$PcId AND peripheral_type='CPU'") or die ($mysqli->error());
				$newCPU = $getCPU->fetch_array();
				if(mysqli_num_rows($getCPU)==0){
					$isCPU = false;
				}
				else{
					$isCPU = true;
				}
			?>
			<tr class="second-heading">
					<th>Type</th>
					<th>Brand<font color="red">*</font></th>
					<th>Description</th>
					<th>Serial Number<font color="red">*</font></th>
					<th>Date Purchased<font color="red">*</font></th>
					<th>Amount<font color="red">*</font></th>
					<th>Date Issued<font color="red">*</font></th>
					<th>Remarks<font color="red">*</font></th>
			</tr>
			<tr>
				<td>Processor (CPU)</td>
				<td><input class="form-control" type="text" name="cpu-brand" value="<?php if($isCPU){echo $newCPU['peripheral_brand'];}else{/*Do nothing*/}?>"></td>
 				<td><input class="form-control" type="text" name="cpu-description" value="<?php if($isCPU){echo $newCPU['peripheral_description'];}else{/*Do nothing*/}?>"></td>
 				<td><input class="form-control" type="text" name="cpu-serialno" value="<?php if($isCPU){echo $newCPU['peripheral_serial_no'];}else{/*Do nothing*/}?>"></td>
 				<td><input class="form-control" type="date" name="cpu-datepurchase" value="<?php if($isCPU){echo $newCPU['peripheral_date_purchased'];}else{/*Do nothing*/}?>" required></td>
 				<td><input class="form-control" type="number" min="0" name="cpu-amount" value="<?php if($isCPU){echo $newCPU['peripheral_amount'];}else{echo '1';/*Do nothing*/}?>"></td>
 				<td><input class="form-control" type="date" name="cpu-dateissue" value="<?php if($isCPU){echo $newCPU['peripheral_date_issued'];}else{/*Do nothing*/}?>" required></td>
 				<td><input style="display: none;" class="form-control" type="text" value="<?php if($isCPU){echo $newCPU['remarks'];}else{/*Do nothing*/}?>">
 					<select class='form-control' name="cpu-remarks" disabled>
 						<option class='text-danger' value='<?php if($isCPU){echo $newCPU['remarks'];}else{echo 'Not For Repair';} ?>' selected><?php if($isCPU){echo $newCPU['remarks'];}else{echo 'Not For Repair';} ?></option>
 						<option value='Not For Repair'>Not For Repair</option>
 						<option value='For Repair'>For Repair</option>
 					</select>
 					</td>
 					<td>
 					<?php if($isCPU){ ?>
 						<a style='color: #5D4037;' class='btn btn-sm btn-warning' href="report_peripherals.php?peripheral_id=<?php echo $newCPU['peripheral_id']?>" target='_blank'><i class="fas fa-bug"></i> Report</a>
 					<?php } ?> 						
 					</td>
			</tr>
			<!-- End Processor -->
			<!-- Start Motherboard -->
			<?php
				$getMotherboard=$mysqli->query("SELECT * FROM peripherals WHERE unit_id=$PcId AND peripheral_type='Motherboard'") or die ($mysqli->error());
				$newMotherboard = $getMotherboard->fetch_array();
				if(mysqli_num_rows($getMotherboard)==0){
					$isMotherboard = false;
				}
				else{
					$isMotherboard = true;
				}
			?>
			<tr>
				<td>Motherboard</td>
				<td><input class="form-control" type="text" name="motherboard-brand" value="<?php if($isMotherboard){echo $newMotherboard['peripheral_brand'];}else{/*Do nothing*/}?>"></td>
 				<td><input class="form-control" type="text" name="motherboard-description" value="<?php if($isMotherboard){echo $newMotherboard['peripheral_description'];}else{/*Do nothing*/}?>"></td>
 				<td><input class="form-control" type="text" name="motherboard-serialno" value="<?php if($isMotherboard){echo $newMotherboard['peripheral_serial_no'];}else{/*Do nothing*/}?>"></td>
 				<td><input class="form-control" type="date" name="motherboard-datepurchase" value="<?php if($isMotherboard){echo $newMotherboard['peripheral_date_purchased'];}else{/*Do nothing*/}?>" required></td>
 				<td><input class="form-control" type="number" min="0" name="motherboard-amount" value="<?php if($isMotherboard){echo $newMotherboard['peripheral_amount'];}else{echo '1';/*Do nothing*/}?>"></td>
 				<td><input class="form-control" type="date" name="motherboard-dateissue" value="<?php if($isMotherboard){echo $newMotherboard['peripheral_date_issued'];}else{/*Do nothing*/}?>" required></td>
 				<td><input style="display: none;" class="form-control" type="text" value="<?php if($isMotherboard){echo $newMotherboard['remarks'];}else{/*Do nothing*/}?>">
 					<select class='form-control' name="motherboard-remarks" disabled>
 						<option class='text-danger' value='<?php if($isMotherboard){echo $newMotherboard['remarks'];}else{echo 'Not For Repair';} ?>' selected><?php if($isMotherboard){echo $newMotherboard['remarks'];}else{echo 'Not For Repair';} ?></option>
 						<option value='Not For Repair'>Not For Repair</option>
 						<option value='For Repair'>For Repair</option>
 					</select>
 				</td>
 				<td>
 					<?php if($isMotherboard){ ?>
 						<a style='color: #5D4037;' class='btn btn-sm btn-warning' href="report_peripherals.php?peripheral_id=<?php echo $newMotherboard['peripheral_id']?>" target='_blank'><i class="fas fa-bug"></i> Report</a>
 					<?php } ?> 					
 				</td>
			</tr>
			<!-- End Motherboard -->
			<!-- Start Graphics Card -->
			<?php
				$getGPU=$mysqli->query("SELECT * FROM peripherals WHERE unit_id=$PcId AND peripheral_type='GPU'") or die ($mysqli->error());
				$newGPU = $getGPU->fetch_array();
				if(mysqli_num_rows($getGPU)==0){
					$isGPU = false;
				}
				else{
					$isGPU = true;
				}
			?>
			<tr>
				<td>Graphics Card (GPU)</td>
				<td><input class="form-control" type="text" name="gpu-brand" value="<?php if($isGPU){echo $newGPU['peripheral_brand'];}else{/*Do nothing*/}?>"></td>
 				<td><input class="form-control" type="text" name="gpu-description" value="<?php if($isGPU){echo $newGPU['peripheral_description'];}else{/*Do nothing*/}?>"></td>
 				<td><input class="form-control" type="text" name="gpu-serialno" value="<?php if($isGPU){echo $newGPU['peripheral_serial_no'];}else{/*Do nothing*/}?>"></td>
 				<td><input class="form-control" type="date" name="gpu-datepurchase" value="<?php if($isGPU){echo $newGPU['peripheral_date_purchased'];}else{/*Do nothing*/}?>" required></td>
 				<td><input class="form-control" type="number" min="0" name="gpu-amount" value="<?php if($isGPU){echo $newGPU['peripheral_amount'];}else{echo '1';/*Do nothing*/}?>"></td>
 				<td><input class="form-control" type="date" name="gpu-dateissue" value="<?php if($isGPU){echo $newGPU['peripheral_date_issued'];}else{/*Do nothing*/}?>" required></td>
 				<td><input style="display: none;" class="form-control" type="text" value="<?php if($isGPU){echo $newGPU['remarks'];}else{/*Do nothing*/}?>">
 					<select class='form-control' name="gpu-remarks" disabled>
 						<option class='text-danger' value='<?php if($isGPU){echo $newGPU['remarks'];}else{echo 'Not For Repair';} ?>' selected><?php if($isGPU){echo $newGPU['remarks'];}else{echo 'Not For Repair';} ?></option>
 						<option value='Not For Repair'>Not For Repair</option>
 						<option value='For Repair'>For Repair</option>
 					</select>
 				</td>
 				<td>
 					<?php if($isGPU){ ?>
 						<a style='color: #5D4037;' class='btn btn-sm btn-warning' href="report_peripherals.php?peripheral_id=<?php echo $newGPU['peripheral_id']?>" target='_blank'><i class="fas fa-bug"></i> Report</a>
 					<?php } ?> 					
 				</td>
			</tr>
			<!-- End Motherboard -->
			<!-- Start RAM -->
			<?php
				$getRAM=$mysqli->query("SELECT * FROM peripherals WHERE unit_id=$PcId AND peripheral_type='RAM'") or die ($mysqli->error());
				$newRAM = $getRAM->fetch_array();
				if(mysqli_num_rows($getRAM)==0){
					$isRAM = false;
				}
				else{
					$isRAM = true;
				}
			?>
			<tr>
				<td>RAM</td>
				<td><input class="form-control" type="text" name="ram-brand" value="<?php if($isRAM){echo $newRAM['peripheral_brand'];}else{/*Do nothing*/}?>"></td>
 				<td><input class="form-control" type="text" name="ram-description" value="<?php if($isRAM){echo $newRAM['peripheral_description'];}else{/*Do nothing*/}?>"></td>
 				<td><input class="form-control" type="text" name="ram-serialno" value="<?php if($isRAM){echo $newRAM['peripheral_serial_no'];}else{/*Do nothing*/}?>"></td>
 				<td><input class="form-control" type="date" name="ram-datepurchase" value="<?php if($isRAM){echo $newRAM['peripheral_date_purchased'];}else{/*Do nothing*/}?>" required></td>
 				<td><input class="form-control" type="number" min="0" name="ram-amount" value="<?php if($isRAM){echo $newRAM['peripheral_amount'];}else{echo '1';/*Do nothing*/}?>"></td>
 				<td><input class="form-control" type="date" name="ram-dateissue" value="<?php if($isRAM){echo $newRAM['peripheral_date_issued'];}else{/*Do nothing*/}?>" required></td>
 				<td><input style="display: none;" class="form-control" type="text" value="<?php if($isRAM){echo $newRAM['remarks'];}else{/*Do nothing*/}?>">
 					<select class='form-control' name="ram-remarks" disabled>
 						<option class='text-danger' value='<?php if($isRAM){echo $newRAM['remarks'];}else{echo 'Not For Repair';} ?>' selected><?php if($isRAM){echo $newRAM['remarks'];}else{echo 'Not For Repair';} ?></option>
 						<option value='Not For Repair'>Not For Repair</option>
 						<option value='For Repair'>For Repair</option>
 					</select>
 				</td>
 				<td>
 					<?php if($isRAM){ ?>
 						<a style='color: #5D4037;' class='btn btn-sm btn-warning' href="report_peripherals.php?peripheral_id=<?php echo $newRAM['peripheral_id']?>" target='_blank'><i class="fas fa-bug"></i> Report</a>
 					<?php } ?> 	 					
 				</td>
			</tr>
			<!-- End RAM -->
			<!-- Start HDD -->
			<?php
				$getHDD=$mysqli->query("SELECT * FROM peripherals WHERE unit_id=$PcId AND peripheral_type='HDD'") or die ($mysqli->error());
				$newHDD = $getHDD->fetch_array();
				if(mysqli_num_rows($getHDD)==0){
					$isHDD = false;
				}
				else{
					$isHDD = true;
				}
			?>
			<tr>
				<td>Hard Disk Drive</td>
				<td><input class="form-control" type="text" name="hdd-brand" value="<?php if($isHDD){echo $newHDD['peripheral_brand'];}else{/*Do nothing*/}?>"></td>
 				<td><input class="form-control" type="text" name="hdd-description" value="<?php if($isHDD){echo $newHDD['peripheral_description'];}else{/*Do nothing*/}?>"></td>
 				<td><input class="form-control" type="text" name="hdd-serialno"  value="<?php if($isHDD){echo $newHDD['peripheral_serial_no'];}else{/*Do nothing*/}?>"></td>
 				<td><input class="form-control" type="date" name="hdd-datepurchase" value="<?php if($isHDD){echo $newHDD['peripheral_date_purchased'];}else{/*Do nothing*/}?>" required></td>
 				<td><input class="form-control" type="number" min="0" name="hdd-amount" value="<?php if($isHDD){echo $newHDD['peripheral_amount'];}else{echo '1';/*Do nothing*/}?>"></td>
 				<td><input class="form-control" type="date" name="hdd-dateissue" value="<?php if($isHDD){echo $newHDD['peripheral_date_issued'];}else{/*Do nothing*/}?>" required></td>
 				<td><input style="display: none;" class="form-control" type="text" value="<?php if($isHDD){echo $newHDD['remarks'];}else{/*Do nothing*/}?>">	 					
 					<select class='form-control' name="hdd-remarks" disabled>
 						<option class='text-danger' value='<?php if($isHDD){echo $newHDD['remarks'];}else{echo 'Not For Repair';} ?>' selected><?php if($isHDD){echo $newHDD['remarks'];}else{echo 'Not For Repair';} ?></option>
 						<option value='Not For Repair'>Not For Repair</option>
 						<option value='For Repair'>For Repair</option>
 					</select>
 				</td>
 				<td>
 					<?php if($isHDD){ ?>
 						<a style='color: #5D4037;' class='btn btn-sm btn-warning' href="report_peripherals.php?peripheral_id=<?php echo $newHDD['peripheral_id']?>" target='_blank'><i class="fas fa-bug"></i> Report</a>
 					<?php } ?>  					
 				</td>
			</tr>
			<!-- End RAM -->
	</table><?php if($isUpdate){
		echo "<button type='submit' class='btn btn-primary btn-sm' name='update'><i class='far fa-save'></i> Update Components</button>";
		}
		else{
			echo "<button type='submit' class='btn btn-primary btn-sm' name='save'><i class='far fa-save'></i> Save Components</button>";
		}
	?>
	
	</form>
		<?php	
	}
	?>

	</div>
	
	<br/>
	<!-- End PC Equipment Views Here-->
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
	/* Hide when not in use */
	.second-heading{
		display: none;
	}
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
	td:nth-of-type(4):before { content: "Serial Number:"; font-weight: bold; }
	td:nth-of-type(5):before { content: "Date Purchased:"; font-weight: bold; }
	td:nth-of-type(6):before { content: "Amount:"; font-weight: bold; }
	td:nth-of-type(7):before { content: "Date Issued:"; font-weight: bold; }
	td:nth-of-type(8):before { content: "Remarks:"; font-weight: bold; }
}
</style>
<!-- EOF -->