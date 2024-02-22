<?php
session_start();
include("../connect.php");



if (isset($_REQUEST['ac'])) {

    switch ($_REQUEST['ac']) {

        case 'createProduct':
            // php gen uniqid
            // productStatus = 1 => ยังอยู่
            // 2 => ลบ
            $sql = $conn->query("SELECT * FROM tb_products WHERE product_name = '" . $_REQUEST['productName'] . "'   ");
            if ($sql->num_rows > 0) {
                $data = array("status" => false, "message" => "ชื่อสินค้าซ้ำ!");
            } else {
                $productCode = uniqid();
                $sql = $conn->query("INSERT INTO tb_products(product_code,product_name,product_amount,product_price,product_size,unit_id,category_id,product_status) 
                VALUE ('" . $productCode . "','" . $_REQUEST['productName'] . "',0,'" . $_REQUEST['productPrice'] . "','" . $_REQUEST['productSize'] . "','" . $_REQUEST['productUnit'] . "','" . $_REQUEST['productCategory'] . "',1)");
                if ($sql) {
                    $userBy = $conn->query("SELECT CONCAT(user_fname, ' ', user_lname) AS full_name FROM tb_user WHERE user_id = '" . $_REQUEST['userBy'] . "'")->fetch_object();

                    $sql = $conn->query("INSERT INTO tb_log (log_user_by,log_action_type,log_action_detail,log_ip,log_create_at) 
                    VALUE ('" . $userBy->full_name . "','เพิ่มสินค้า ','" . $_REQUEST['productName'] . ' เข้าระบบ' . "','" . getenv("REMOTE_ADDR") . "',NOW())");

                    $data = array("status" => true, "message" => "เพิ่มสินค้าเข้าระบบสำเร็จ!");
                } else {
                    $data = array("status" => false, "message" => $conn->error);
                }
            }
            echo json_encode($data);
            break;
        case 'editProduct':
            $sql = $conn->query("UPDATE tb_products SET product_name = '" . $_REQUEST['productName'] . "',product_price = '" . $_REQUEST['productPrice'] . "',product_size = '" . $_REQUEST['productSize'] . "',unit_id = '" . $_REQUEST['productUnit'] . "',category_id = '" . $_REQUEST['productCategory'] . "' WHERE product_id = '" . $_REQUEST['productId'] . "' ");
            if ($sql) {
                $userBy = $conn->query("SELECT CONCAT(user_fname, ' ', user_lname) AS full_name FROM tb_user WHERE user_id = '" . $_REQUEST['userBy'] . "'")->fetch_object();

                $sql = $conn->query("INSERT INTO tb_log (log_user_by,log_action_type,log_action_detail,log_ip,log_create_at) 
                VALUE ('" . $userBy->full_name . "','แก้ไขข้อมูลสินค้า ','" . $_REQUEST['productName'] . "','" . getenv("REMOTE_ADDR") . "',NOW())");

                $data = array("status" => true, "message" => "แก้ไขสินค้าสำเร็จ!");
            } else {
                $data = array("status" => false, "message" => $conn->error);
            }
            echo json_encode($data);
            break;

        case "deleteProduct":
            $productOld = $conn->query("SELECT product_name FROM tb_products WHERE product_id = '" . $_REQUEST['productId'] . "'")->fetch_object();
            $sql = $conn->query("DELETE FROM tb_products  WHERE product_id = '" . $_REQUEST['productId'] . "' ");
            if ($sql) {
                $userBy = $conn->query("SELECT CONCAT(user_fname, ' ', user_lname) AS full_name FROM tb_user WHERE user_id = '" . $_REQUEST['userBy'] . "'")->fetch_object();

                $sql = $conn->query("INSERT INTO tb_log (log_user_by,log_action_type,log_action_detail,log_ip,log_create_at) 
                VALUE ('" . $userBy->full_name . "','ลบสินค้า ','" . $productOld->product_name . " ออกจากระบบ" . "','" . getenv("REMOTE_ADDR") . "',NOW())");

                $data = array("status" => true, "message" => "ลบสินค้าสำเร็จ!");
            } else {
                $data = array("status" => false, "message" => $conn->error);
            }
            echo json_encode($data);
            break;

        case 'addProduct':
            $product = $conn->query("SELECT product_name FROM tb_products WHERE product_id = '" . $_REQUEST['productId'] . "'")->fetch_object();
            $log = $conn->query("INSERT INTO tb_product_log (pl_amount,product_id,pl_created_at) VALUE ('" . $_REQUEST['productAmount'] . "','" . $_REQUEST['productId'] . "','" . $_REQUEST['productStockDate'] . "')");
            $sql = $conn->query("UPDATE tb_products 
            SET product_amount = (
                SELECT SUM(pl_amount) 
                FROM tb_product_log 
                WHERE product_id = '" . $_REQUEST['productId'] . "'
            ) 
            WHERE product_id = '" . $_REQUEST['productId'] . "'");
            if ($sql && $log) {
                $userBy = $conn->query("SELECT CONCAT(user_fname, ' ', user_lname) AS full_name FROM tb_user WHERE user_id = '" . $_REQUEST['userBy'] . "'")->fetch_object();

                $sql = $conn->query("INSERT INTO tb_log (log_user_by,log_action_type,log_action_detail,log_ip,log_create_at) 
                VALUE ('" . $userBy->full_name . "','เติมสินค้า ','" . $product->product_name . " จำนวน " . $_REQUEST['productAmount'] . " เข้าคลัง" . "','" . getenv("REMOTE_ADDR") . "',NOW())");

                $data = array("status" => true, "message" => "เติมสินค้าเข้าคลังสำเร็จ!");
            } else {
                $data = array("status" => false, "message" => $conn->error);
            }
            echo json_encode($data);
            break;

        case "editProductStock":
            $product = $conn->query("SELECT product_name FROM tb_products WHERE product_id = '" . $_REQUEST['productId'] . "'")->fetch_object();
            $log = $conn->query("UPDATE tb_product_log SET product_id = '" . $_REQUEST['productId'] . "', pl_amount = '" . $_REQUEST['productAmount'] . "' ,pl_created_at = '" . $_REQUEST['productStockDate'] . "' WHERE pl_id = '" . $_REQUEST['plId'] . "'");
            $sql = $conn->query("UPDATE tb_products 
            SET product_amount = (
                SELECT SUM(pl_amount) 
                FROM tb_product_log 
                WHERE product_id = '" . $_REQUEST['productId'] . "'
            ) 
            WHERE product_id = '" . $_REQUEST['productId'] . "'");
            if ($sql && $log) {
                $userBy = $conn->query("SELECT CONCAT(user_fname, ' ', user_lname) AS full_name FROM tb_user WHERE user_id = '" . $_REQUEST['userBy'] . "'")->fetch_object();

                $sql = $conn->query("INSERT INTO tb_log (log_user_by,log_action_type,log_action_detail,log_ip,log_create_at) 
                VALUE ('" . $userBy->full_name . "','แก้ไขข้อมูลสินค้า ','" . $product->product_name . " ในคลัง" . "','" . getenv("REMOTE_ADDR") . "',NOW())");

                $data = array("status" => true, "message" => "แก้ไขสินค้าเข้าคลังสำเร็จ!");
            } else {
                $data = array("status" => false, "message" => $conn->error);
            }
            echo json_encode($data);
            break;

        case "deleteProductStock":
            $productOld = $conn->query("SELECT product_name FROM tb_products WHERE product_id = '" . $_REQUEST['productId'] . "'")->fetch_object();
            $productOldAmount = $conn->query("SELECT pl_amount FROM tb_product_log WHERE pl_id = '" . $_REQUEST['plId'] . "' ")->fetch_object();
            $log = $conn->query("DELETE FROM tb_product_log WHERE pl_id = '" . $_REQUEST['plId'] . "'");
            $sql = $conn->query("UPDATE tb_products 
            SET product_amount = (
                SELECT SUM(pl_amount) 
                FROM tb_product_log 
                WHERE product_id = '" . $_REQUEST['productId'] . "'
            ) 
            WHERE product_id = '" . $_REQUEST['productId'] . "'");
            if ($sql && $log) {
                $userBy = $conn->query("SELECT CONCAT(user_fname, ' ', user_lname) AS full_name FROM tb_user WHERE user_id = '" . $_REQUEST['userBy'] . "'")->fetch_object();

                $sql = $conn->query("INSERT INTO tb_log (log_user_by,log_action_type,log_action_detail,log_ip,log_create_at) 
                VALUE ('" . $userBy->full_name . "','ลบสินค้า ','" . $productOld->product_name . " จำนวน " . $productOldAmount->pl_amount . " ออกจากคลัง" . "','" . getenv("REMOTE_ADDR") . "',NOW())");

                $data = array("status" => true, "message" => "ลบจำนวนสินค้าออกจากคลังสำเร็จ!");
            } else {
                $data = array("status" => false, "message" => $conn->error);
            }
            echo json_encode($data);
            break;
    }
}
