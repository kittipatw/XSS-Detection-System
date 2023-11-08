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

function CheckRuleBased($input) {
    // A list of potentially harmful JavaScript event attributes commonly used in XSS attacks.
    $dangerous_attributes = array(
        'onload', 'onunload', 'onclick', 'onerror', 'onmouseover', 'onfocus', 'onblur', 
        'onchange', 'onsubmit', 'onkeydown', 'onkeypress', 'onkeyup',
        'onmouseenter', 'onmouseleave', 'onmousedown', 'onmouseup', 'onmousemove',
        'ondrag', 'ondrop', 'onselect', 'onwheel', 'alert'
    );

    $patterns = array(
        // Detect <script> tags with content that's not just letters, numbers, or whitespace.
        // Example: <script>someCode();</script>
        '#<script[^>]*?>(.*[^a-zA-Z0-9\s].*)</script>#',
        
        // Detect <img> tags with a 'javascript:' pseudo-protocol or dangerous attributes.
        // Example: <img src="javascript:alert(1)">
        '#<img[^>]*?(javascript:|'.implode('|', $dangerous_attributes).')#',
        
        // Detect <iframe>, <object>, <embed>, and <applet> tags with a 'javascript:' or 'data:' pseudo-protocol or dangerous attributes.
        // Example: <iframe src="javascript:alert(1)">
        '#<(iframe|object|embed|applet)[^>]*?(javascript:|data:|'.implode('|', $dangerous_attributes).')#',
        
        // Detect <meta>, <link>, <base>, <form>, <input>, and <button> tags with dangerous attributes.
        // Example: <input onmouseover="alert(1)">
        '#<(meta|link|base|form|input|button)[^>]*?('.implode('|', $dangerous_attributes).')#',
        
        // Detect <svg> tags with a 'javascript:' pseudo-protocol or dangerous attributes.
        // Example: <svg onload="alert(1)">
        '#<svg[^>]*?(javascript:|'.implode('|', $dangerous_attributes).')#',
        
        // Detect 'data:' URIs followed by 'base64' which can contain encoded data for XSS.
        // Example: data:text/html;base64,PHNjcmlwdD5hbGVydCgxKTs8L3NjcmlwdD4=
        // seem to be not working
        '#data:[^"\']*?;base64[^"\']*#',
        
        // Detect 'javascript:' pseudo-protocol which can execute JS.
        // Example: javascript:alert(1)
        '#javascript:[^"\']*?#',
        
        // Detect 'vbscript:' pseudo-protocol which can execute VBScript (mostly for older versions of IE).
        // Example: vbscript:msgbox("Hello")
        '#vbscript:[^"\']*?#',

        // Detect <a>, <textarea>, <select>, and <div> tags with a 'javascript:' pseudo-protocol or dangerous attributes.
        '#<(a|textarea|select|div)[^>]*?(' . implode('|', $dangerous_attributes) . ')#'

    );

    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $input)) {
            return TRUE;
        }
    }
    return FALSE;
}

function CheckModel($input) {
    $url = 'http://localhost:8000/inference/';
    $body = array('input-text' => $input);

    $options = array(
        'http' => array(
            'header'  => "Content-Type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($body),
        ),
    );
    $context = stream_context_create($options);

    // Use the PHP 'file_get_contents' function to perform the POST request
    $response = file_get_contents($url, FALSE, $context);

    if ($response === FALSE) {
        echo "Request failed";
    }

    // Decode the JSON response into a PHP array
    $responseData = json_decode($response, TRUE);
    echo "<script>console.log(" . json_encode($responseData) . ");</script>";

    if($responseData['prediction'] == 1){
        return TRUE;
    }   
    else{
        return FALSE;
    }
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


function detectXSS($input) {
    // A list of potentially harmful attributes commonly used in XSS attacks.
    $dangerous_attributes = array(
        'onload', 'onunload', 'onclick', 'onerror', 'onmouseover', 'onfocus', 'onblur', 
        'onchange', 'onsubmit', 'onkeydown', 'onkeypress', 'onkeyup',
        'onmouseenter', 'onmouseleave', 'onmousedown', 'onmouseup', 'onmousemove',
        'ondrag', 'ondrop', 'onselect', 'onwheel', 'alert'
    );

    // Tags and protocols that can potentially be used in XSS attacks.
    $patterns = array(
        '#<script[^>]*?>.*?</script>#si',             // Scripts
        '#<img[^>]*?src\s*=\s*["\']?[^"\'>]*?["\']#si',  // Malicious images with potential JS payloads
        '#<iframe[^>]*?>.*?</iframe>#si',             // iframes can be used to embed malicious content
        '#<object[^>]*?>.*?</object>#si',             // objects can embed malicious content
        '#<embed[^>]*?>.*?</embed>#si',               // embed tags can embed malicious content
        '#<applet[^>]*?>.*?</applet>#si',             // applets can embed malicious Java
        '#<meta[^>]*?>#si',                           // meta tags can be used for charset-based attacks
        '#<link[^>]*?>#si',                           // potentially malicious stylesheet links
        '#<base[^>]*?>#si',                           // base tags can modify base URI
        '#<form[^>]*?>#si',                           // malicious forms
        '#<input[^>]*?>#si',                          // malicious input fields/tags
        '#<button[^>]*?>#si',                         // malicious buttons
        '#<svg[^>]*?>.*?</svg>#si',                   // SVGs can contain embedded JS
        '#data:[^"\']*?;base64[^"\']*#si',            // data URIs can be used for XSS
        '#javascript:[^"\']*?#si',                    // JS pseudo-protocol
        '#vbscript:[^"\']*?#si'                       // VBScript pseudo-protocol for IE
    );

    foreach ($dangerous_attributes as $attr) {
        $patterns[] = '#'.$attr.'\s*=\s*["\'][^"\']*?["\']#si';
    }

    // Check if any of the patterns match the input.
    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $input)) {
            return TRUE;
        }
    }

    return FALSE;
}



/*
CREATE .htaccess file under development directory with the following content:

Order Allow,Deny
Allow from all

*/ 
function BlockUser(){
    $htaccess_path = "/Users/earth/Desktop/xss/XSS-Detection-System/.htaccess"; // Update the path
    $block_string = "\nDeny from " . $_SERVER['REMOTE_ADDR'];
    file_put_contents($htaccess_path, $block_string, FILE_APPEND);
}


function Send_Notification($admin, $user_info, $input_str)
{
    return TRUE;
}


function checkPlainText($input) {
    $pattern = '/^[a-z0-9]*$/';
    if(preg_match($pattern, $input)){
        return TRUE;
    }
    else{
        return FALSE;
    }
}




// Archive ----------------------------------------------------------

function CheckRuleBased_old($input)
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


function CheckModel_GET($input) {
    // $url = 'http://localhost:8000/inference/?text="' . urlencode('"' . $input . '"');    
    // $url = 'http://localhost:8000/inference/?text=' . urlencode($input); 
    $url = 'http://localhost:8000/inference';
    // echo "<script>console.log(" . json_encode($url) . ");</script>";

    $body = '';

    // Use the PHP 'file_get_contents' function to perform the GET request
    $response = file_get_contents($url);
    // echo "<script>console.log(" . $response . ");</script>";
    // echo "<script>console.log(" . json_encode($response) . ");</script>";

    // Decode the JSON response into a PHP array
    $responseData = json_decode($response, TRUE);

    // Check if the response includes 'prediction' key
    if (array_key_exists('prediction', $responseData)) {
        // Return the prediction part of the response
        $class = $responseData['prediction'];
        if($class == 1){return TRUE;}
        else{return FALSE;}
    } else {
        // Return an error message or FALSE if the prediction key doesn't exist
        return "No prediction found in the response";
    }
}


function checkPlainText_old($input) {
    // check for < , >
    $containsLessThan = strpos($input, '<') !== FALSE;
    $containsGreaterThan = strpos($input, '>') !== FALSE;

    // if only one of them is found (+multiple times) OR not both
    if ($containsLessThan xor $containsGreaterThan || (!$containsLessThan && !$containsGreaterThan)){
        return TRUE;
    }
    else{
        return FALSE;
    }
}
?>