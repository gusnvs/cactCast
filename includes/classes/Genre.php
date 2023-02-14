<?php 

class Genre {

	private $con;
	private $id;
	private $name;

	public function __construct($con, $id) {
		$this->con = $con;
		$this->id = $id;

		$genreQuery = mysqli_query($this->con, "SELECT name FROM genres WHERE id='$this->id'");
		$genre = mysqli_fetch_array($genreQuery);
		
		$this->name = $genre['name'];
	}

	public function getType() {
		return $this->name;
	}

	public function getSongIds() {

			$query = mysqli_query($this->con, "SELECT id FROM songs WHERE genre='$this->id'");

			$array = array();

			while($row = mysqli_fetch_array($query)) {
				array_push($array, $row['id']);
			}

			return $array;

		}

	public function getId() {
		return $this->id;
	}
}
?>