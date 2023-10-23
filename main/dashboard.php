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
  <title>Dashboard</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.1/font/bootstrap-icons.css" />

  <style>
    thead th {
      position: sticky;
      top: 0;
      z-index: 1;
    }
  </style>
</head>

<body style="height: 100vh; width: 100vw;">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand ms-3 me-5" href="/main/dashboard.php">Point of Sale</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item mx-2">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
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
                <li><a class="dropdown-item" href="/main/product.php">Product List</a></li>
                <li><hr class="dropdown-divider" /></li>
                <li>
                  <a class="dropdown-item" href="/main/add_product.php">Add Product</a>
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
                <li><a class="dropdown-item" href="/main/employee.php">Employee List</a></li>
                <li><hr class="dropdown-divider" /></li>
                <li>
                  <a class="dropdown-item" href="/main/add_employee.php">Add Employee</a>
                </li>
              </ul>
            </li>
            ';
          }
          ?>

          <li class="nav-item mx-2">
            <a class="nav-link" href="/main/feedback.php">Feedback</a>
          </li>
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
  echo "<p style=\"text-align: center\" class=\"fs-3 my-4\">Welcome, " . $_SESSION["fname"] . " " . $_SESSION["lname"] . "</p>";
  ?>


  <div style="height: 80%; width: 45%; overflow: hidden; float:left;" class="ms-5">
    <p style="text-align: center" class="fs-5">Statistical Summary</p>
    <div style="height: 25%;" class="row mb-5">
      <div class="col">
        <div class="border rounded bg-light">
          <div style="text-align: center;">
            <h5 class="fs-5 fw-lighter mt-3"><i class="bi bi-cup-hot fs-1"></i><br>Today's Orders</h5>
            <?php
            require_once('../connect.php');

            $q0 = "SELECT COUNT(o_id) FROM `Order` WHERE o_date = CURDATE()";
            $result0 = $mysqli->query($q0);
            if (!$result0) {
              echo "Select failed. Error: " . $mysqli->error;
              return false;
            }
            $row0 = $result0->fetch_array();
            if ($row0[0] == 0) {
              echo "<p class=\"fs-2\">0 Order</p>";
            } elseif ($row0[0] == 1) {
              echo "<p class=\"fs-2\">" . $row0[0] . " Order</p>";
            } else {
              echo "<p class=\"fs-2\">" . $row0[0] . " Orders</p>";
            }
            ?>

          </div>
        </div>
      </div>
      <div class="col">
        <div class="border rounded bg-light">
          <div style="text-align: center;">
            <h5 class="fs-5 fw-lighter mt-3"><i class="bi bi-graph-up-arrow fs-1"></i><br>Today's Sales</h5>
            <?php
            $q1 = "SELECT SUM(total_amount) FROM `Order` WHERE o_date = CURDATE()";
            $result1 = $mysqli->query($q1);
            if (!$result1) {
              echo "Select failed. Error: " . $mysqli->error;
              return false;
            }
            $row1 = $result1->fetch_array();
            if ($row1[0] == 0) {
              echo  "<p class=\"fs-2\">0 ฿</p>";
            } else {
              echo  "<p class=\"fs-2\">" . $row1[0] . " ฿</p>";
            }
            ?>
          </div>
        </div>
      </div>
    </div>
    <div style="height: 25%;" class="row mb-5">
      <div class="col">
        <div class="border rounded bg-light">
          <div style="text-align: center;">
            <h5 class="fs-5 fw-lighter mt-3"><i class="bi bi-calendar3 fs-1"></i><br>Total Orders This Month</h5>
            <?php
            $q4 = "SELECT COUNT(o_id) FROM `Order` WHERE MONTH(o_date) = MONTH(CURDATE())";
            $result4 = $mysqli->query($q4);
            if (!$result4) {
              echo "Select failed. Error: " . $mysqli->error;
              return false;
            }
            $row4 = $result4->fetch_array();
            if ($row4[0] == 0) {
              echo "<p class=\"fs-2\">0 Order</p>";
            } elseif ($row4[0] == 1) {
              echo "<p class=\"fs-2\">" . $row4[0] . " Order</p>";
            } else {
              echo "<p class=\"fs-2\">" . $row4[0] . " Orders</p>";
            }
            ?>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="border rounded bg-light">
          <div style="text-align: center;">
            <h5 class="fs-5 fw-lighter mt-3"><i class="bi bi-calendar3 fs-1"></i><br>Total Sales This Month</h5>
            <?php
            $q5 = "SELECT SUM(total_amount) FROM `Order` WHERE MONTH(o_date) = MONTH(CURDATE())";
            $result5 = $mysqli->query($q5);
            if (!$result5) {
              echo "Select failed. Error: " . $mysqli->error;
              return false;
            }
            $row5 = $result5->fetch_array();
            if ($row5[0] == 0) {
              echo  "<p class=\"fs-2\">0 ฿</p>";
            } else {
              echo  "<p class=\"fs-2\">" . $row5[0] . " ฿</p>";
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div style="height: 75%; width: 45%; overflow-y: auto; float:right;" class="rounded me-5">
    <p style="text-align: center" class="fs-5">Latest Orders</p>
    <div style="height: 90%;" class="row">
      <div style="height: 100%;" class="col">
        <div style="height: 100%; overflow-y: auto;" class="border rounded">
          <table class="table">
            <thead>
              <tr class="table-light">
                <th style="width: 20%" scope="col">Order ID</th>
                <th style="width: 30%" scope="col">Product List</th>
                <th style="width: 10%" scope="col">Total Amount</th>
                <th style="width: 20%" scope="col">Date</th>
                <th style="width: 10%" scope="col"></th>
              </tr>
            </thead>
            <tbody>
              <?php
              $q2 = "SELECT o_id, total_amount, o_date FROM `Order` ORDER BY o_date DESC, o_time DESC LIMIT 5";
              $result2 = $mysqli->query($q2);
              if (!$result2) {
                echo "Select failed. Error: " . $mysqli->error;
                return false;
              }
              while ($row2 = $result2->fetch_array()) {
                echo "<tr>";
                echo "<th scope=\"row\">" . $row2['o_id'] . "</th>";

                echo "<td>";
                $temp_o_id = $row2['o_id'];
                $q3 = "SELECT DISTINCT(pro.p_name) FROM Product pro INNER JOIN Detail_line del ON pro.p_id = del.p_id INNER JOIN `Order` o ON del.o_id = o.o_id WHERE del.o_id = $temp_o_id";
                $result3 = $mysqli->query($q3);
                if (!$result3) {
                  echo "Select failed. Error: " . $mysqli->error;
                  return false;
                }

                $count = 0;
                $numrows = $result3->num_rows;
                while ($row3 = $result3->fetch_array()) {

                  if ($count == 4) {
                    echo "...";
                    break;
                  }

                  echo $row3[0];
                  if ($count == $numrows - 1) {
                    break;
                  }
                  echo ", ";

                  $count++;
                }
                echo "</td>";

                echo "<td>" . $row2['total_amount'] . "</td>";

                $phpdate = strtotime($row2['o_date']);
                $mysqldate = date('d M Y', $phpdate);

                echo "<td>" . $mysqldate . "</td>";
                echo "<td><a href=\"order_confirmation.php?o_id=" . $row2['o_id'] . "\" class=\"btn btn-sm btn-outline-primary\">Details</a></td>";
                echo "</tr>";
              }

              ?>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>