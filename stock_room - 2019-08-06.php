<?php
$currentItem = 'stock_room';
include('sidebar.php');
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$getURI = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$_SESSION['getURI'] = $getURI;
include('process_misc_things.php');
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
			//echo "<h5 style='color: blue;'>Stock Room</h5>";
		}
	?>
	<!-- Add Building Here -->
	<div class="row justify-content-center">
	<form action="process_misc_things.php" method="POST">
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
		$getStockRooms = mysqli_query($mysqli, "SELECT * FROM peripherals WHERE unit_id='StockRoom'");
	}
	else{
		$getStockRooms = mysqli_query($mysqli, "SELECT * FROM peripherals WHERE unit_id='StockRoom' AND peripheral_type='$current_type'");
	}
	?>
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
				echo "<div class='alert alert-warning'>No ".$current_type." currently stored in stock room</div>";
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
	//include('footer.php');
?>
<footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; SYSTEMS PLUS COLLEGE FOUNDATION - ICTDU 2019</span>
          </div>
        </div>
</footer>

</div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

   <!-- Logout Modal-->
 <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary btn-alert btn-sm" href="logout.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>

</body>

</html>
