<?php
session_start();
?>
<html>

<head>
	<?php
		include 'dbh.php';
		include 'crudServer.php';
	?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

	<script type="text/javascript">



		$(document).ready(function(){


			$('#ajax_click_DELETE_article').on('click', function(event){

				if (!confirm("pritisni OK ako si siguran")) {return false;}

				var article_id = $("#article_id5").val();

				$.ajax({
				 url:"ajax_call.php",
				 method:"POST",
				 data:{name_func: 'delete_article', article_id: article_id},
				 success:function(response_json)
				 {
					 alert('uspesno obrisan');
				 }
				});
			});



			$('#ajax_click_DELETE_categorie').on('click', function(event){

				if (!confirm("pritisni OK ako si siguran")) {return false;}

				var categorie_id = $("#categorie_id").val();

				$.ajax({
				 url:"ajax_call.php",
				 method:"POST",
				 data:{name_func: 'delete_categorie', categorie_id: categorie_id},
				 success:function(response_json)
				 {
					 alert('uspesno obrisan');
				 }
				});
			});



		});
	</script>
</head>

<body>
















	<h2> 1. Registration</h2>
	<form action='index.php' method='POST' >
		name: <input type='text' name='tbName' /> <br/>
		pass: <input type='text' name='tbPass' /> <br/>
		<input type='hidden' name='name_func' value='registration'>
		<input type='submit' name='btnCreateAccount' value='Create account'/>
	</form>

	<?php
		if(isset($_POST['name_func']) && $_POST['name_func'] == 'registration') {
			$crud = new CrudServer();
			$name = $_POST['tbName'];
			$pass = $_POST['tbPass'];
			$crud->registration($name, $pass);
		}
	?>



















	<br/><br/><hr/><br><br/>


	<h2> 2. Login</h2>
	<form action='index.php' method='POST' >
		name: <input type='text' name='tbName' /> <br/>
		pass: <input type='text' name='tbPass' /> <br/>
		<input type='hidden' name='name_func' value='login'>
		<input type='submit' name='btnLogin' value='Login'/>
	</form>

	<?php
		if(isset($_POST['name_func']) && $_POST['name_func'] == 'login') {
			$crud = new CrudServer();
			$name = $_POST['tbName'];
			$pass = $_POST['tbPass'];
			$user = $crud->login($name, $pass);
			if(count($user) == 0) {
				echo 'neuspesno logovanje';
			} else {
					$_SESSION['user_id'] = $user[0]['id'];
					echo 'uspesno logovanje';
			}
		}
	?>

	<?php
	if(isset($_SESSION['user_id'])) {
		echo 'ULOGOVAN SI';
	}
	else {
		echo 'NISI ULOGOVAN';
	}
	//unset($_SESSION['user_id']);
	?>




















	<br/><br/><hr/><br><br/>


	<h2> 3. Create Article </h2>
	<form action='index.php' method='POST' >
		categories_id: <input type='text' name='tbCategories_id3' /> <br/>
		text: <input type='text' name='tbText3' /> <br/>
		title: <input type='text' name='tbTitle3' /> <br/>
		<input type='hidden' name='name_func' value='createArticle'>
		<input type='submit' name='btnCreateArticle' value='Create article'/>
	</form>

	<?php
	if(isset($_POST['name_func']) && $_POST['name_func'] == 'createArticle') {

				if(isset($_SESSION['user_id'])){
					$crud = new CrudServer();
					$categories_id = $_POST['tbCategories_id3'];
					$text = $_POST['tbText3'];
					$title = $_POST['tbTitle3'];
					$users_id = $_SESSION['user_id'];
					$crud->createArticle($categories_id, $text, $title, $users_id);
				}
				else {
					echo 'morate prvo biti ulogovani';
				}
	}

	?>

















	<br/><br/><hr/><br><br/>


	<h2> 4. Create Categories </h2>
	<form action='index.php' method='POST' >
		title: <input type='text' name='tbTitle4' /> <br/>
		<input type='hidden' name='name_func' value='createCategories'>
		<input type='submit' name='btnCreateCategories' value='Create categorie'/>
	</form>

	<?php
	if(isset($_POST['name_func']) && $_POST['name_func'] == 'createCategories') {

				if(isset($_SESSION['user_id'])){
					$crud = new CrudServer();
					$title = $_POST['tbTitle4'];
					$users_id = $_SESSION['user_id'];
					$crud->createCategories($title, $users_id);
				}
				else {
					echo 'morate prvo biti ulogovani';
				}
	}

	?>




























	<br/><br/><hr/><br><br/>


	<h2> 5. Article (Read + Update + Delete) AND Comments</h2>
	<?php

		// >>>>>>>>>> COMMENTS >>>>>>>>>>>>
		function comments_block($article_id) {
			if(isset($_SESSION['user_id'])){
				echo "<form action='index.php' method='POST'>";
					echo "title: <input type='text' name='tbTitle' /> *** ";
					echo "text: <input type='text' name='tbText' /> ";
					echo "<input type='hidden' name='article_id' value='" . $article_id . "'/> ";
					echo "<input type='submit' name='btnCreateComment' value='Add comment'>";
				echo "</form>";
			}
			else {
				echo "morate biti ulogovani da biste postavili komentar";
			}
			echo "<br/>comments:<br/>";
			$crud = new CrudServer();
			$comments = $crud->read_comments();
			foreach($comments as $row) {
				if ($row['articles_id'] != $article_id) continue;
				if (isset($_SESSION['user_id']) && $row['users_id'] == $_SESSION['user_id']) {
					echo "<form action='index.php' method='POST' >";
						echo "id:" . $row['id'] . " *** ";
						echo "title: <input type='text' name='tbTitle' value='".$row['title']."'/> *** ";
						echo "text: <input type='text' name='tbText' value='".$row['text']."'/> ";
						echo "text: <input type='hidden' name='article_id' value='".$row['articles_id']."'/> ";
						echo "text: <input type='hidden' name='comment_id' value='".$row['id']."'/> ";
						echo "<input type='submit' name='btnUpdateComment' value='Update'/>";
						echo "<input type='submit' name='btnDeleteComment' value='Delete'/>";
					echo "</form>";
				}
				else
				{
					echo 'id: ' .$row['id']. ' *** title: ' . $row['title'] . ' *** text: ' . $row['text'] . ', <br/>';
				}
			}

			echo "<br/>";
			echo "<br/>";
			echo "---------------------------------------------------------------------<br/>";
			echo "<br/>";
		}

		if(isset($_POST['btnCreateComment'])) {
					if(isset($_SESSION['user_id'])){
						$crud = new CrudServer();
						$article_id = $_POST['article_id'];
						$text = $_POST['tbText'];
						$title = $_POST['tbTitle'];
						$users_id = $_SESSION['user_id'];
						$crud->createComment($article_id, $text, $title, $users_id);
					}
					else {
						echo 'morate prvo biti ulogovani';
					}
		}
		if(isset($_POST['btnUpdateComment'])) {
					$crud = new CrudServer();
					$title = $_POST['tbTitle'];
					$text = $_POST['tbText'];
					$comment_id = $_POST['comment_id'];

					$crud->updateComment($comment_id, $title, $text);
		}
		if(isset($_POST['btnDeleteComment'])) {
			$crud = new CrudServer();
			$comment_id = $_POST['comment_id'];
			$crud->deleteComments($comment_id);
		}


		// <<<<<< COMMENTS <<<<<<<<





		// >>>>>> ARTICTLES >>>>>>>>
		$crud = new CrudServer();
		$data_from_database = $crud->read_articles();
		foreach($data_from_database as $row) {
			if (isset($_SESSION['user_id']) && $row['users_id'] == $_SESSION['user_id']) {
				echo "<form name='formArticle' action='index.php' method='POST' >";
					echo "Article => id:".$row['id']." *** ";
					echo "title: <input type='text' name='tbTitle5' value='".$row['title']."'/> *** ";
					echo "text: <input type='text' name='tbText5' value='".$row['text']."'/> ";
					echo "categories_id: <input type='text' name='tbCategories_id' value='".$row['categories_id']."'/> ";
					echo "<input type='hidden' name='article_id5' id='article_id5' value='".$row['id']."'>";
					echo "<input type='submit' name='btnUpdateArticle' value='Update'/>";
					echo "<a href='javascript:void(0)' id='ajax_click_DELETE_article'>Delete</a>";
				echo "</form>";
				comments_block($row['id']);
			}
			else
			{
				echo 'Article => id: ' .$row['id']. ' *** title: ' . $row['title'] . ' *** text: ' . $row['text'] . ' *** categories_id: ' . $row['categories_id'].', <br/>';
				comments_block($row['id']);
			}
		}

		if(isset($_POST['btnUpdateArticle'])) {
					$crud = new CrudServer();
					$title = $_POST['tbTitle5'];
					$text = $_POST['tbText5'];
					$article_id = $_POST['article_id5'];
					$categories_id = $_POST['tbCategories_id'];
					$crud->updateArticles($article_id, $title, $text, $categories_id);
		}
		// <<<<<<<< ARTICLES <<<<<<<<<<

	?>

















	<br/><br/><hr/><br><br/>


	<h2> 6. Categories (Read + Update) </h2>
	<?php
		$crud = new CrudServer();
		$data_from_database = $crud->read_categories();
		foreach($data_from_database as $row) {
			if (isset($_SESSION['user_id']) && $row['users_id'] == $_SESSION['user_id']) {
				echo "<form action='index.php' method='POST' >";
					echo "id: " . $row['id'] . " *** ";
					echo "title: <input type='text' name='tbTitle' value='".$row['title']."'/> *** ";
					echo "<input type='hidden' id='categorie_id' name='categorie_id' value='".$row['id']."'>";
					echo "<input type='submit' name='btnUpdateCategorie' value='Update'/>";
					echo "<a href='javascript:void(0)' id='ajax_click_DELETE_categorie'>Delete</a>";
				echo "</form>";
			}
			else
			{
				echo 'id: ' .  $row['id']  .  ' *** title: ' . $row['title'] . ', <br/>';
			}
		}


		if(isset($_POST['btnUpdateCategorie'])) {
					$crud = new CrudServer();
					$title = $_POST['tbTitle'];
					$categorie_id = $_POST['categorie_id'];
					$crud->updateCategories($categorie_id, $title);
		}

	?>









</body>
</html>
