<?php

	include 'dbh.php';
	$update_stock_room = false;
	$description = "";
	$date_added = date_default_timezone_set('Asia/Manila');
	$date_added = date('Y-m-d H:i:s');
	
	$batchID = date_default_timezone_set('Asia/Manila');
	$batchID = date('ymdHis');
	$vowels = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", " ");
	$total_qty = 0;
	if(isset($_POST['save'])){
		$item=$_POST['item_type'];
		$description=$_POST['description'];
		$total_qty=$_POST['total_qty'];
		$purchased_item=$_POST['purchased_item'];
		$request_item=$_POST['request_item'];
		
		$batchID = strtoupper(str_replace($vowels, "", $item).$batchID);  

		$remarks = 'new';

		$beg_inventory  = 0;
		$total_qty = $purchased_item;
		//$ending_intventory = $ending_intventory - $purchased_item;

		$mysqli->query("INSERT INTO stock_room (batch_id, date_added, item,description,beg_inventory, request_item, purchased_item, total_qty, remarks) VALUES('$batchID', '$date_added', '$item', '$description', '$beg_inventory', '$request_item', '$purchased_item', '$total_qty','$remarks')") or die($mysqli->error());

		$_SESSION['message'] = "Item(s) has been saved!";
		$_SESSION['msg_type'] = "success";

		header("location: stock_room.php");
	}

	if(isset($_POST['update'])){
		$record_id = $_POST['id'];
		$batch_id = $_POST['batch_id'];
		$item = $_POST['item'];
		$description=$_POST['description'];
		$total_qty=$_POST['total_qty'];
		$purchased_item=$_POST['purchased_item'];
		$request_item=$_POST['request_item'];

		$beg_inventory  = $total_qty;
		$total_qty = $total_qty+$purchased_item;
		$total_qty = $total_qty-$request_item;
		
		$mysqli->query("UPDATE stock_room SET remarks='old' WHERE id='$record_id'") or die($mysqli->error());

		$remarks = 'new';
		$mysqli->query("INSERT INTO stock_room (batch_id,date_added, item,description,beg_inventory, request_item, purchased_item, total_qty, remarks) VALUES('$batch_id','$date_added', '$item', '$description', '$beg_inventory', '$request_item', '$purchased_item', '$total_qty','$remarks')") or die($mysqli->error());

		$_SESSION['message'] = "Item(s) has been saved!";
		$_SESSION['msg_type'] = "success";

		header("location: stock_room.php");
	}	


	if(isset($_GET['delete'])){
		$record_id = $_GET['delete'];
		$mysqli->query("DELETE FROM stock_room WHERE id=$record_id") or die($mysqli->error());

		$_SESSION['message'] = "Record has been deleted!";
		$_SESSION['msg_type'] = "danger";
		header("location: stock_room.php");
	}

	if(isset($_GET['edit'])){
		$update_stock_room = true;
		$record_id = $_GET['edit'];
		$getStockRoom = $mysqli->query("SELECT * FROM stock_room WHERE id=$record_id") or die ($mysqli->error());

		$newStockRoom = $getStockRoom->fetch_array();
		$record_id = $newStockRoom['id'];
		$item = $newStockRoom['item'];
		$total_qty = $newStockRoom['total_qty'];
		$batch_id = $newStockRoom['batch_id'];
		$description = $newStockRoom['description'];
	}
?>