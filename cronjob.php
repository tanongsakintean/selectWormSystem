<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "DB_SELECT_WORM";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


function sendLineNotifyMessage($accessToken, $message)
{
    $apiUrl = 'https://notify-api.line.me/api/notify';

    $headers = [
        'Content-Type: application/x-www-form-urlencoded',
        'Authorization: Bearer ' . $accessToken,
    ];

    $data = [
        'message' => $message,
    ];

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    if ($response === FALSE) {
        return false; // Error occurred while sending Line Notify message
    } else {
        return true; // Line Notify message sent successfully
    }
}


$token = "Tm5GMmaryIujAaYhAGNwE4qvA1OQhUZXf0MsLtwL2L7";
$sql = $conn->query("SELECT stock_id,stock_name, DATE(stock_start) AS start, DATE(stock_end) AS end
FROM tb_stock
WHERE stock_status = 1
  AND DATE(stock_start) = DATE(stock_end);
");

$updateStock = $conn->query("UPDATE tb_stock
SET stock_start = DATE_ADD(stock_start, INTERVAL 1 DAY);
WHERE stock_status = 1
");
if ($sql->num_rows) {
    while ($stock = $sql->fetch_object()) {
        $stockUpdate = $conn->query("UPDATE tb_stock SET stock_status = 2 WHERE stock_id = '" . $stock->stock_id . "'");
        $message = "โซน " . $stock->stock_name . " ผลิตสำเร็จ!";
        ///notify
        sendLineNotifyMessage($token, $message);
    }
}

$productAmount = 100;
$sql = $conn->query("SELECT * FROM tb_products WHERE product_status = 1 AND product_amount < '" . $productAmount . "'");
if ($sql->num_rows) {
    while ($product = $sql->fetch_object()) {
        ///notify
        $message = "สินค้า " . $product->product_name . " สินค้าใกล้จะหมด! เหลือ " . $product->product_amount;
        sendLineNotifyMessage($token, $message);
    }
}
