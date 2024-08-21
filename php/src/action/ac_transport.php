<?php
session_start();
include "../connect.php";

if (isset($_REQUEST["ac"])) {
    switch ($_REQUEST["ac"]) {
        case "addTransport":
            $sql = $conn->query(
                "SELECT * FROM tb_transport WHERE tp_name = '" .
                    $_REQUEST["tpName"] .
                    "'   "
            );
            $num = $sql->num_rows;
            if ($num > 0) {
                $data = ["status" => false, "message" => "ชื่อขนส่งซ้ำ ซ้ำ!"];
            } else {
                $sql = $conn->query(
                    "INSERT INTO tb_transport (tp_name,tp_status,tp_created)
                    VALUES ('" .
                        $_REQUEST["tpName"] .
                        "',1,NOW()) "
                );
                if ($sql) {
                    $data = [
                        "status" => true,
                        "message" => "เพิ่มขนส่งเข้าระบบสำเร็จ!",
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
                            "','เพิ่มขนส่ง','" .
                            $_REQUEST["tpName"] .
                            "เข้าระบบ" .
                            "','" .
                            getenv("REMOTE_ADDR") .
                            "',NOW())"
                    );
                } else {
                    $data = ["status" => false, "message" => $conn->error];
                }
            }

            echo json_encode($data);
            break;
        case "editTransport":
            $sql = $conn->query(
                "UPDATE tb_transport SET tp_name = '" .
                    $_REQUEST["tpName"] .
                    "' WHERE tp_id = '" .
                    $_REQUEST["tpId"] .
                    "' "
            );

            if ($sql) {
                $data = [
                    "status" => true,
                    "message" => "แก้ไขขนส่งสำเร็จ!",
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
                        "','แก้ไขข้อมูลขนส่ง','" .
                        $_REQUEST["tpName"] .
                        "','" .
                        getenv("REMOTE_ADDR") .
                        "',NOW())"
                );
            } else {
                $data = ["status" => false, "message" => $conn->error];
            }
            echo json_encode($data);
            break;
        case "deleteTransport":
            $transportOld = $conn
                ->query(
                    "SELECT tp_name  FROM tb_transport WHERE tp_id = '" .
                        $_REQUEST["tpId"] .
                        "'"
                )
                ->fetch_object();
            $sql = $conn->query(
                "DELETE FROM tb_transport WHERE tp_id = '" .
                    $_REQUEST["tpId"] .
                    "' "
            );

            if ($sql) {
                $data = ["status" => true, "message" => "ลบขนส่งสำเร็จ!"];

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
                        "','ลบขนส่ง','" .
                        $transportOld->tp_name .
                        "ออกจากระบบ" .
                        "','" .
                        getenv("REMOTE_ADDR") .
                        "',NOW())"
                );
            } else {
                $data = ["status" => false, "message" => $conn->error];
            }
            echo json_encode($data);
            break;
        case "getTransport":
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
