<div class="jumbotron jumbotron-fluid">
    <div class="container">
      <h1 class="display-4">XSS Attempt Detected</h1>
      <p class="lead">You have been block :(</p>
    </div>
</div>

<?php
  session_start();
  echo "Warning: Detected by " . $_SESSION['detected_by'];
  $_SESSION['detected_by'] = null;
?>