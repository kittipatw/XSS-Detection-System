<?php
session_start();

if (!isset($_SESSION["user"])) {
  header("Location: /authentication/login.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Make Sale</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.1/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="/main/css/style_sale.css" />
</head>

<body style="height: 100vh">
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
            <a class="nav-link active" href="#">Make Sale</a>
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

  <div style="height: 88%; width: 50%; float: left; overflow-y: auto;" class="border rounded my-3 ms-3 bg-light">

    <?php

    require_once('../connect.php');

    $q = "SELECT * FROM Product";
    $result = $mysqli->query($q);
    if (!$result) {
      echo "Retrieve Data failed. Error: " . $mysqli->error;
    } else {
      while ($row = $result->fetch_array()) {
        echo "<a class='add-to-cart' id='p-".$row['p_id']."' data-pid='" . $row['p_id'] . "' data-name='" . $row['p_name'] . "' data-price='" . $row['p_price'] . "' style='color: inherit;' href='#'><div class=\"product-list border rounded bg-white\">
              <div class=\"border-bottom\" style=\"width: 100%; height: 80%; display: flex; justify-content: center; align-items: center; overflow: hidden;\">
                <img
                  style=\"max-height: 100%; max-width: 100%; flex-shrink: 0;\"
                  src=\"../product_img/" . $row['p_id'] . ".jpg\"
                  alt=\"...\"
                />
              </div>
              <div style=\"width: 100%; height 20%; text-align: center;\">
                <p style=\"font-size: 1vw;\" class=\"mx-auto fw-light\">" . $row['p_name'] . "</p>
              </div>
            </div></a>";
      }
    }
    ?>
  </div>

  <div style="height: 88%; width: 6%; float: left" class="rounded ms-2 my-3">
    <button style="width: 100%; height: 0; padding-bottom: 90%" type="button" class="btn btn-outline-secondary mb-2" data-bs-toggle="modal" data-bs-target="#manual-pid-modal">
      <i style="font-size: 1.5rem" class="bi bi-vr"></i><br />
      <p style="line-height: 1">Manual PID</p>
    </button>
    <button style="width: 100%; height: 0; padding-bottom: 90%" type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#coupon-modal">
      <i style="font-size: 1.5rem" class="bi bi-ticket-perforated"></i><br />
      <p style="line-height: 2">Coupon</p>
    </button>

    <!-- Modal -->
    <div class="modal fade" id="manual-pid-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">
              Manual PID Input
            </h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col">
                <label for="pid" class="form-label">Product ID</label>
                <input type="text" class="form-control" id="manual-pid" />
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-lg btn-secondary" data-bs-dismiss="modal">
              Cancel
            </button>
            <a id='manual-add' href='#'><button type="button" data-bs-dismiss="modal" class="btn btn-lg btn-success">
              Confirm
            </button></a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="cash-tray-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col">
                <h2 style="text-align: center;">Cash Drawer Opened</h2>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-lg btn-secondary mx-auto" data-bs-dismiss="modal">
              Close
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="coupon-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col">
                <h2 style="text-align: center;">No coupon available.</h2>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-lg btn-secondary mx-auto" data-bs-dismiss="modal">
              Close
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div style="height: 55%; width: 40%; float: right; overflow-y: auto;" class="border rounded me-3 mt-3 mb-1">
    <table class="table table-sm table-hover">
      <thead>
        <tr class="table-light">
          <th class="index" style="width: 5%" scope="col">#</th>
          <th style="width: 30%" scope="col">Item</th>
          <th style="width: 15%" scope="col">Quantity</th>
          <th style="width: 15%" scope="col">Unit Price</th>
          <th style="width: 15%" scope="col">Price</th>
          <th style="width: 20%" scope="col"></th>
        </tr>
      </thead>
      <tbody class="order-table">
        <!-- <tr>
            <th class="index" scope="row">1</th>
            <td>Egg</td>
            <td>1</td>
            <td>10</td>
            <td>10</td>
            <td class="button-cell">
              <button type="button" class="btn btn-outline-secondary btn-vsm"><i class="bi bi-dash-lg"></i></button>
              <button type="button" class="btn btn-outline-secondary btn-vsm"><i class="bi bi-plus-lg"></i></button>
              <button type="button" class="btn btn-outline-danger btn-vsm"><i class="bi bi-x-lg"></i></button>
            </td>
          </tr>
          <tr> -->
      </tbody>
    </table>
  </div>

  <div style="height: 15%; width: 40%; float: right" class="border rounded me-3 mt-3 mb-1">
    <div class="d-flex bd-highlight mx-3">
      <div class="me-auto fs-3 bd-highlight">Total</div>
      <div id="total-amount" class="fs-3 bd-highlight">0.00</div>
      <div class="fs-3 bd-highlight">&nbsp;฿</div>
    </div>
    <div class="d-flex bd-highlight mx-3">
      <div class="me-auto bd-highlight">Tax</div>
      <div id="tax" class="bd-highlight">0.00</div>
      <div class="bd-highlight">&nbsp;฿</div>
    </div>
    <div class="d-flex bd-highlight mx-3">
      <div class="me-auto bd-highlight">Subtotal</div>
      <div id="sub-total" class="bd-highlight">0.00</div>
      <div class="bd-highlight">&nbsp;฿</div>
    </div>
  </div>

  <div style="height: 10%; width: 40%; float: right" class="rounded me-3 mt-3 mb-1">
    <button style="float: left; height: 100%; width: 20%" type="button" class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#cash-tray-modal">
      <i style="font-size: 1.5rem" class="bi bi-cash-coin"></i><br />
      <p style="white-space: nowrap">Cash Drawer</p>
    </button>
    <a href="/main/sale.php"><button style="float: left; height: 100%; width: 20%" type="button" class="btn btn-outline-danger">
        <i style="font-size: 1.5rem" class="bi bi-x-circle"></i><br />
        <p style="white-space: nowrap">Cancel</p>
      </button></a>
    <form action="../api/cart_process.php" method="POST" style="float: right; height: 100%; width: 50%">
      <input id="cart" type="hidden" name="cart">
      <button id="pay-button" style="float: right; height: 100%; width: 100%" type="submit" class="btn fs-3 btn-success" name="sub" disabled>
        Pay
      </button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
  <script src="cart.js"></script>
</body>

</html>