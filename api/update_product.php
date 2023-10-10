<?php
	require_once('../connect.php');
	if(isset($_POST['sub'])){
		$pid = $_POST['pid'];
		$pname = $_POST['pname'];
		$pdetail = $_POST['pdetail'];
		$price = $_POST['price'];
	
		$q="UPDATE Product SET p_name='$pname', p_detail='$pdetail', p_price='$price' where p_id=$pid";
		if(!$mysqli->query($q)){
			echo "UPDATE failed. Error: ".$mysqli->error ;
		}
		$mysqli->close();

		if(file_exists($_FILES["pimage"]["tmp_name"])){
			copy($_FILES["pimage"]["tmp_name"], '../product_img/'.$pid.'.jpg');
		}
		header("Location: /main/product.php");
	}
	elseif(isset($_POST['cancel'])){
		header("Location: /main/product.php");
	} else {
		header("Location: /main/dashboard.php");	
	}
?>