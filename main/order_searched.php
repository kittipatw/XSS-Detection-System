<?php
  session_start();

  if(!isset($_SESSION["user"])) {
    header("Location: /authentication/login.php");
  } else {
    if ($_SESSION["user"] == "Cashier") {
      header("Location: /main/dashboard.php");
    }
  }
?>

<?php require_once('../connect.php'); ?> 
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Orders</title>

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.1/font/bootstrap-icons.css"
    />
    <link rel="stylesheet" href="/main/css/style_order.css" />
  </head>

  <body style="height: 100vh; width: 100vw">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand ms-3 me-5" href="/main/dashboard.php">Point of Sale</a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
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
            <li class="nav-item mx-2">
              <a class="nav-link active" href="/main/order.php">Orders</a>
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
                <li><a class="dropdown-item" href="/main/employee.php">Employee List</a></li>
                <li><hr class="dropdown-divider" /></li>
                <li>
                  <a class="dropdown-item" href="/main/add_employee.php"
                    >Add Employee</a
                  >
                </li>
              </ul>
            </li>
            <li class="nav-item mx-2">
              <a class="nav-link" href="/main/feedback.php">Feedback</a>
            </li>
            <li class="nav-item mx-2">
              <a class="nav-link" href="/authentication/logout.php">Logout</a>
            </li>
          </ul>
          <span class="navbar-text me-3"> Logged in as: </span>
          <h5 class="my-1 me-3">
            <span class="badge text-bg-warning">Admin</span>
          </h5>
        </div>
      </div>
    </nav>

    <?php
    include('../check.php');
    $o_id = $_GET['search_query'];
    # $test = preProcess($o_id);
    # echo "<script>console.log('".$o_id."');</script>";

    // XSS DETECTION HERE
    // XSS DETECTION HERE
    // XSS DETECTION HERE
    // XSS DETECTION HERE
    // XSS DETECTION HERE

    if(is_numeric($o_id)){
      $q = "SELECT o_id FROM `order` WHERE `o_id` = $o_id;";
      $result = $mysqli->query($q);
  
      $row = $result->fetch_array();
  
      $order_id = $row['o_id'];
    }
    ?>

    <form action="./order_searched.php" method="GET">
      <label for="order_search">Search Order:</label>
        <input type="text" id="order_search" name="search_query" style="width: 300px;" value=<?php echo $o_id ?>>
    </form>

    <?php if($order_id == null) {
      echo "<p style=\"text-align: center\" class=\"fs-3 my-4\">Sorry, no results were found for: " . $o_id . "</p>";
    } 
    else{
      echo "<p style=\"text-align: center\" class=\"fs-3 my-4\">Found result for: " . $o_id . "</p>"; ?>

      <div
      style="height: 70%; width: 80%; overflow: scroll;"
      class="border rounded mx-auto"
    >
      <table style="width: 100%;" class="table table-sm table-hover">
        <thead>
          <tr class="table-light">
            <th class="index" style="width: 12%" scope="col">Order ID</th>
            <th style="width: 50%" scope="col">Product List</th>
            <th style="width: 15%" scope="col">Total Amount</th>
            <th style="width: 15%" scope="col">Date</th>
            <th style="width: 8%" scope="col"></th>
          </tr>
          <?php
              $q2 = "SELECT o_id, total_amount, o_date FROM `Order` ORDER BY o_date DESC, o_time DESC";
              $result2 = $mysqli->query($q2);
              if (!$result2) {
                echo "Select failed. Error: " . $mysqli->error;
                return false;
              }
              else{
                $row2 = $result2->fetch_array();
              }
              
              echo "<tr>";
              echo "<th class=\"index\" scope=\"row\">" . $order_id . "</th>";

              echo "<td>";
              $q3 = "SELECT DISTINCT(pro.p_name) FROM Product pro INNER JOIN Detail_line del ON pro.p_id = del.p_id INNER JOIN `Order` o ON del.o_id = o.o_id WHERE del.o_id = $order_id";
              $result3 = $mysqli->query($q3);
              if (!$result3) {
                echo "Select failed. Error: " . $mysqli->error;
                return false;
              }

              $count = 0;
              $numrows = $result3->num_rows;
              while ($row3 = $result3->fetch_array()) {
                if($count == 4) {
                  echo "...";
                  break;
                }

                echo $row3[0];
                if($count == $numrows-1){
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
              ?>
          
        </thead>
        <tbody>

          
          
        </tbody>
      </table>
    </div>
    <?php
    }
    ?>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
