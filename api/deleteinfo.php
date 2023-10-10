<?php

	session_start();

	if(!isset($_SESSION["user"])) {
		header("Location: /authentication/login.html");
	} else {
		if ($_SESSION["user"] == "Cashier") {
			header("Location: /main/dashboard.php");
		} else {
			$pid = $_GET['pid'];
			$eid = $_GET['eid'];
			require_once('../connect.php');
			if (isset($pid)) {
				$q="DELETE FROM Product where p_id=$pid";
				if(!$mysqli->query($q)){
					echo "DELETE failed. Error: ".$mysqli->error ;
				}
				$mysqli->close();
				$imgfilename = "../product_img/".$pid.".jpg";
				unlink($imgfilename);
				header("Location: /main/product.php");
			}
			elseif (isset($eid)) {
				$q="DELETE FROM Employee where e_id=$eid";
					if(!$mysqli->query($q)){
						echo "DELETE failed. Error: ".$mysqli->error ;
				}
				$mysqli->close();
				header("Location: /main/employee.php");
			}
		}
	}
?>
