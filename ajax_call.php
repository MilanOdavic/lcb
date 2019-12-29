<?php
	include 'dbh.php';
	include 'crudServer.php';

	if($_POST['name_func'] == 'delete_article') {
		$crud = new CrudServer();
		$article_id = $_POST['article_id'];
		$crud->deleteArticles($article_id);
	}


	if($_POST['name_func'] == 'delete_categorie') {
		$crud = new CrudServer();
		$categorie_id = $_POST['categorie_id'];
		$crud->deleteCategories($categorie_id);
	}



?>
