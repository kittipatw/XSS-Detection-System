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
    <title>Product List</title>

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
    <link rel="stylesheet" href="/main/css/style_product.css" />
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
                <li><a class="dropdown-item" href="#">Product List</a></li>
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

    <p style="text-align: center" class="fs-3 my-4">Product List</p>

    <div
      style="height: 70%; width: 80%; overflow: scroll;"
      class="border rounded mx-auto"
    >
      <table style="width: 100%;" class="table table-sm table-hover">
        <thead>
          <tr class="table-light">
            <th style="width: 10%" scope="col">Product ID</th>
            <th style="width: 30%" scope="col">Name</th>
            <th style="width: 30%" scope="col">Detail</th>
            <th style="width: 10%" scope="col">Unit Price</th>
            <th style="width: 20%" scope="col"></th>
          </tr>
        </thead>
        <tbody>

          <?php
            $q="select * from Product";
            $result=$mysqli->query($q);
            if(!$result){
              echo "Select failed. Error: ".$mysqli->error ;
              return false;
            }
            while($row=$result->fetch_array()){ ?>
                  <tr>
                    <th scope="row"><?=$row['p_id']?></th>
                    <td><?=$row['p_name']?></td>
                    <td><?=$row['p_detail']?></td>
                    <td><?=$row['p_price']?></td>
                    <td class="button-cell">
                    <a href='edit_product.php?pid=<?=$row['p_id']?>'> <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button></a>
                    <a href='../api/deleteinfo.php?pid=<?=$row['p_id']?>'> <button type="button" class="btn btn-sm btn-outline-danger me-3">Delete</button></a>
                    </td>
                  </tr>                               
          <?php } ?>
          
        </tbody>
      </table>
    </div>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
