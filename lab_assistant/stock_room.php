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
	<title>Stock Room</title>

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
	<?php if(isset($_SESSION['message'])): ?>
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

	<form action="process_stock_room.php" method="POST">
		
		<h5 style="color: blue;">Add new stock item(s)</h5>
		<?php if($update_stock_room==true){
		?>
		<input style="visibility: hidden;" type="text" name="id" value="<?php echo $record_id; ?>">
		<input style="visibility: hidden;" type="text" name="batch_id" value="<?php echo $batch_id; ?>">
		<input style="visibility: hidden;" type="text" name="item" value="<?php echo $item; ?>">
		<?php	
			}
		?>
		<table class="table">
			<tr>
				<td>
					<select name='item_type' class="form-control" required <?php if($update_stock_room==true){echo 'disabled';} ?>>		
						<?php if($update_stock_room==true){
							echo "<option disabled selected>".$item."</option>";
						}
						else{
							echo "<option disabled selected>Item Type</option>";
						}
						?>
						<option value="Monitor">Monitor</option>
						<option value="Keyboard">Keyboard</option>
						<option value="Mouse">Mouse</option>
						<option value="AVR">AVR</option>
						<option value="Headset">Headset</option>
						<option value="CPU">CPU</option>
						<option value="Motherboard">Motherboard</option>
						<option value="GPU">GPU</option>
						<option value="RAM">RAM</option>
						<option value="HDD">HDD</option>
					</select>
				</td>
				<td>
					<textarea name="description" class="form-control" placeholder="Description"><?php
					echo $description;
					?></textarea>
				</td>
				<td>
					Total Request
				</td>
				<td style="width: 10%;">
					<input type="number" name="request_item" class="form-control" min="0" value="0" max="<?php echo $total_qty;?>" value="0" <?php if($update_stock_room==false){echo 'readonly';} ?>>
				</td>
				<td>
					Total Purchased
				</td>
				<td style="width: 10%;">
					<input type="number" name='purchased_item' class="form-control" placeholder="0" min="0" required>
				</td>
				<td>
					In Stock
				</td>
				<td style="width: 10%;">
					<input type="text" name="total_qty" class="form-control" readonly value='<?php echo $total_qty ?>'>
				</td>
			</tr>
			<tr>
				<td colspan="8">
					<center>
						<?php if($update_stock_room==false){ ?>
						<button type="submit" name="save" class="btn btn-sm btn-primary"><i class="far fa-save"></i> Save Item(s)</button>
						<?php }
						else {
						 ?>
						 <button type="submit" name="update" class="btn btn-sm btn-primary"><i class="far fa-save"></i> Update Item(s)</button>
						<?php } ?>
						<a href="stock_room.php" class="btn btn-danger btn-sm" href=""><i class="fas as fa-sync"></i> Clear Fields</a>
					</center>
				</td>
			</tr>
		</table>
	</form>
	</div>
	<br/>
	<h5 style="color: blue;">List of Equipments in Stock Room</h5>
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
		$getStockRooms = mysqli_query($mysqli, "SELECT * FROM stock_room WHERE remarks='new'");
	}
	else{
		$getStockRooms = mysqli_query($mysqli, "SELECT * FROM stock_room WHERE item='$current_type' AND remarks='new'");
	}
	?>
	<table class="table" id="dataTable" width="100%" cellspacing="0">
		<thead>
		<tr>
			<th>ID</th>
			<th>Date</th>
			<th>Item</th>
			<th>Description</th>
			<th>Total Stock</th>
			<th>Actions</th>
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
			<td><?php echo date_format($date, 'F j, Y'); ?></td>
			<td><?php echo $newStockRooms['item']; ?></td>
			<td><?php echo $newStockRooms['description']; ?></td>
			<td><?php echo number_format($newStockRooms['total_qty']); ?></td>
			<td>
			<a class="btn btn-success btn-secondary btn-sm" href="<?php echo $fileName.'?edit='.$newStockRooms['id']; ?>"><i class="far fa-edit"></i> Edit</a>
			<button class="btn btn-danger btn-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="far fa-trash-alt"></i> Delete
					</button><div class="dropdown-menu" aria-labelledby="dropdownMenuButton btn-sm">(WARNING) You sure you want to delete?<br/> You cannot undo the changes<br/><br/>
						<a href="stock_room.php?delete=<?php echo $newStockRooms['id'] ?>" class='btn btn-danger btn-sm'><i class="far fa-trash-alt"></i> Confirm Delete</a>
						<a href="#" class='btn btn-success btn-sm'><i class="far fa-window-close"></i> Cancel</a> 
			</div></td>
		</tr>
			<?php	
				}}
			?>
	</table>
		<center><a href='view_stock_room.php' class='btn btn-info btn-sm' href="#">View All Stock Room Logs</a></center>
	</div>

<div class="separator" style="height: 200px;">
	
</div>
	<!-- End Here-->
	<?php
	include('footer.php');
?>