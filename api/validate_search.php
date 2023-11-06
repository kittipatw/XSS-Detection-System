<?php
    session_start();
    include('../check.php');
    require_once('../connect.php');

    $malicious = FALSE;

    if (isset($_GET['search_query'])) {
        $input = $_GET['search_query'];
        $input_preprocessed = preProcess($input);

        // Exception: Skip validation steps if the input is just a plain text
        if (checkPlainText($input_preprocessed)) {
            $malicious = FALSE;
        } else {
            if (CheckRuleBased($input_preprocessed)) {
                $malicious = TRUE;
            }
            // if ($malicious != TRUE){
            //     if(CheckModel($input_preprocessed)){
            //         $malicious = TRUE;
            //     }
            // }

            // XSS DETECTION HERE
            // XSS DETECTION HERE
            // XSS DETECTION HERE
            // XSS DETECTION HERE
            // XSS DETECTION HERE
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
        // WriteLog($input, "Reflected");
        header("Location: /malicious.php");
        // BlockUser();
    }
?>
