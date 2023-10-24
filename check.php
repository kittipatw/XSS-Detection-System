<?php
session_start();

// Check if the submitted request is GET or POST
if ($_SERVER['REQUEST_METHOD'] == 'GET' || 'POST') {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        // Acquire input from GET
        $input = $_GET['input'];
    } else {
        // Acquire input from POST
        $input = $_POST['input'];
    }

    if (PreProcess($input_str)) {
        if (CheckRuleBased($input_str)) {
            if (CheckModel($input_str)) {
            }
            WriteLog($user_info, $input_str);
            Send_Notification($admin, $user_info, $input_str);
        }
        WriteLog($user_info, $input_str);
        Send_Notification($admin, $user_info, $input_str);
    }
    WriteLog($user_info, $input_str);
    Send_Notification($admin, $user_info, $input_str);
}


// $malicious = FALSE;

function preProcess($input)
{
    // Remove spaces, tabs, and line breaks
    $output = str_replace(array(' ', "\t", "\n", "\r"), '', $input);
    // Convert to lowercase
    $output = strtolower($output);
    // Replace ' with "
    $output = str_replace("'", '"', $output);
    return $output;
}

function CheckRuleBased($input)
{
    // Array of Regular Expression of XSS patterns
    $patterns = array(
        // '/<[^>]+>.*?<\/[^>]+>/', // <XXX> and </XXX> i.e., <with_something_inside> and </with_something_inside>
        '/<\s*script[^>]*>.*<\/\s*script\s*>/i', // <script>something</script>
        '/<\s*iframe[^>]*>.*<\/\s*iframe\s*>/i', // <iframe>something</iframe>
        '/<\s*a\s+href="javascript:[^>]*>/i', // <a href=something</a>
        // ADD more pattern
    );

    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $input)) {
            return TRUE; // XSS attempt
        }
    }
}



function CheckModel($input)
{
    return TRUE;
}
function WriteLog($input, $type)
{
    $user_id = $_SESSION["e_id"];
    $user_name = $_SESSION["fname"] . " " . $_SESSION["lname"];
    $user_role = $_SESSION["user"];
    $attempt_script = $input;
    $current_time = date('Y-m-d H:i:s');
    
    // Define log message
    $log_message = "User ID: " . $user_id . "\n"
            . "Name: " . $user_name . "\n"
            . "Role: " . $user_role . "\n"
            . "Executed Time: " . $current_time . "\n"
            . "Type: " . $type . "\n"
            . "XSS Script: \n" . $attempt_script;

    // Specify directory
    $log_directory = '/Users/earth/Desktop/xss/XSS-Detection-System/logs/';
    // Create a unique log file name using the user_id and timestamp
    $log_file = $log_directory . 'log_' . date('YmdHis') . '.log';
    // Open the log file for appending
    $fp = fopen($log_file, 'w');
    if ($fp) {
        fwrite($fp, $log_message);
        fclose($fp);
    } else {
        // Handle errors if the log file couldn't be opened
        echo "Error: Unable to write to the log file.";
    }
}
function Send_Notification($admin, $user_info, $input_str)
{
    return TRUE;
}
