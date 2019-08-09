<?php
	/*
	session_start();
	$host = 'localhost';
	$username = 'root';
	$password = '';
	$database = 'ppfo_inventory';

	$mysqli = new mysqli($host,$username,$password,$database) or die(mysql_error($mysqli));
	*/
	include 'dbh.php';
	$update_pc_unit = false;
	//$building_name = '';
	//$building_description='';
	/*Add Computers*/
	if(isset($_POST['save'])){
		$unit_no = $_POST['unit_no'];
		$date = date_default_timezone_set('Asia/Manila');
		$date = date('Y-m-d H:i:s');
		$lab_id = $_POST['lab_id'];
		$building_id = $_POST['building_id'];
		$logs = "Added ".$unit_no." total number of PC(s) in Lab ID: ".$lab_id." from Building ID: ".$building_id;
		
		//Insert Logs
		$mysqli->query("INSERT INTO context_logs (username, description, date_added,type) VALUES('$current_username','$logs','$date','addition')");

		$getLastPCAdded = $mysqli->query("SELECT * FROM unit_pc WHERE lab_id=$lab_id");
		if(mysqli_num_rows($getLastPCAdded)==0){
			$unit_last = $unit_no;
			$unit_no = 0;
			while($unit_no<$unit_last){
				$unit_no++;
				$unit_name = "PC".$unit_no;
				$mysqli->query("INSERT INTO unit_pc (unit_no,unit_name,lab_id,building_id,date_added,status) VALUES('$unit_no','$unit_name','$lab_id','$building_id','$date','working')") or die($mysqli->error());;
			}
		}
		else{ 
			while($newGetLastPCAdded=$getLastPCAdded->fetch_assoc()){
				$unit_last = $newGetLastPCAdded['unit_no'];
			}
			$tempUnitNo = $unit_no;
			$unit_no = $unit_last;
			$unit_last = $unit_last+$tempUnitNo;

			while($unit_no<$unit_last){
				$unit_no++;
				$unit_name = "PC".$unit_no;
				$mysqli->query("INSERT INTO unit_pc (unit_no,unit_name,lab_id,building_id,date_added,status) VALUES('$unit_no','$unit_name','$lab_id','$building_id','$date','working')") or die($mysqli->error());
			}
		}

		/*
		$mysqli->query("INSERT INTO unit_pc (unit_name,lab_code,building_code) VALUES('$unit_name','$lab_code','$building_code')");
		*/

		$_SESSION['message'] = $tempUnitNo." PC(s) saved successfully!";
		$_SESSION['msg_type'] = "success";

		header("location: unit_pc.php");
	}

	if(isset($_GET['delete'])){
		$unit_id = $_GET['delete'];
		$getURI = $_SESSION['getURI'];
		$mysqli->query("DELETE FROM unit_pc WHERE unit_id=$unit_id") or die($mysqli->error());

		$_SESSION['message'] = "Record has been deleted!";
		$_SESSION['msg_type'] = "danger";
		//settype($getURI, 'string')		
		header('location:'.$getURI);
	}

	if(isset($_GET['edit'])){
		$update_building = true;
		$building_id = $_GET['edit'];
		$result = $mysqli->query("SELECT * FROM building WHERE building_id=$building_id") or die ($mysqli->error());
		//if(count($result)==1){
		$row = $result->fetch_array();
		$building_name = $row['building_name'];
		$building_description = $row['building_description'];
			//$building_id = $row['building_id'];
		//}
	}

	if(isset($_POST['update'])){
		$building_id = $_POST['building_id'];
		$building_name = strtoupper($_POST['building_name']);
		$building_description = $_POST['building_description'];
		$building_name_strip = str_replace(' ', '', $building_name);
		$building_code = substr($building_name_strip, 0, 5).'00'.$building_id;
		$mysqli->query("UPDATE building SET building_code='$building_code',building_name='$building_name', building_description='$building_description' WHERE building_id='$building_id'") or die ($mysqli->error());

		$_SESSION['message'] = $building_name." information has been changed / updated!";
		$_SESSION['msg_type'] = "warning";

		header("location: building.php");
	}
?>