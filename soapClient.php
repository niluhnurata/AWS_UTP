<?php
// URL of the WSDL file
$wsdl = "http://localhost/soapAPI_saving/server.php?wsdl";

// Create a new SOAP client
try {
    $client = new SoapClient($wsdl, array('trace' => 1, 'exceptions' => true));

    $buyTicketRequest = new stdClass();

    try {
        $response = $client->__soapCall("buyTicket", array($buyTicketRequest));
        echo "Response from buyTicket:\n";
        var_dump($response);
    } catch (SoapFault $e) {
        echo "Error during buyTicket operation: " . $e->getMessage();
    }

    $createTicketRequest = new stdClass();
    $createTicketRequest->ticketType = "VIP"; 

    try {
        $response = $client->__soapCall("createTicket", array($createTicketRequest));
        echo "Response from createTicket:\n";
        var_dump($response);
    } catch (SoapFault $e) {
        echo "Error during createTicket operation: " . $e->getMessage();
    }

} catch (SoapFault $e) {
    echo "SOAP Client Error: " . $e->getMessage();
}
?>