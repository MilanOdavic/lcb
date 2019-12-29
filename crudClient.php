<html>

<head>
	<?php
		include 'dbh.php';
		include 'crudServer.php';
	?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function(){
			 $('#ajax_click_READ').on('click', function(event){
				 $.ajax({
					url:"ajax_call.php",
					method:"POST",
					data:{name_func: 'read_user'},
					success:function(response_json)
					{
						response_array = JSON.parse(response_json);
						alert(response_array[0]['name']);
					}
				 });
			 });

			 $('#ajax_click_UPDATE').on('click', function(event){
				 $.ajax({
					url:"ajax_call.php",
					method:"POST",
					data:{name_func: 'update_user', name: 'xxx2', id: '3'},
					success:function(response_json)
					{
						alert('uspesno update-ovan');
					}
				 });
			 });
		});
	</script>
</head>

<body>
	<div>
		<h2> 1. CRUD OPERACIJE na klijentskoj strani </h2>
		<?php
			$crud = new CrudServer();

			// 1. CREATE
			//$crud->create_func('kaca2','kaca','kaca',2); // <<<< poziva server



			// 2. READ
			$data_from_database = $crud->read_func(); // <<<< poziva server
			foreach($data_from_database as $row) { // ispis - samo za select
				echo $row['name'] . ', <br/>';
			}



			// 3. UPDATE
			//$name = 'novoIme';
			//$id = 3;
			//$crud->update_func($name, $id); // <<<< poziva server



			// 4. DELETE
			//$id = '7';
			//$crud->delete_func($id); // <<<< poziva server

		?>
	</div>
	<br/><br/><br/><br/><br/><br/><br/>







	<div>
		<h2> 2. AJAX </h2>
		<a href='javascript:void(0)' id='ajax_click_READ'> ajax click READ </a> <br/>
		<a href='javascript:void(0)' id='ajax_click_UPDATE'> ajax click UPDATE </a>
	</div>
	<br/><br/><br/><br/><br/><br/><br/>








	<div>
		<h2> 3. FORM </h2>
		<form action='crudClient.php' method='POST' >
			name user: <input type='text' name='tbName' /> <br/>
			id user: <input type='text' name='tbId' /> <br/>
			<input type='hidden' name='name_func' value='createArticle'>
			<input type='submit' name='btnUpdate' value='UPDATE'/>
		</form>

		<?php
			if(isset($_POST['name_func']) && $_POST['name_func'] == 'createArticle') {
				$crud = new CrudServer();
				$name = $_POST['tbName'];
				$id = $_POST['tbId'];
				$crud->update_func($name, $id); // <<<< poziva server
			}
		?>
	</div>




</body>
</html>
