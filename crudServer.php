<?php

class CrudServer extends Dbh{

	private $name;
	private $password;
	private $email;
	private $id_role;



	public function registration($name, $pass){
		$sql = "INSERT INTO users (name,pass) VALUES ('$name','$pass')";
		$result = $this->connect()->query($sql);
	}


	public function login($name, $pass){
		$sql = "SELECT * FROM users WHERE name = '$name' and pass = '$pass'";
		$result = $this->connect()->query($sql);
		$data = [];
		while($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}


	// CREATE
	public function createArticle($categories_id, $text, $title, $users_id){
		$sql = "INSERT INTO articles (categories_id, text, title, users_id) VALUES ('$categories_id', '$text', '$title', $users_id)";
		$result = $this->connect()->query($sql);
	}


	public function createCategories($title, $users_id){
		$sql = "INSERT INTO categories (title, users_id) VALUES ('$title', $users_id)";
		$result = $this->connect()->query($sql);
	}

	public function createComment($article_id, $text, $title, $users_id){
		$sql = "INSERT INTO comments (articles_id, users_id, title, text) VALUES ($article_id, $users_id, '$title', '$text')";
		$result = $this->connect()->query($sql);
		return $result;
	}






	// READ
	public function read_articles(){
		$sql = "SELECT * FROM articles";
		$result = $this->connect()->query($sql);
		while($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}


	public function read_categories(){
		$sql = "SELECT * FROM categories";
		$result = $this->connect()->query($sql);
		while($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}


	public function read_comments(){
		$sql = "SELECT * FROM comments";
		$result = $this->connect()->query($sql);
		while($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}




	// UPDATE
	public function updateArticles($article_id, $title, $text, $categories_id) {
		$sql = "UPDATE articles SET title = '$title', text = '$text' , categories_id = $categories_id WHERE id = $article_id";
		$result = $this->connect()->query($sql);
	}


	public function updateCategories($categorie_id, $title) {
		$sql = "UPDATE categories SET title = '$title' WHERE id = $categorie_id";
		$result = $this->connect()->query($sql);
	}


	public function updateComment($comment_id, $title, $text) {
		$sql = "UPDATE comments SET title = '$title', text = '$text'  WHERE id = $comment_id";
		$result = $this->connect()->query($sql);
	}






	// DELETE
	public function deleteArticles($id){
		$sql = "DELETE FROM articles WHERE id = '$id' ";
		$result = $this->connect()->query($sql);
	}

	public function deleteCategories($id){
		$sql = "DELETE FROM articles WHERE categories_id = '$id' ";
		$result = $this->connect()->query($sql);

		$sql = "DELETE FROM categories WHERE id = '$id' ";
		$result = $this->connect()->query($sql);
	}


	public function deleteComments($id){
		$sql = "DELETE FROM comments WHERE id = '$id' ";
		$result = $this->connect()->query($sql);
	}





	// >>>>>>>>>>>>>>>>>>>> EXAMPLES >>>>>>>>>>>>>>>>>>>>>



	// 1. CREATE
	public function create_func($name, $password, $email, $id_role){
		$sql = "INSERT INTO users (name,password,email,id_role) VALUES ('$name','$password','$email','$id_role')";
		$result = $this->connect()->query($sql);
	}



	// 2. READ
	public function read_func(){
		$sql = "SELECT * FROM users";
		$result = $this->connect()->query($sql);
		while($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}



	// 3. UPDATE
	public function update_func($name){
		$sql = "UPDATE users SET name = '$name' WHERE id = $id";
		$result = $this->connect()->query($sql);
	}




	// 4. DELETE
	public function delete_func($id){
		$sql = "DELETE FROM users WHERE id = '$id' ";
		$result = $this->connect()->query($sql);
	}



}

?>
