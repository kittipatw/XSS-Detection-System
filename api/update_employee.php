<?php
	require_once('../connect.php');
	if(isset($_POST['sub'])){
		$eid = $_POST['eid'];
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$username = $_POST['username'];
		if (isset($_POST['password'])) {
			$password = hash('sha256', $_POST['password']);
		}
		$role = $_POST['role'];
		if($role == 1){
            $role = "Admin";
        }
        else{
            $role = "Cashier";
        }

		$q2 = "SELECT * FROM Employee WHERE e_username='$username'";
		$result = $mysqli->query($q2);
		$rowcount = $result->num_rows;

		$row = $result->fetch_array();

		echo $rowcount;
		if ($rowcount == 1 && ($row['e_id'] != $eid)) {
			header("Location: /main/edit_employee.php?error=1&eid=" . $eid);
		} else {
			if (isset($_POST['password'])) {
				$q="UPDATE Employee SET e_fname='$fname', e_lname='$lname', e_username='$username', e_password='$password', e_role='$role' where e_id=$eid";
			} else {
				$q="UPDATE Employee SET e_fname='$fname', e_lname='$lname', e_username='$username', e_role='$role' where e_id=$eid";
			}
			if(!$mysqli->query($q)){
				echo "UPDATE failed. Error: ".$mysqli->error ;
			}
			$mysqli->close();
	
			header("Location: /main/employee.php");
		}
	}
	elseif(isset($_POST['cancel'])){
		header("Location: /main/employee.php");
	} else {
		header("Location: /main/dashboard.php");
	}
?>