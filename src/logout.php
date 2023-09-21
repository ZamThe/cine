<?php

	class Logout {

		//attributes 


		//methods

		public function LogoutUser() {

			session_start();

			session_unset();

			session_destroy();

			echo "<script>location.href='login.php';</script>";

		}

	}

	$logout = new Logout();
	$logout->LogoutUser();

	/*session_start();

  	session_unset();

  	session_destroy();

  	header('Location: /index.php');*/

?>
