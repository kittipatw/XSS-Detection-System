<?php
session_start();

if (isset($_SESSION["user"])) {
  header("Location: /main/dashboard.php");
}

?>

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Login</title>
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
    <nav class="navbar navbar-dark bg-dark">
      <div class="container-fluid">
        <span class="navbar-brand mb-0 mx-auto h1">Point of Sale | v1.0</span>
      </div>
    </nav>

    <form action="authenticate.php" method="POST">
      
      <div style="height: 90vh" class="d-flex align-items-center">
        <div class="card col-3 mx-auto mb-5">
          <div class="card-body">
            <h4 class="card-title text-center mb-4 mt-1">Sign in</h4>

            <div class="input-group flex-nowrap mb-3">
              <span class="input-group-text"
                ><i
                  class="bi bi-person-fill d-inline-flex"
                  style="font-size: 1.5rem"
                ></i
              ></span>
              <input
                type="text"
                class="form-control"
                placeholder="Username"
                name="username"
              />
            </div>

            <div class="input-group flex-nowrap mb-3">
              <span class="input-group-text"
                ><i
                  class="bi bi-key-fill d-inline-flex"
                  style="font-size: 1.5rem"
                ></i
              ></span>
              <input
                class="form-control"
                placeholder="Password"
                type="password"
                name="password"
              />
            </div>

            <?php
              if (isset($_GET["error"])) {
                echo '<div style="text-align: center;" class="text-danger">Wrong username or password.</div>';
              }
            ?>

            <div class="input-group flex-nowrap pt-3">
              <button type="submit" class="btn btn-primary w-100" name="sub">Login</button>
            </div>
          </div>
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
