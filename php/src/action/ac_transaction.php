<?php
session_start();
include "../connect.php";

if (isset($_REQUEST["ac"])) {
    switch ($_REQUEST["ac"]) {
        case "addTransaction":
            $sql = $conn->query(
                "INSERT INTO tb_transactions (category_id,amount,description,transaction_date,created_at)
                    VALUES ('" .
                    $_REQUEST["category"] .
                    "','" .
                    $_REQUEST["amount"] .
                    "','" .
                    $_REQUEST["description"] .
                    "','" .
                    $_REQUEST["transactionDate"] .
                    "',
                        NOW()) "
            );
            if ($sql) {
                $data = [
                    "status" => true,
                    "message" => "เพิ่มรายรับรายจ่ายเข้าระบบสำเร็จ!",
                ];

                $userBy = $conn
                    ->query(
                        "SELECT CONCAT(user_fname, ' ', user_lname) AS full_name FROM tb_user WHERE user_id = '" .
                            $_REQUEST["userBy"] .
                            "'"
                    )
                    ->fetch_object();
                $sql = $conn->query(
                    "INSERT INTO tb_log (log_user_by,log_action_type,log_action_detail,log_ip,log_create_at)
                        VALUES ('" .
                        $userBy->full_name .
                        "','เพิ่มรายรับรายจ่าย','" .
                        $_REQUEST["categoryName"] .
                        " " .
                        $_REQUEST["amount"] .
                        "เข้าระบบ" .
                        "','" .
                        getenv("REMOTE_ADDR") .
                        "',NOW())"
                );

                $data = [
                    "status" => true,
                    "message" => "เพิ่มรายรับรายจ่ายเข้าระบบสำเร็จ!",
                    "result" => $conn->error,
                ];
            } else {
                $data = ["status" => false, "message" => $conn->error];
            }

            echo json_encode($data);
            break;
        case "editTransaction":
            $sql = $conn->query(
                "UPDATE tb_transactions SET
                category_id = '" .
                    $_REQUEST["category"] .
                    "',
                amount = '" .
                    $_REQUEST["amount"] .
                    "',
                description = '" .
                    $_REQUEST["description"] .
                    "',
                transaction_date = '" .
                    $_REQUEST["transactionDate"] .
                    "'
                    WHERE transaction_id = '" .
                    $_REQUEST["transactionId"] .
                    "' "
            );

            if ($sql) {
                $data = [
                    "status" => true,
                    "message" => "แก้ไขรายรับรายจ่ายสำเร็จ!",
                ];

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
                        "','แก้ไขรายรับรายจ่าย ','" .
                        $_REQUEST["categoryName"] .
                        " " .
                        $_REQUEST["amount"] .
                        "','" .
                        getenv("REMOTE_ADDR") .
                        "',NOW())"
                );
            } else {
                $data = ["status" => false, "message" => $conn->error];
            }
            echo json_encode($data);
            break;
        case "deleteTransaction":
            $transactionOld = $conn
                ->query(
                    "SELECT amount,description FROM tb_transactions WHERE transaction_id = '" .
                        $_REQUEST["transactionId"] .
                        "'"
                )
                ->fetch_object();
            $sql = $conn->query(
                "DELETE FROM tb_transactions WHERE transaction_id = '" .
                    $_REQUEST["transactionId"] .
                    "' "
            );

            if ($sql) {
                $data = [
                    "status" => true,
                    "message" => "ลบรายรับรายจ่ายสำเร็จ!",
                ];

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
                        "','ลบรายรับรายจ่าย','" .
                        $transactionOld->description .
                        $transactionOld->amount .
                        " ออกจากระบบ" .
                        "','" .
                        getenv("REMOTE_ADDR") .
                        "',NOW())"
                );
            } else {
                $data = ["status" => false, "message" => $conn->error];
            }
            echo json_encode($data);
            break;
        case "getCategories":
            $sql = "SELECT * FROM tb_transport";
            $dataQuery = $conn->query($sql);
            $data = [];

            if ($dataQuery) {
                $transportData = [];
                while ($transport = $dataQuery->fetch_object()) {
                    $transportData[] = $transport;
                }

                $data = ["status" => true, "data" => $transportData];
            } else {
                $data = ["status" => false, "data" => []];
            }

            echo json_encode($data);
            break;
    }
}
