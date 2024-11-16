<?php

// Function to call the API
function callAPI($link, $quantity) {
    $apiKey = "f54c2517a0c675eee553a884237d1b6";
    $service = "1840";
    $url = "https://smmpanel.com/api/v2";

    // Prepare the API URL with parameters
    $fullUrl = $url . "?key=" . $apiKey . "&action=add&service=" . $service . "&link=" . urlencode($link) . "&quantity=" . $quantity;

    // Initialize cURL session
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $fullUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute cURL session and get response
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Close cURL session
    curl_close($ch);

    // Check HTTP status code
    if ($httpCode !== 200) {
        return json_encode(["status" => "failed", "message" => "HTTP error: " . $httpCode]);
    }

    // Decode JSON response
    $responseData = json_decode($response, true);

    // Check if "order" key exists in the response
    if (isset($responseData['order'])) {
        return json_encode(["status" => "success", "order_id" => $responseData['order']]);
    } else {
        return json_encode(["status" => "failed", "message" => "Order not found in response"]);
    }
}

// Example usage
$link = "https://example.com"; // Replace with your link
$quantity = 100; // Replace with your desired quantity
echo callAPI($link, $quantity);

?>
