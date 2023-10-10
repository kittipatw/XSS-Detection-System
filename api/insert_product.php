<?php require_once('../connect.php'); 
	if(isset($_POST['sub'])) {
		$pid = $_POST['pid'];
		$pname = $_POST['pname'];
		$pdetail = $_POST['pdetail'];
        $price = $_POST['price'];

		$q="INSERT INTO Product(p_id, p_name, p_detail, p_price) VALUES ('$pid','$pname','$pdetail','$price');";
		$result=$mysqli->query($q);
		if(!$result){
			echo "INSERT failed. Error: ".$mysqli->error ;
			return false;
		}

		move_uploaded_file($_FILES["pimage"]["tmp_name"], '../product_img/'.$pid.'.jpg');

        header("Location: /main/product.php");
	} else {
		header("Location: /main/dashboard.php");
	}
?>