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
  <title>Feedback</title>
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
            <a class="nav-link" aria-current="page" href="#">Home</a>
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
            <a class="nav-link active" href="/main/feedback.php">Feedback</a>
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

  <p style="text-align: center" class="fs-3 my-5">Help us improve 👋</p>
  <p style="text-align: center" class="my-4">Please leave the feedback below.</p>

  <div style="width: 40%" class="mx-auto border rounded p-4">
    <div style="" class="row mb-3">
      <label for="pid" class="form-label"><b>Full Name</b></label>
      <input type="text" class="form-control" id="pid" name="pid" placeholder="<?= $_SESSION["fname"] . " " . $_SESSION["lname"] ?>" disabled />
    </div>
    <div style="" class="row mb-4">
      <label for="comment" class="form-label"><b>What is your problem using our web application?</b></label>
      <textarea class="form-control" id="comment" rows="5"></textarea>
    </div>
    <div style="" class="row">
      <button style="width: 33%;" type="submit" class="mx-auto btn btn-primary" name="feedback-sub">
            Submit Feedback
      </button>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>