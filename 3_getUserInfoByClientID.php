<?php

echo "Please enter client ID to view their first name, last name, email, and phone number..." . "\xA";
    
$IDInput = chop(fgets(STDIN));

$url = 'http://tsalameh512.api-us1.com';
$params = array(
  // the API Key can be found on the "Your Settings" page under the "API" tab.
  // replace this with your API Key
  'api_key' => '8b4b123f64f76e65178619943b008509523c723b6e099df8b707ae7381e8a341cbfb8625',
  'api_action' => 'contact_list',
  'api_output' => 'json',
  'ids' => $IDInput, //ID of client you want info of
  'full' => 1, //Do not change or you will lose phone number values
);

// This section takes the input fields and converts them to the proper format
$query = "";
foreach( $params as $key => $value ) $query .= urlencode($key) . '=' . urlencode($value) . '&';
$query = rtrim($query, '& ');

// clean up the url
$url = rtrim($url, '/ ');

// This sample code uses the CURL library for php to establish a connection,
// submit your request, and show (print out) the response.
if ( !function_exists('curl_init') ) die('CURL not supported. (introduced in PHP 4.0.2)');

// If JSON is used, check if json_decode is present (PHP 5.2.0+)
if ( $params['api_output'] == 'json' && !function_exists('json_decode') ) {
    die('JSON not supported. (introduced in PHP 5.2.0)');
}
    
// define a final API request - GET
$api = $url . '/admin/api.php?' . $query;

// Uncomment for Debugging ( Shows full URL + API on console)
    // echo $api;
$request = curl_init($api); // initiate curl object
curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);

$response = (string)curl_exec($request); // execute curl fetch and store results in $response

curl_close($request); // close curl object

$ACArray = json_decode($response, true);
    echo "Last Name: ";
    echo $ACArray[0]['last_name'];
    echo "\xA" . "First Name: " ;
    echo $ACArray[0]['first_name'];
    echo "\xA" . "Email Address: ";
    echo $ACArray[0]['email'];
    echo "\xA" . "Phone Number: ";
    echo $ACArray[0]['phone'];
    echo "\xA";
