<?php
session_start();
include("../connect.php");

if (isset($_REQUEST['ac'])) {
    switch ($_REQUEST['ac']) {

        case "getPaymentYear":
            $sql = $conn->query("SELECT 
            MONTH(payment_create_at) AS payment_month,
            SUM(payment_total) AS total_payment
        FROM 
            tb_payment
        GROUP BY 
            payment_month");

            if ($sql) {
                $paymentData = [];
                while ($payment = $sql->fetch_object()) {
                    $paymentData[] = $payment;
                }
                $data = array("status" => true, "data" => $paymentData);
            } else {
                $data = array("status" => false, "data" => []);
            }

            echo json_encode($data);
            break;

        case "getPaymentToDay":
            $sql = $conn->query("SELECT 
                DAY(payment_create_at) AS payment_day,
                SUM(payment_total) AS total_payment
            FROM 
                tb_payment
            WHERE 
                DATE(payment_create_at) = CURDATE()
            GROUP BY 
                payment_day");

            if ($sql) {
                $paymentData = [];
                while ($payment = $sql->fetch_object()) {
                    $paymentData[] = $payment;
                }
                $data = array("status" => true, "data" => $paymentData);
            } else {
                $data = array("status" => false, "data" => []);
            }

            echo json_encode($data);
            break;
        case "getPaymentMonth":
            $sql = $conn->query("SELECT 
                    DAY(payment_create_at) AS payment_day,
                    SUM(payment_total) AS total_payment
                FROM 
                    tb_payment
                GROUP BY 
                    payment_day");

            if ($sql) {
                $paymentData = [];
                while ($payment = $sql->fetch_object()) {
                    $paymentData[] = $payment;
                }
                $data = array("status" => true, "data" => $paymentData);
            } else {
                $data = array("status" => false, "data" => []);
            }

            echo json_encode($data);
            break;

        case "getProductTotal":
            $sql = $conn->query("SELECT 
                    SUM(product_amount) AS total_product
                FROM 
                    tb_products
                WHERE 
                    product_status = 1 ");

            if ($sql) {
                $productData = [];
                while ($product = $sql->fetch_object()) {
                    $productData[] = $product;
                }
                $data = array("status" => true, "data" => $productData);
            } else {
                $data = array("status" => false, "data" => []);
            }

            echo json_encode($data);
            break;

        case "getUserTotal":
            $sql = $conn->query("SELECT user_id 
                 FROM 
                    tb_user
                WHERE 
                    user_status = 1 AND user_role = 1");

            if ($sql) {
                $data = array("status" => true, "data" => $sql->num_rows);
            } else {
                $data = array("status" => false, "data" => 0);
            }

            echo json_encode($data);
            break;
        case "getZoneTotal":
            $sql = $conn->query("SELECT stock_id 
                     FROM 
                        tb_stock
                    WHERE 
                        stock_status = 1");

            if ($sql) {
                $data = array("status" => true, "data" => $sql->num_rows);
            } else {
                $data = array("status" => false, "data" => 0);
            }

            echo json_encode($data);
            break;

        case "getStockMonth":
            $sql = $conn->query("SELECT stock_name AS stockName, 
                COUNT(*) AS stockTotal
                FROM tb_stock
                WHERE stock_status = 0
                GROUP BY stock_name");

            if ($sql) {
                $stockData = [];
                while ($stock = $sql->fetch_object()) {
                    $stockData[] = $stock;
                }
                $data = array("status" => true, "data" => $stockData);
            } else {
                $data = array("status" => false, "data" => []);
            }

            echo json_encode($data);
            break;
    }
}
