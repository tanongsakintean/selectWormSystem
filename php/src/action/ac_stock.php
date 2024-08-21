<?php
session_start();
include("../connect.php");



if (isset($_REQUEST['ac'])) {

    switch ($_REQUEST['ac']) {
        case "addStock":
            // 0 => ว่าง
            // 1 => กำลังผลิต
            // 2 => ผลิตสำเร็จ

            if ($_REQUEST['stockStart'] > $_REQUEST['stockEnd']) {
                $data = array("status" => false, "message" => "โปรดเลือกวันที่ทำการผลิตให้ถูกต้อง!");
            } else {
                $sql = $conn->query("INSERT INTO tb_stock (stock_name,stock_start,stock_end,stock_status) 
                VALUE ('" . $_REQUEST['stockName'] . "','" . $_REQUEST['stockStart'] . "','" . $_REQUEST['stockEnd'] . "',1)");
                if ($sql) {
                    $userBy = $conn->query("SELECT CONCAT(user_fname, ' ', user_lname) AS full_name FROM tb_user WHERE user_id = '" . $_REQUEST['userBy'] . "'")->fetch_object();

                    $sql = $conn->query("INSERT INTO tb_log (log_user_by,log_action_type,log_action_detail,log_ip,log_create_at) 
                    VALUE ('" . $userBy->full_name . "','เพิ่มการผลิตในโซน ','" . $_REQUEST['stockName'] . ' สถานะกำลังผลิต' . "','" . getenv("REMOTE_ADDR") . "',NOW())");

                    $data = array("status" => true, "message" => "เพิ่มการผลิตสำเร็จ!");
                } else {
                    $data = array("status" => false, "message" => $conn->error);
                }
            }
            echo json_encode($data);
            break;

        case "editStock":
            if ($_REQUEST['stockStart'] > $_REQUEST['stockEnd']) {
                $data = array("status" => false, "message" => "โปรดเลือกวันที่ทำการผลิตให้ถูกต้อง!");
            } else {
                $sql = $conn->query("UPDATE tb_stock SET stock_name ='" . $_REQUEST['stockName'] . "', stock_start='" . $_REQUEST['stockStart'] . "', stock_end='" . $_REQUEST['stockEnd'] . "' WHERE stock_id = '" . $_REQUEST['stockId'] . "' AND stock_status != 0");
                if ($sql) {
                    $userBy = $conn->query("SELECT CONCAT(user_fname, ' ', user_lname) AS full_name FROM tb_user WHERE user_id = '" . $_REQUEST['userBy'] . "'")->fetch_object();

                    $sql = $conn->query("INSERT INTO tb_log (log_user_by,log_action_type,log_action_detail,log_ip,log_create_at) 
                    VALUE ('" . $userBy->full_name . "','แก้ไขข้อมูลการผลิตในโซน ','" . $_REQUEST['stockName'] . ' สถานะกำลังผลิต' . "','" . getenv("REMOTE_ADDR") . "',NOW())");

                    $data = array("status" => true, "message" => "แก้ไขการผลิตสำเร็จ!");
                } else {
                    $data = array("status" => false, "message" => $conn->error);
                }
            }
            echo json_encode($data);
            break;

        case "deleteStock":
            $stockOld = $conn->query("SELECT stock_name FROM tb_stock WHERE stock_id = '" . $_REQUEST['stockId'] . "' ")->fetch_object();
            $sql = $conn->query("DELETE FROM tb_stock WHERE stock_id = '" . $_REQUEST['stockId'] . "'");
            if ($sql) {
                $userBy = $conn->query("SELECT CONCAT(user_fname, ' ', user_lname) AS full_name FROM tb_user WHERE user_id = '" . $_REQUEST['userBy'] . "'")->fetch_object();

                $sql = $conn->query("INSERT INTO tb_log (log_user_by,log_action_type,log_action_detail,log_ip,log_create_at) 
                VALUE ('" . $userBy->full_name . "','ลบการผลิตในโซน ','" . $stockOld->stock_name . ' สถานะว่าง' . "','" . getenv("REMOTE_ADDR") . "',NOW())");

                $data = array("status" => true, "message" => "ลบการผลิตสำเร็จ!");
            } else {
                $data = array("status" => false, "message" => $conn->error);
            }
            echo json_encode($data);
            break;
        case "changeStatus":
            $stock = $conn->query("SELECT stock_name FROM tb_stock WHERE stock_id = '" . $_REQUEST['stockId'] . "' ")->fetch_object();
            $sql = $conn->query("UPDATE tb_stock SET stock_status = 0 WHERE stock_id = '" . $_REQUEST['stockId'] . "'");
            if ($sql) {
                $userBy = $conn->query("SELECT CONCAT(user_fname, ' ', user_lname) AS full_name FROM tb_user WHERE user_id = '" . $_REQUEST['userBy'] . "'")->fetch_object();

                $sql = $conn->query("INSERT INTO tb_log (log_user_by,log_action_type,log_action_detail,log_ip,log_create_at) 
                VALUE ('" . $userBy->full_name . "','เปลี่ยนสถานะการผลิตในโซน ','" . $stock->stock_name . ' สถานะว่าง' . "','" . getenv("REMOTE_ADDR") . "',NOW())");

                $data = array("status" => true, "message" => "เปลี่ยนสถานะการผลิตสำเร็จ!");
            } else {
                $data = array("status" => false, "message" => $conn->error);
            }
            echo json_encode($data);
            break;
        case "getStock":

            $stockData = $conn->query("SELECT stock_name FROM tb_stock WHERE stock_status != 0 AND stock_id != '" . $_REQUEST['stockId'] . "'");
            $stockDefault = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
            if ($stockData) {
                $stockExits = [];

                while ($stock = $stockData->fetch_object()) {
                    $stockExits[] = $stock->stock_name;
                }

                $filteredStockData = array_diff($stockDefault, $stockExits);
                $data = array("status" => true, "data" => $filteredStockData);
            } else {
                $data = array("status" => false, "data" => $stockDefault);
            }

            echo json_encode($data);
            break;
    }
}
