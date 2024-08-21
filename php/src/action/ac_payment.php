<?php
session_start();
include "../connect.php";

if (isset($_REQUEST["ac"])) {
    switch ($_REQUEST["ac"]) {
        case "addTransportNumber":
            $query =
                "UPDATE tb_payment SET transport_number = '" .
                $_REQUEST["transport_number"] .
                "'
                WHERE tb_payment.payment_id = '" .
                $_REQUEST["paymentId"] .
                "'
                ";
            $updateTransportNumber = $conn->query($query);

            if ($updateTransportNumber) {
                $data = [
                    "status" => true,
                    "message" => "เพิ่มรหัสพัสดุสำเร็จ!",
                ];
            } else {
                $data = ["status" => false, "message" => $conn->error];
            }

            echo json_encode($data);
            break;
        case "addPayment":
            $productIds = $_REQUEST["productId"];
            $productAmount = $_REQUEST["productAmount"];
            $total = $_REQUEST["total"];
            $userId = $_REQUEST["userId"];
            $status = 0;

            // check amount have in product
            foreach ($productIds as $key => $productId) {
                $haveAmount = $conn->query(
                    "SELECT * FROM tb_products WHERE product_id = '" .
                        (int) $productId .
                        "' AND product_amount >= '" .
                        (int) $productAmount[$key] .
                        "'"
                );
                if ($haveAmount->num_rows == 0) {
                    $status += 1;
                }
            }

            if ($status != 0) {
                $data = [
                    "status" => false,
                    "message" => "จำนวนสินค้าในคลังไม่เพียงพอ!",
                ];
            } else {
                $sql = $conn->query(
                    "INSERT INTO tb_payment (user_id,payment_total,payment_create_at,tp_id,transport_number)
                VALUE ('" .
                        $userId .
                        "','" .
                        $total .
                        "',NOW(),'" .
                        $_REQUEST["tpId"] .
                        "','')"
                );

                $lastInsertedId = $conn->insert_id;

                foreach ($productIds as $key => $productId) {
                    $sql = $conn->query(
                        "INSERT INTO tb_order (payment_id,product_id,order_amount)
                    VALUE ('" .
                            $lastInsertedId .
                            "','" .
                            (int) $productId .
                            "','" .
                            (int) $productAmount[$key] .
                            "')"
                    );

                    $sql = $conn->query(
                        "UPDATE tb_products SET product_amount = product_amount - '" .
                            (int) $productAmount[$key] .
                            "' WHERE product_id = '" .
                            (int) $productId .
                            "'"
                    );
                }

                $userBy = $conn
                    ->query(
                        "SELECT CONCAT(user_fname, ' ', user_lname) AS full_name FROM tb_user WHERE user_id = '" .
                            $userId .
                            "'"
                    )
                    ->fetch_object();

                $sql = $conn->query(
                    "INSERT INTO tb_log (log_user_by,log_action_type,log_action_detail,log_ip,log_create_at)
                VALUE ('" .
                        $userBy->full_name .
                        "','เพิ่มยอดขายจำนวนเงิน ','" .
                        $total .
                        " บาท" .
                        "','" .
                        getenv("REMOTE_ADDR") .
                        "',NOW())"
                );

                $data = ["status" => true, "message" => "เพิ่มยอดขายสำเร็จ!"];
            }

            echo json_encode($data);
            break;

        case "getOrder":
            $orders = $conn->query(
                "SELECT * FROM tb_order o
            LEFT JOIN tb_products p ON o.product_id = p.product_id
            WHERE o.payment_id = '" .
                    (int) $_REQUEST["paymentId"] .
                    "'"
            );
            $order = [];
            while ($orderData = $orders->fetch_object()) {
                $order[] = $orderData;
            }

            $tpDetail = $conn
                ->query(
                    "
            SELECT tp.tp_name,p.transport_number FROM tb_payment p
            LEFT JOIN tb_transport tp ON tp.tp_id = p.tp_id
           WHERE p.payment_id =  '" .
                        (int) $_REQUEST["paymentId"] .
                        "'"
                )
                ->fetch_object();

            $data = [
                "status" => true,
                "data" => $order,
                "tpName" => $tpDetail->tp_name,
                "tpNumber" => $tpDetail->transport_number,
            ];

            echo json_encode($data);
            break;

        case "deletePayment":
            $orders = $conn->query(
                "SELECT * FROM tb_order WHERE payment_id = '" .
                    $_REQUEST["paymentId"] .
                    "'"
            );
            while ($order = $orders->fetch_object()) {
                $updateProduct = $conn->query(
                    "UPDATE tb_products SET product_amount = product_amount + '" .
                        $order->order_amount .
                        "' WHERE product_id = '" .
                        $order->product_id .
                        "'"
                );
            }
            $paymentOld = $conn
                ->query(
                    "SELECT payment_total FROM tb_payment WHERE payment_id ='" .
                        $_REQUEST["paymentId"] .
                        "'"
                )
                ->fetch_object();
            $sql = $conn->query(
                "DELETE FROM tb_payment WHERE payment_id ='" .
                    $_REQUEST["paymentId"] .
                    "'"
            );

            if ($sql) {
                $userBy = $conn
                    ->query(
                        "SELECT CONCAT(user_fname, ' ', user_lname) AS full_name FROM tb_user WHERE user_id = '" .
                            $_REQUEST["userBy"] .
                            "'"
                    )
                    ->fetch_object();

                $sql = $conn->query(
                    "INSERT INTO tb_log (log_user_by,log_action_type,log_action_detail,log_ip,log_create_at)
                VALUE ('" .
                        $userBy->full_name .
                        "','ลบยอดขายจำนวนเงิน ','" .
                        $paymentOld->payment_total .
                        " บาท" .
                        "','" .
                        getenv("REMOTE_ADDR") .
                        "',NOW())"
                );

                $data = ["status" => true, "message" => "ลบการยอดขายสำเร็จ!"];
            } else {
                $data = ["status" => false, "message" => $conn->error];
            }

            echo json_encode($data);
            break;
    }
}
