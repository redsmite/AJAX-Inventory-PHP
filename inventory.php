<?php
	require'connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
 	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
	<title>Inventory</title>
</head>
<body>
	<div class="inventory-page">
		<h1>Add Inventory</h1>
		<form id="inventory-form">
			<h3>Add New Inventory</h3>
			<p>Inventory Name</p>
			<input type="text" id="inventory-name" required placeholder="enter name...">
			<p>Inventory Type</p>
			<input type="text" id="inventory-type" required placeholder="enter type...">
			<p>Quantity</p>
			<input type="number" min="0" id="quantity" required placeholder="enter quantity...">
			<p>Status</p>
			<select required id="status">
				<option value="1">Active</option>
				<option value="2">Disable</option>
			</select>
			<br>
			<input type="submit" value="Submit">
		</form>

		<h1>Inventory</h1>
		<table>
			<tr>
				<td>Name</td>
				<td>Type</td>
				<td>Quantity</td>
				<td>Status</td>
				<td>Edit</td>
			</tr>
<?php
	$sql = "SELECT * FROM inventory";
	$result = $conn->query($sql);
	while($row = $result->fetch_object()){
		$id = $row->inventory_id;
		$name = $row->inventory_name;
		$type = $row->inventory_type;
		$quantity = $row->quantity;
		$status = $row->status;

		if($status==1){
			$status = 'Active';
		}else{
			$status = 'Disable';
		}

		echo '<tr>';
		echo '<td>'.$name.'</td>';
		echo '<td>'.$type.'</td>';
		echo '<td>'.$quantity.'</td>';
		echo '<td>'.$status.'</td>';
		echo '<td><a onclick="editModal('.$id.')">Edit</a></td>';
		echo '<tr>';
	}
?>
		</table>
	</div>

<div id="edit-modal">
	<p id="close-modal" onclick="closeModal()">X Close</p>
	<div id="modal-content"></div>
</div>


	<script>
		function addInventory(){
			var form = document.getElementById('inventory-form');
			form.addEventListener('submit',add);

			function add(e){
				e.preventDefault();

				var myRequest = new XMLHttpRequest();
				var url = 'inventoryprocess.php';

				//form data variables
				var name = document.getElementById('inventory-name').value;
				var type = document.getElementById('inventory-type').value;
				var quantity = document.getElementById('quantity').value;
				var status = document.getElementById('status').value;
				
				var formData = "add="+name+"&type="+type+"&quantity="+quantity+"&status="+status;
		
				
				myRequest.open('POST', url ,true);
				myRequest.setRequestHeader('Content-type','application/x-www-form-urlencoded');

				myRequest.onload = function(){
					var response= this.responseText;
					alert(response);
					form.reset();
				}
				myRequest.send(formData);	
			}
		}

		function editModal(clicked){
			var modal = document.getElementById('edit-modal');

			modal.style.display = "block";
			var myRequest = new XMLHttpRequest();
			var url = 'inventoryprocess.php';
			
			var formData = "edit="+clicked;
	
			
			myRequest.open('POST', url ,true);
			myRequest.setRequestHeader('Content-type','application/x-www-form-urlencoded');

			myRequest.onload = function(){
				var response= this.responseText;
				document.getElementById('modal-content').innerHTML = response;
			}
			myRequest.send(formData);
		}

		function closeModal(){
			var modal = document.getElementById('edit-modal');

			modal.style.display = "none";
		}

		function editInventory(){
			var form = document.getElementById('edit-inventory-form');

			form.addEventListener('submit',edit);

			function edit(e){
				e.preventDefault();

				var myRequest = new XMLHttpRequest();
				var url = 'inventoryprocess.php';

				//form data variables
				var id = document.getElementById('edit-id').value;
				var name = document.getElementById('edit-name').value;
				var type = document.getElementById('edit-type').value;
				var quantity = document.getElementById('edit-quantity').value;
				var status = document.getElementById('edit-status').value;
				
				var formData = "editAjax="+name+"&edittype="+type+"&editquantity="+quantity+"&editstatus="+status+"&editid="+id;
		
				
				myRequest.open('POST', url ,true);
				myRequest.setRequestHeader('Content-type','application/x-www-form-urlencoded');

				myRequest.onload = function(){
					var response= this.responseText;
					alert(response);				
					location.reload();
				}
				myRequest.send(formData);	
			}
		}

		addInventory();
	</script>
</body>
</html>