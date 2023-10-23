<?php
session_start();

if (!isset($_SESSION["user"])) {
  header("Location: /authentication/login.php");
}

require_once('../connect.php');

if (!isset($_GET['o_id'])) {
  header("Location: /main/dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Order Confirmation</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.1/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="/main/css/style_order_confirmation.css" />

  <style>
    .index {
      text-align: center;
      vertical-align: middle;
    }

    thead th {
      position: sticky;
      top: 0;
      z-index: 1;
    }
  </style>
</head>

<body style="height: 100vh;">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand ms-3 me-5" href="/main/dashboard.php">Point of Sale</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item mx-2">
            <a class="nav-link" href="/main/dashboard.php">Home</a>
          </li>
          <li class="nav-item mx-2">
            <a class="nav-link" href="/main/sale.php">Make Sale</a>
          </li>
          <?php
          if ($_SESSION["user"] == "Admin") {
            echo
            '<li class="nav-item mx-2">
              <a class="nav-link" href="/main/order.php">Orders</a>
            </li>
            
            <li class="nav-item dropdown mx-2">
              <a
                class="nav-link dropdown-toggle"
                href="#"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                Product Management
              </a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="/main/product.php"
                    >Product List</a
                  >
                </li>
                <li><hr class="dropdown-divider" /></li>
                <li>
                  <a class="dropdown-item" href="/main/add_product.php"
                    >Add Product</a
                  >
                </li>
              </ul>
            </li>
            <li class="nav-item dropdown mx-2">
              <a
                class="nav-link dropdown-toggle"
                href="#"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                Employee Management
              </a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="/main/employee.php"
                    >Employee List</a
                  >
                </li>
                <li><hr class="dropdown-divider" /></li>
                <li>
                  <a class="dropdown-item" href="/main/add_employee.php"
                    >Add Employee</a
                  >
                </li>
              </ul>
            </li>';
          }
          ?>
          <li class="nav-item mx-2">
            <a class="nav-link" href="/authentication/logout.php">Logout</a>
          </li>
        </ul>
        <span class="navbar-text me-3"> Logged in as: </span>
        <h5 class="my-1 me-3">
          <?php
          if ($_SESSION["user"] == "Admin") {
            echo '<span class="badge text-bg-warning">Admin</span>';
          } else {
            echo '<span class="badge text-bg-secondary">Cashier</span>';
          }
          ?>
        </h5>
      </div>
    </div>
  </nav>

  <?php
  $o_id = $_GET['o_id'];
  $q = "SELECT o_id, o_date, o_time, total_amount AS order_total FROM `order` WHERE `o_id` = $o_id;";
  $result = $mysqli->query($q);

  $row = $result->fetch_array();

  $phpdate = strtotime($row['o_date']);
  $mysqldate = date('d M Y', $phpdate);

  $order_id = $row['o_id'];
  $order_date = $mysqldate;
  $order_time = $row['o_time'];
  $order_total = $row['order_total'];

  ?>
  <h1><?php echo "test:" . $o_id; ?></h1>

  <div style="width: 50%" class="mx-auto mt-5 rounded">
    <svg class="checkmark mx-auto mb-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
      <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none" />
      <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
    </svg>
    <p style="text-align: center; color: #7ac142;" class="fs-2">Order Completed</p>
  </div>
  <div style="height: 55%; width: 40%" class="mx-auto border rounded p-4">
    <div style="height: 7%;" class="row">
      <div class="col"><b>Order ID</b></div>
      <?php echo "<div class=\"col\">$order_id</div>"; ?>
    </div>
    <div style="height: 7%;" class="row">
      <div class="col"><b>Order Date</b></div>
      <?php echo "<div class=\"col\">$order_date</div>"; ?>
    </div>
    <div style="height: 7%;" class="row mb-3">
      <div class="col"><b>Order Time</b></div>
      <?php echo "<div class=\"col\">$order_time</div>"; ?>
    </div>
    <div style="height: 50%; overflow-y: auto;" class="col border rounded mb-3">
      <table class="table table-sm table-hover">
        <thead>
          <tr class="table-light">
            <th class="index" style="width: 10%" scope="col">#</th>
            <th style="width: 35%" scope="col">Item</th>
            <th style="width: 15%" scope="col">Quantity</th>
            <th style="width: 15%" scope="col">Unit Price</th>
            <th style="width: 15%" scope="col">Price</th>
          </tr>
        </thead>
        <tbody class="order-table">
          <?php
          $q = "SELECT `Order`.o_id, o_date, o_time, d_id, `Detail_line`.p_id, `Product`.`p_name`, `Product`.`p_detail`, d_quantity, p_price, d_quantity*`Product`.`p_price` AS total_price FROM `Order` 
            INNER JOIN `Detail_line` ON `Order`.o_id = Detail_line.o_id 
            INNER JOIN `Product` ON `Detail_line`.`p_id` = Product.p_id
            WHERE `Order`.`o_id` = $o_id;";
          $result = $mysqli->query($q);

          while ($row = $result->fetch_array()) {
            echo "<tr>
                      <th class=\"index\" scope=\"row\">" . $row['d_id'] . "</th>
                      <td>" . $row['p_name'] . "</td>
                      <td>" . $row['d_quantity'] . "</td>
                      <td>" . $row['p_price'] . "</td>
                      <td>" . $row['total_price'] . "</td>
                    </tr>";
          }
          ?>
        </tbody>
      </table>
    </div>

    <div style="height: 7%;" class="row">
      <div class="col"><b>Sub Total</b></div>
      <?php echo "<div class=\"col\">" . number_format(round($order_total / 1.07, 2),2) . "</div>"; ?>
    </div>
    <div style="height: 7%;" class="row">
      <div class="col"><b>Tax</b></div>
      <?php echo "<div class=\"col\">" . number_format(round($order_total - ($order_total / 1.07), 2),2) . "</div>"; ?>
    </div>
    <div style="height: 7%;" class="row">
      <div class="col"><b>Total Amount</b></div>
      <?php echo "<div class=\"col\">$order_total</div>"; ?>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>

</html>