<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: /authentication/login.php");
}

if (isset($_POST['sub'])) {
//     $cart = $_POST['cart'];
//     echo "CHECKED<br>";
//     $cart = json_decode($cart, true);

//     echo "------<br>";

//     foreach ($cart as $list) {
//         echo $list['p_id'] . " " . $list['p_name'] . " " . $list['p_price'] . " " . $list['count'] . "<br>";
//     }
//     echo "<br>";
//     //var_dump($cart);
// }

    $cart = $_POST['cart'];
    $cart = json_decode($cart, true);

    $total_amount = 0;
    foreach ($cart as $list) {
        $total_amount += $list['p_price'] * $list['count'];
    }

    require_once('../connect.php');
    $o_id = rand(1000000000, 9999999999);
    date_default_timezone_set("Asia/Bangkok");
    $o_date = date("Y-m-d");
    $o_time = date("H:i:s");
    $e_id = (int)$_SESSION["e_id"];
    $payment_id = 1;

    //CHECK IF o_id already (randomly) exist or not

    $q0 = "SELECT o_id FROM `Order` WHERE o_id = $o_id";
    $result0 = $mysqli->query($q0);
    if (!$result0) {
        echo "Select failed. Error: " . $mysqli->error;
        return false;
    }
    while ($row0 = $result0->fetch_array()) {
        if ($row0[0] == null) {
            break;
        } else {
            $o_id = rand(1000000000, 9999999999);
        }
    }

    $q1 = "INSERT INTO `Order`(o_id, o_date, o_time, total_amount, e_id, payment_id) VALUES ('$o_id', '$o_date', '$o_time', '$total_amount', '$e_id', '$payment_id');";
    $result1 = $mysqli->query($q1);
    if (!$result1) {
        echo "INSERT failed. Error: " . $mysqli->error;
        return false;
    }

    $from_o_id = $o_id;

    $d_id = 1;
    foreach ($cart as $list) {
        $p_id = $list['p_id'];
        $quantity = $list['count'];
        $q2 = "INSERT INTO Detail_line(d_id, o_id, p_id, d_quantity) VALUES ('$d_id', '$from_o_id', '$p_id', '$quantity');";
        $result2 = $mysqli->query($q2);
        if (!$result2) {
            echo "INSERT failed. Error: " . $mysqli->error;
            return false;
        }
        $d_id++;
    }


    header("Location: ../main/order_confirmation.php?o_id=".$o_id);
}