<?php
    $admin = '';

    // Check if the submitted request is GET or POST
    if ($_SERVER['REQUEST_METHOD'] == 'GET' || 'POST'){
        if ($_SERVER['REQUEST_METHOD'] == 'GET'){
            // Acquire input from GET
            $input = $_GET['input'];
        }
        else{
             // Acquire input from POST
            $input = $_POST['input'];
        }

        if(PreProcess($input_str)){
            if(CheckRuleBased($input_str)){
                if(CheckModel($input_str)){
                }
                Block_and_Log($user_info, $input_str);
                Send_Notification($admin, $user_info, $input_str);
            }
            Block_and_Log($user_info, $input_str);
            Send_Notification($admin, $user_info, $input_str);
        }
        Block_and_Log($user_info, $input_str);
        Send_Notification($admin, $user_info, $input_str);
    }


    // $malicious = FALSE;

	function preProcess($input){
		// Remove spaces, tabs, and line breaks
		$output = str_replace(array(' ', "\t", "\n", "\r"), '', $input);
		// Convert to lowercase
    	$output = strtolower($output);
		// Replace ' with "
		$output = str_replace("'", '"', $output);
		return $output;
	}

	function CheckRuleBased($input) {
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



    function CheckModel($input){
        return TRUE;
    }
    function WriteLog($input){
        
        return TRUE;
    }
    function Send_Notification($admin, $user_info, $input_str){
        return TRUE;
    }
?>
