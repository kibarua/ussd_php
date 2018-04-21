<?php

// Reads the variables sent via POST from our gateway
$sessionId   = $_POST["sessionId"];
$serviceCode = $_POST["serviceCode"];
$phoneNumber = $_POST["phoneNumber"];
$text        = $_POST["text"];


///////////////////////////////////////////////////


$locations_array = ["Westlands", "Dagoretti", "Embakasi", "Kasarani", "Starehe", "Makadara", "Kamukunji", "Mathare"];


$digits = 6;
$national_id = (string) rand(pow(10, $digits-1), pow(10, $digits)-1);
$phone = (string) $phoneNumber;

function addContractor($name, $location, $service_id, $phone, $nat_id) {
  $regData = array(
    "name" => $name,
    "location" => $location,
    "service" => $service_id,
    "phone" => $phone,
    "national_id" => $nat_id
  );

  $jsonStrReg = json_encode($regData);
  //$httpStrReg = http_build_query($regData);

  $ch = curl_init('http://warukira.pythonanywhere.com/api/add_client');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonStrReg);

  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json' 
  ));

  $response_api_one = curl_exec($ch);
  
  $response_api_one = json_decode($response_api_one);
  
  curl_close($ch);
  
  return $response_api_one;
  
}


function addTask($phone, $location, $service_id){
  $rgData = array(
    "phone" => $phone,
    "location" => $location,
    "service_id" => $service_id
  );

  $jsnStrReg = json_encode($rgData);
  //$httpStrReg = http_build_query($regData);

  $chi = curl_init('http://warukira.pythonanywhere.com/api/add_task');
  curl_setopt($chi, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($chi, CURLOPT_POST, true);
  curl_setopt($chi, CURLOPT_POSTFIELDS, $jsnStrReg);

  curl_setopt($chi, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json' 
  ));

  $api_response = curl_exec($chi);
  
  $api_response = json_decode($api_response);
  
  curl_close($chi);
  
  return $api_response;

}

//////////////////////////////////////////////////////


if ( $text == "" ) {

	 // This is the first request. Note how we start the response with CON
	 $response  = "CON Welcome to Kibarua \n";
	 $response .= "1. Client \n";
	 $response .= "2. Contractor \n";

   //first level



}else if ( $text == "1" ) {


  $response = "CON Select a task \n";
  $response .= "1. Request service \n";
  $response .= "2. Pay for service \n";
  
}else if($text == "2") {
 
  $response = "CON Select a task \n";
  $response .= "1. Register \n";
  $response .= "2. Confirm task completion \n";


  //second level

 
}else if( $text == "1*1" ) {
 
  $response = "CON Select a service \n";
  $response .= "1. Plumbing \n";
  $response .= "2. Carpentry \n";
  $response .= "3. Electrician \n";
  $response .= "4. Gardening \n";
  $response .= "5. Painting \n";
  $response .= "6. Masonry \n";
  $response .= "7. Glass work \n";
  $response .= "8. Cleaning services \n";
 
}else if( $text == "1*2" ) {

  $response = "CON Enter Task ID \n";

}else if( $text == "2*1" ) {
 
  // This is a secondlevel response where the user selected 1 in the first instance
  $response = "CON Enter your name: \n";
 
}else if ( $text == "2*2" ) {

  $response = "CON Enter Task ID \n";


//third level


}else if ( preg_match("/^1\*1\*[1-8]$/", $text) ) {

  $response = "CON Pick a location: \n";
  $response .= "1. Westlands \n";
  $response .= "2. Dagoretti \n";
  $response .= "3. Embakasi \n";
  $response .= "4. Kasarani \n";
  $response .= "5. Starehe \n";
  $response .= "6. Makadara \n";
  $response .= "7. Kamukunji \n";
  $response .= "8. Mathare \n";


}else if ( preg_match("/^1\*2\*\d+$/", $text) ) {

  $response = "CON Enter 1 to confirm \n";


}else if ( preg_match("/^2\*1\*[a-zA-Z]+$/", $text) ) {

  $response = "CON Pick a location: \n";
  $response .= "1. Westlands \n";
  $response .= "2. Dagoretti \n";
  $response .= "3. Embakasi \n";
  $response .= "4. Kasarani \n";
  $response .= "5. Starehe \n";
  $response .= "6. Makadara \n";
  $response .= "7. Kamukunji \n";
  $response .= "8. Mathare \n";

}else if ( preg_match("/^2\*2\*\d+$/", $text) ) {

  $response = "CON Enter 1 to confirm \n";


//fourth level


}else if ( preg_match("/^1\*1\*[1-8]\*[1-8]$/", $text) ) {

  $texplode = explode('*',$text);
  $location_pos = $texplode[3];
  $location = $locations_array[$location_pos - 1];

  $service_id = (int) $texplode[2]; 


  addTask($phone, $location, $service_id);

  $response = "CON Enter 1 to confirm \n";


}else if ( preg_match("/^1\*2\*\d+\*1$/", $text) ) {

  $response = "END The payment has been confirmed. Thank you for using Kibarua.\n";

}else if ( preg_match("/^2\*1\*[a-zA-Z]+\*[1-8]$/", $text) ) {

  $response = "CON Select a service \n";
  $response .= "1. Plumbing \n";
  $response .= "2. Carpentry \n";
  $response .= "3. Electrician \n";
  $response .= "4. Gardening \n";
  $response .= "5. Painting \n";
  $response .= "6. Masonry \n";
  $response .= "7. Glass work \n";
  $response .= "8. Cleaning services \n";

}else if ( preg_match("/^2\*2\*\d+\*1$/", $text) ) {

  $response = "END The task has been marked as completed. Thank you for using Kibarua.\n";


//fifth level


}else if ( preg_match("/^1\*1\*[1-8]\*[1-8]\*1$/", $text) ) {

  $response = "END The task has been successfully been requested. We will send you confirmation details via SMS. \n";

}else if ( preg_match("/^2\*1\*[a-zA-Z]+\*[1-8]\*[1-8]$/", $text) ) {

  $response = "CON Enter 1 to confirm \n";


//sixth level


}else if ( preg_match("/^2\*1\*[a-zA-Z]+\*[1-8]\*[1-8]\*1$/", $text) ) {

  $texplode = explode('*',$text);

  $name = $texplode[2];

  $location_pos = $texplode[3];
  $location = $locations_array[$location_pos - 1];

  $service = $texplode[4];


  $response = "END Thank you for registering. We will reach out to you $name. \n";
  addContractor($name, $location, $service, $phone, $national_id);

} else {
  $response = "END An error occurred. Please try again later.";
}

// Print the response onto the page so that our gateway can read it
header('Content-type: text/plain');
echo $response;

// DONE!!!
?>
