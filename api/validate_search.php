<?php
    include('../check.php');
	require_once('../connect.php');
	if(isset($_GET['search_query'])){
        $input = $_GET['search_query'];

        // XSS DETECTION HERE
        // XSS DETECTION HERE
        // XSS DETECTION HERE
        // XSS DETECTION HERE
        // XSS DETECTION HERE
    }

    // Return GET to order_searched for display
    if (!empty($_GET['search_query'])) {
        $search_query = urlencode($_GET['search_query']);
        header("Location: /main/order_searched.php?search_query=" . $search_query);
    }
?>