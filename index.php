<?php
session_start();

// Periksa apakah sesi valid
if (!isset($_SESSION['is_valid']) || $_SESSION['is_valid'] !== true) {
    header("Location: keamanan.php"); // Redirect ke halaman keamanan
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SOAP Client</title>
  </head>
  <body>
    <h1>SOAP Service Client</h1>

    <button onclick="callBuyTicket()">Buy Ticket</button>
    <button onclick="callCreateTicket()">Create Ticket</button>

    <div id="response"></div>

    <script>
      function parseXMLResponse(xml) {
        var parser = new DOMParser();
        var xmlDoc = parser.parseFromString(xml, "text/xml");

        var responseText = "";

        // Handle createTicketResponse
        var createTicketResponse = xmlDoc.getElementsByTagName("ns1:createTicketResponse");
        if (createTicketResponse.length > 0) {
          var ticketId = createTicketResponse[0].getElementsByTagName("ticketId")[0]?.textContent || "N/A";
          var ticketStatus = createTicketResponse[0].getElementsByTagName("ticketStatus")[0]?.textContent || "N/A";
          responseText += `Ticket Created!<br/>ID: ${ticketId}<br/>Status: ${ticketStatus}<br/>`;
        }

        // Handle buyTicketResponse
        var buyTicketResponse = xmlDoc.getElementsByTagName("ns1:buyTicketResponse");
        if (buyTicketResponse.length > 0) {
          var success = buyTicketResponse[0].getElementsByTagName("success")[0]?.textContent || "N/A";
          var message = buyTicketResponse[0].getElementsByTagName("message")[0]?.textContent || "N/A";
          var ticket = buyTicketResponse[0].getElementsByTagName("ticket")[0]?.textContent || "N/A";
          var cashback = buyTicketResponse[0].getElementsByTagName("cashback")[0]?.textContent || "No Cashback";
          responseText += `Success: ${success}<br/>Message: ${message}<br/>Ticket: ${ticket}<br/>Cashback: ${cashback}<br/>`;
        }

        return responseText || "No valid response found.";
      }

      function callBuyTicket() {
        // Construct SOAP envelope for buyTicket
        var soapEnvelope = `
          <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                            xmlns:web="http://localhost/soapAPI_saving/server.php">
              <soapenv:Header/>
              <soapenv:Body>
                  <web:buyTicketRequest/>
              </soapenv:Body>
          </soapenv:Envelope>`;

        // Send HTTP POST request
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "http://localhost/soapAPI_saving/server.php", true);
        xhr.setRequestHeader("Content-Type", "text/xml");
        xhr.onreadystatechange = function () {
          if (xhr.readyState == 4 && xhr.status == 200) {
            var parsedResponse = parseXMLResponse(xhr.responseText);
            document.getElementById("response").innerHTML = parsedResponse;
          }
        };
        xhr.send(soapEnvelope);
      }

      function callCreateTicket() {
        var ticketType = "VIP"; // Example ticket type, can be dynamic

        // Construct SOAP envelope for createTicket
        var soapEnvelope = `
          <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                            xmlns:web="http://localhost/soapAPI_saving/server.php">
              <soapenv:Header/>
              <soapenv:Body>
                  <web:createTicketRequest>
                      <web:ticketType>${ticketType}</web:ticketType>
                  </web:createTicketRequest>
              </soapenv:Body>
          </soapenv:Envelope>`;

        // Send HTTP POST request
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "http://localhost/soapAPI_saving/server.php", true);
        xhr.setRequestHeader("Content-Type", "text/xml");
        xhr.onreadystatechange = function () {
          if (xhr.readyState == 4 && xhr.status == 200) {
            var parsedResponse = parseXMLResponse(xhr.responseText);
            document.getElementById("response").innerHTML = parsedResponse;
          }
        };
        xhr.send(soapEnvelope);
      }
    </script>
  </body>
</html>
