<?php
	class User {

		private $con;
		private $username;

		public function __construct($con, $username) {
			$this->con = $con;
			$this->username = $username;
		}

		public function getUserName() {
			return $this->username;
		}

		public function getFistAndLastName() {
			$query = mysqli_query($this->con, "SELECT concat(firstName, ' ', lastName) as 'name' FROM users WHERE username='$this->username'");
			$row = mysqli_fetch_array($query);

			return $row['name'];
		}

		public function getProfilePic() {
			$query = mysqli_query($this->con, "SELECT profilePic FROM users WHERE username='$this->username'");
			$row = mysqli_fetch_array($query);

			return $row['profilePic'];
		}
	}
?>