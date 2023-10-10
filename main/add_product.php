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

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Add Product</title>
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
  </head>

  <body>
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
              <a class="nav-link" href="/main/order.php">Orders</a>
            </li>
            <li class="nav-item dropdown mx-2">
              <a
                class="nav-link dropdown-toggle active"
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
                  <a class="dropdown-item" href="#">Add Product</a>
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

    <p style="text-align: center" class="fs-3 my-5">Add Product</p>

    <form action="../api/insert_product.php" enctype="multipart/form-data" method="POST">
      <div style="width: 50%" class="mx-auto border rounded p-4">
        <div class="row mb-3">
          <div class="col-4">
            <label for="pid" class="form-label">Product ID</label>
            <input type="text" class="form-control" id="pid" name="pid" required/>
          </div>
          <div class="col-8">
            <label for="pname" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="pname" name="pname" required/>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col">
            <label for="pdetail" class="form-label"
              >Detail <label class="fs-6 fw-lighter">(Optional)</label></label
            >
            <input
              type="text"
              class="form-control"
              id="pdetail"
              name="pdetail"
              placeholder="ex. color, size, etc."
            />
          </div>
        </div>

        <div class="row mb-3">
          <div class="col">
            <label for="pimage" class="form-label">Product Image</label>
            <input type="file" class="form-control" id="pimage" name="pimage" required/>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-4">
            <label for="price" class="form-label">Unit Price</label>
            <div class="input-group">
              <input type="text" class="form-control" id="price" name="price" required/>
              <span class="input-group-text">฿</span>
            </div>
          </div>
          <div class="col-8"></div>
        </div>

        <div class="row mt-5">
          <button type="submit" class="mx-auto btn btn-primary w-25" name="sub">
            Confirm
          </button>
        </div>
      </div>
    </form>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
