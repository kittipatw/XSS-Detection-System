<?php
    session_start();
    include('../check.php');
    require_once('../connect.php');

    $malicious = FALSE;

    // XSS DETECTION HERE
    // XSS DETECTION HERE
    if (isset($_GET['search_query'])) {
        $input = $_GET['search_query'];
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

    // Return GET to order_searched for display
    if (!empty($_GET['search_query']) && $malicious == FALSE) {
        $search_query = urlencode($_GET['search_query']);
        $_SESSION['validated_search'] = TRUE;
        header("Location: /main/order_searched.php?search_query=" . $search_query);
    }
    // IF detected
    else {
        WriteLog($input, "Reflected", $_SESSION['detected_by']);
        header("Location: /malicious.php");
        // BlockUser();
    }
?>
