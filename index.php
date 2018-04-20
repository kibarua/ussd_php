<?php

// Reads the variables sent via POST from our gateway
$sessionId   = $_POST["sessionId"];
$serviceCode = $_POST["serviceCode"];
$phoneNumber = $_POST["phoneNumber"];
$text        = $_POST["text"];

if ( $text == "" ) {

	 // This is the first request. Note how we start the response with CON
	 $response  = "CON What service do you want? \n";
	 $response .= "1. Plumbing \n";
	 $response .= "2. Carpentry \n";
	 $response .= "3. Cleaning services \n";
	 $response .= "4. Electrician \n";
	 $response .= "5. Gardening \n";
	 $response .= "7. Painting \n";
	 $response .= "8. Metal work \n";
	 $response .= "9. Other \n";

}else if ( $text == "1" ) {
  // Business logic for first level response
  $response = "CON Choose account information you want to view \n";
  $response .= "1. Account number \n";
  $response .= "2. Account balance";
  
}else if($text == "9") {
 
  // Business logic for first level response

  // This is a terminal request. Note how we start the response with END
  $response = "CON Kindly enter the service you want us to add.";
 
}else if(preg_match("%^9*[a-zA-Z]+%i", $text)) {
 
  // Business logic for first level response

  // This is a terminal request. Note how we start the response with END
  $response = "CON Thank you for you recommendation: "
  $response .= $text;
 
}else if($text == "1*1") {
 
  // This is a second level response where the user selected 1 in the first instance
  $accountNumber  = "ACC1001";
  // This is a terminal request. Note how we start the response with END
  $response = "END Your account number is $accountNumber";
 
}else if ( $text == "1*2" ) {
  
	 // This is a second level response where the user selected 1 in the first instance
	 $balance  = "NGN 10,000";
	 // This is a terminal request. Note how we start the response with END
	 $response = "END Your balance is $balance";

}

// Print the response onto the page so that our gateway can read it
header('Content-type: text/plain');
echo $response;

// DONE!!!
?>
