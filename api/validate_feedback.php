<?php
    session_start();
    include('../check.php');
    require_once('../connect.php');

    $malicious = FALSE;

    if (isset($_POST['feedback_sub'])) {
        $input = $_POST['feedback_message'];
        
        // XSS DETECTION HERE
        // XSS DETECTION HERE
        // XSS DETECTION HERE
        // XSS DETECTION HERE
        // XSS DETECTION HERE

    }


    // Insert message into database
    if (!empty($_POST['feedback_message']) && $malicious == FALSE) {
        $eid = $_SESSION["e_id"];
        $fname = $_SESSION["fname"];
        $lname = $_SESSION["lname"];
        $q1 = "INSERT INTO Feedback(e_id, e_fname, e_lname, sub_message, sub_date_time) VALUES ('$eid', '$fname', '$lname', '$input', NOW());";
            $result1 = $mysqli->query($q1);
            if (!$result1) {
                echo "INSERT failed. Error: " . $mysqli->error;
                return false;
            }
            // header("Location: /main/feedback.php");
    }
    // IF detected
    else{
        
    }
?>