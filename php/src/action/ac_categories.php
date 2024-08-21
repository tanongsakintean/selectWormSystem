<?php
session_start();
include "../connect.php";

if (isset($_REQUEST["ac"])) {
    switch ($_REQUEST["ac"]) {
        case "addCategories":
            $sql = $conn->query(
                "SELECT * FROM tb_categories WHERE name = '" .
                    $_REQUEST["name"] .
                    "'"
            );
            $num = $sql->num_rows;
            if ($num > 0) {
                $data = ["status" => false, "message" => "ชื่อหมวดหมู่ซ้ำ!"];
            } else {
                $sql = $conn->query(
                    "INSERT INTO tb_categories (name,type,created_at)
                    VALUES ('" .
                        $_REQUEST["name"] .
                        "','" .
                        $_REQUEST["type"] .
                        "',NOW()) "
                );
                if ($sql) {
                    $data = [
                        "status" => true,
                        "message" => "เพิ่มหมวดหมู่เข้าระบบสำเร็จ!",
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
                            "','เพิ่มหมวดหมู่','" .
                            $_REQUEST["name"] .
                            " " .
                            $_REQUEST["type"] .
                            "'.'เข้าระบบ','" .
                            getenv("REMOTE_ADDR") .
                            "',NOW())"
                    );
                } else {
                    $data = ["status" => false, "message" => $conn->error];
                }
            }

            echo json_encode($data);
            break;
        case "edtiCategories":
            $sql = $conn->query(
                "UPDATE tb_categories SET
                type = '" .
                    $_REQUEST["type"] .
                    "',
                name = '" .
                    $_REQUEST["name"] .
                    "' WHERE category_id = '" .
                    $_REQUEST["categoryId"] .
                    "' "
            );

            if ($sql) {
                $data = [
                    "status" => true,
                    "message" => "แก้ไขหมวดหมู่สำเร็จ!",
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
                        "','แก้ไขข้อมูลหมวดหมู่','" .
                        $_REQUEST["name"] .
                        " " .
                        $_REQUEST["type"] .
                        "','" .
                        getenv("REMOTE_ADDR") .
                        "',NOW())"
                );
            } else {
                $data = ["status" => false, "message" => $conn->error];
            }
            echo json_encode($data);
            break;
        case "deleteCategories":
            $categoriesOld = $conn
                ->query(
                    "SELECT type, name FROM tb_categories WHERE category_id = '" .
                        $_REQUEST["categoryId"] .
                        "'"
                )
                ->fetch_object();
            $sql = $conn->query(
                "DELETE FROM tb_categories WHERE category_id = '" .
                    $_REQUEST["categoryId"] .
                    "' "
            );

            if ($sql) {
                $data = ["status" => true, "message" => "ลบหมวดหมู่สำเร็จ!"];

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
                        "','ลบหมวดหมู่','" .
                        $categoriesOld->name .
                        $categoriesOld->type .
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
