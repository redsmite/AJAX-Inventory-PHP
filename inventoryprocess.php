<?php
	require'connection.php';

	if(isset($_POST['add'])){
		$name = $conn->real_escape_string($_POST['add']);
		$type = $conn->real_escape_string($_POST['type']);
		$quantity = $_POST['quantity'];
		$status = $_POST['status'];

		if ($quantity < 0){
			echo 'Quantity can\'t be negative';
		}else{
			$sql = "INSERT INTO inventory (inventory_name,inventory_type,quantity,status) VALUES ('$name','$type',$quantity,$status)";
			$result = $conn->query($sql);
			echo $name.' is added to the database';
		}
	}

	if(isset($_POST['edit'])){
		$id = $_POST['edit'];

		$sql = "SELECT * FROM inventory WHERE inventory_id = $id";
		$result = $conn->query($sql);
		$fetch = $result->fetch_object();

		$name = $fetch->inventory_name;
		$type = $fetch->inventory_type;
		$quantity = $fetch->quantity;
		$status = $fetch->status;

		echo '<form id="edit-inventory-form">
			<h3>Edit Inventory</h3>
			<input type="hidden" id="edit-id" value="'.$id.'">
			<p>Inventory Name</p>
			<input type="text" id="edit-name" value="'.$name.'" required placeholder="enter name...">
			<p>Inventory Type</p>
			<input type="text" id="edit-type" value="'.$type.'" required placeholder="enter type...">
			<p>Quantity</p>
			<input type="number" min="0" id="edit-quantity" value="'.$quantity.'" required placeholder="enter quantity...">
			<p>Status</p>
			<select required id="edit-status">';
			if($status == 1){
				echo'<option value="1" selected>Active</option>
				<option value="2">Disable</option>';
			}else{
				echo'<option value="1">Active</option>
				<option value="2" selected>Disable</option>';
			}
			echo'</select>
			<br>
			<input type="submit" onclick="editInventory()" value="Submit">
		</form>';
	}

	if(isset($_POST['editAjax'])){
		$id = $_POST['editid'];
		$name = $conn->real_escape_string($_POST['editAjax']);
		$type = $conn->real_escape_string($_POST['edittype']);
		$quantity = $_POST['editquantity'];
		$status = $_POST['editstatus'];

		if ($quantity < 0){
			echo 'Quantity can\'t be negative';
		}else{
			$sql = "UPDATE inventory SET inventory_name='$name',inventory_type='$type',quantity='$quantity',status=$status WHERE inventory_id = $id";
			$result = $conn->query($sql);
			echo 'This inventory is successfully changed';
		}
	}
?>