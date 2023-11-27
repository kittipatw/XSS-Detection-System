<?php
    session_start();
    include('../check.php');
    require_once('../connect.php');

    $malicious = FALSE;

    // XSS DETECTION HERE
    // XSS DETECTION HERE
    if (isset($_POST['feedback_sub'])) {
        $input = $_POST['feedback_message'];
        $input_preprocessed = preProcess($input);
        
        // Exception: Skip validation steps if the input is just a plain text
        if (checkPlainText($input_preprocessed)) {
            $malicious = FALSE;
            echo "<script>console.log("."'Passed: Plain-Text'".");</script>";
        } else {
            if (CheckRuleBased($input_preprocessed)) {
                $malicious = TRUE;
                $_SESSION['detected_by'] = 'Rule-Based';
                echo "<script>console.log("."'Detected: By Rule-Based'".");</script>";
            }
            if ($malicious != TRUE){
                if(CheckModel($input_preprocessed)){
                    $malicious = TRUE;
                    $_SESSION['detected_by'] = 'Model';
                    echo "<script>console.log("."'Detected: By Model'".");</script>";
                }
            }
        }
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
                return FALSE;
            }
            header("Location: /main/feedback_list.php");
    }
    // IF detected
    else {
        WriteLog($input, "Stored");
        header("Location: /malicious.php");
        // BlockUser();
    }
