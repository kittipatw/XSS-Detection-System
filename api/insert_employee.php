<?php require_once('../connect.php');
if (isset($_POST['sub'])) {
	$eid = $_POST['eid'];
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$username = $_POST['username'];
	$password = hash('sha256', $_POST['password']);
	$role = $_POST['role'];
	if ($role == 1) {
		$role = "Admin";
	} else {
		$role = "Cashier";
	}

	$q = "SELECT * FROM Employee WHERE e_username='$username'";
	$result = $mysqli->query($q);
	$rowcount = $result->num_rows;
	if ($rowcount == 1) {
		header("Location: /main/add_employee.php?error=1");
	} else {
		$q1 = "INSERT INTO Employee(e_id, e_fname, e_lname, e_username, e_password, e_role) VALUES ('$eid', '$fname', '$lname', '$username', '$password', '$role');";
		$result1 = $mysqli->query($q1);
		if (!$result1) {
			echo "INSERT failed. Error: " . $mysqli->error;
			return false;
		}
		header("Location: /main/employee.php");
	}
} else {
	header("Location: /main/dashboard.php");
}
?>