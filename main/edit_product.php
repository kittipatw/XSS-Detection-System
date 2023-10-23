<?php
session_start();

if (!isset($_SESSION["user"])) {
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
  <title>Edit Product</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.1/font/bootstrap-icons.css" />
</head>

<body>
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
          <li class="nav-item mx-2">
              <a class="nav-link" href="/main/order.php">Orders</a>
            </li>
          <li class="nav-item dropdown mx-2">
            <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Product Management
            </a>
            <ul class="dropdown-menu">
              <li>
                <a class="dropdown-item" href="/main/product.php">Product List</a>
              </li>
              <li>
                <hr class="dropdown-divider" />
              </li>
              <li>
                <a class="dropdown-item" href="/main/add_product.php">Add Product</a>
              </li>
            </ul>
          </li>
          <li class="nav-item dropdown mx-2">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Employee Management
            </a>
            <ul class="dropdown-menu">
              <li>
                <a class="dropdown-item" href="/main/employee.php">Employee List</a>
              </li>
              <li>
                <hr class="dropdown-divider" />
              </li>
              <li>
                <a class="dropdown-item" href="/main/add_employee.php">Add Employee</a>
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

  <p style="text-align: center" class="fs-3 my-5">Edit Product</p>

  <?php
  $pid = $_GET['pid'];
  require_once('../connect.php');
  $q = "SELECT * FROM Product where p_id=$pid";
  $result = $mysqli->query($q);
  while ($row = $result->fetch_array()) {
  ?>
    <form action="../api/update_product.php" enctype="multipart/form-data" method="POST">
      <div style="width: 50%" class="mx-auto border rounded p-4">
        <input type=hidden name=pid value="<?= $row['p_id'] ?>">
        <div class="row mb-3">
          <div class="col-4">
            <label for="pid" class="form-label">Product ID</label>
            <input type="text" class="form-control" id="pid" name="pid" placeholder="<?= $row['p_id'] ?>" disabled />
          </div>
          <div class="col-8">
            <label for="pname" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="pname" name="pname" value="<?= $row['p_name'] ?>" />
          </div>
        </div>
        <div class="row mb-3">
          <div class="col">
            <label for="pdetail" class="form-label">Detail <label class="fs-6 fw-lighter">(Optional)</label></label>
            <input type="text" class="form-control" id="pdetail" placeholder="ex. color, size, etc." name="pdetail" value="<?= $row['p_detail'] ?>" />
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-4">
            <label class="form-label">Product Image</label><br />
            <img style="max-height: 7.5rem; max-width: 100%" src="../product_img/<?= $row['p_id'] ?>.jpg" alt="..." class="border rounded" />
          </div>
          <div class="col-8">
            <div class="row mb-3">
              <div class="col">
                <label for="pimage" class="form-label">New Image
                  <label class="fs-6 fw-lighter">(Optional)</label></label><br />
                <input type="file" class="form-control" id="pimage" name="pimage" />
              </div>
            </div>
            <div class="row">
              <div class="col">
                <label for="price" class="form-label">Unit Price</label>
                <div class="input-group">
                  <input type="text" class="form-control" id="price" name="price" value="<?= $row['p_price'] ?>" />
                  <span class="input-group-text">฿</span>
                </div>
              </div>
              <div class="col"></div>
            </div>
          </div>
        </div>

        <div class="row mt-5">
          <button type="submit" class="ms-auto me-3 btn btn-outline-secondary w-25" name="cancel">Cancel</button>
          <button type="submit" class="me-auto btn btn-primary w-25" name="sub">
            Apply Change
          </button>
        </div>
      </div>
    </form>
  <?php
  }
  ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>