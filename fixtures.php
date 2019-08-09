<?php
require_once 'process_fixture.php';
$currentItem = 'equipments';
include('sidebar.php');
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$getURI = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$_SESSION['getURI'] = $getURI;
//$getURI = $_SERVER['QUERY_STRING'];
//echo $query; // Outputs: Query String
?>
<!DOCTYPE html>
<html>
<head>
	<title>Add / Edit Fixtures</title>
	<script src="libs/js/bootstrap.min.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
<?php
	include('topbar.php');
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

	$getBuilding = $mysqli->query('SELECT * FROM building ORDER BY building_name') or die ($mysqli->error);
	//print_r($getBuilding);
	?>

	
	<!-- Add Fixtures Here -->
	<div class="row justify-content-center">
		<form action="process_fixture.php" method="POST">
		<table class='table' style="width: 100% !important;">
			<tr>
				<th>Building</th>
				<th>Room / Laboratory</th>
				<th>Fixture Type</th>
				<th>Qty</th>
				<th>Actions</th>
			</tr>
			<tr>
			<td>
				<select class="form-control" onchange="location = this.value;">
					<option disabled selected>Select Building</option>
					<?php
					$building_id = 0;
					if(isset($_GET['building_id'])){
						$building_id = $_GET['building_id'];
					}
					while($newBuilding=$getBuilding->fetch_assoc()){ ?>
					<option value="<?php echo 'fixtures.php?building_id='. $newBuilding['building_id']; ?>" <?php if($building_id==$newBuilding['building_id']){echo 'selected';} ?> ><?php echo $newBuilding['building_name']; ?></option>
					<?php } ?>
				</select>
				<?php if(isset($_GET['building_id'])){
					$building_id = $_GET['building_id'];
					echo "<input name='building' style='visibility: hidden;' type='text' value=".$building_id.">";
				} ?>				
			</td>
			<td>
				<select name="laboratory" class="form-control" required>
					<?php
					if(isset($_GET['building_id'])){
						$building_id = $_GET['building_id'];
						$getLaboratory = $mysqli->query("SELECT * FROM laboratory WHERE building_id='$building_id'") or die ($mysqli->error);
						if(mysqli_num_rows($getLaboratory)==0){
							echo "<option selected disabled>WARNING! Please add a lab or room to this building first</option>";
						}
						while($newLaboratory=$getLaboratory->fetch_assoc()){
					?>
					<option value="<?php echo $newLaboratory['lab_id']; ?>"><?php echo $newLaboratory['lab_name']; ?></option>	
					<?php
						}
					}
					?>
					<option disabled>Select Room / Laboratory</option>					
				</select>
			</td>
			<td>
				<select name="type" class="form-control">
					<option value="airconditioner">Air Conditioner</option>
					<option value="officeTable">Office Table</option>
					<option value="officeChair">Office Chair</option>
					<option disabled>Select Type</option>
				</select>
			</td>
			<td>
				<input type="number" name="qty" class="form-control" min='1' max='10' placeholder="0" required>
			</td>
			<td>
				<button class="btn btn-primary btn-sm" type="submit" name="save"><i class="far fa-save" ></i> Save</button>
				<a href="fixtures.php" id="refresh" class='btn btn-danger btn-sm'><i class="fas as fa-sync"></i> Clear/Refresh</a>
			</td>			
			</tr>	
		</table>
		</form>

		<!-- Show Added Fixtures -->
		<table class="table" id="dataTable" width="100%" cellspacing="0">
			<thead>
				<th>Type</th>
				<th>Batch ID</th>
				<th>Serial No</th>
				<th>Building</th>
				<th>Room / Laboratory</th>
				<th>Remarks</th>
				<th>Actions</th>
			</thead>
			<tbody>
				<?php $getFixtures = mysqli_query($mysqli, "SELECT fe.id, fe.date_added, fe.serial_no, fe.type, fe.batch_code, fe.building_id, fe.lab_id, fe.remarks, bg.building_id, bg.building_name, ly.lab_id, ly.lab_name
			FROM fixture fe
			JOIN building bg
			ON bg.building_id = fe.building_id
			JOIN laboratory ly
			ON ly.lab_id = fe.lab_id
			ORDER BY fe.date_added DESC
			"); 
			while($newFixtures=$getFixtures->fetch_assoc()){
			?>
				<tr>
					<td><?php echo strtoupper($newFixtures['type']); ?></td>
					<td><?php echo $newFixtures['batch_code']; ?></td>
					<td><?php echo $newFixtures['serial_no']; ?></td>
					<td><?php echo $newFixtures['building_name']; ?></td>
					<td><?php echo $newFixtures['lab_name']; ?></td>
					<td><?php echo $newFixtures['remarks']; ?></td>
					<td><a class="btn btn-info btn-sm" href="#"><i class="far fa-edit"></i> Edit</a></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>

	<br/>
	<br/>
<script type="text/javascript">
	$('#example').dataTable( {
  "pageLength": 50
} );
</script>
	<?php
	include('footer.php');
?>