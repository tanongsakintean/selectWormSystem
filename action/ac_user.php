<?php
session_start();
include("../connect.php");

if (isset($_REQUEST['ac'])) {
    switch ($_REQUEST['ac']) {

        case "addUser":
            $sql = $conn->query("SELECT * FROM tb_user WHERE user_username = '" . $_REQUEST['username'] . "'   ");
            $num = $sql->num_rows;
            if ($num > 0) {
                $data = array("status" => false, "message" => "Username ซ้ำ!");
            } else {
                if ($_REQUEST['password'] == $_REQUEST['replyPassword']) {
                    $sql = $conn->query("INSERT INTO tb_user (user_username,user_fname,user_lname,user_password,user_role,user_created_at,user_status) 
                    VALUES ('" . $_REQUEST['username'] . "','" . $_REQUEST['fname'] . "','" . $_REQUEST['lname'] . "','" . $_REQUEST['password'] . "',1,NOW(),1) ");
                    if ($sql) {
                        $data = array("status" => true, "message" => "เพิ่มผู้ใช้งานเข้าระบบสำเร็จ!");

                        $userBy = $conn->query("SELECT CONCAT(user_fname, ' ', user_lname) AS full_name FROM tb_user WHERE user_id = '" . $_REQUEST['userBy'] . "'")->fetch_object();
                        $sql = $conn->query("INSERT INTO tb_log (log_user_by,log_action_type,log_action_detail,log_ip,log_create_at) 
                        VALUE ('" . $userBy->full_name . "','เพิ่มพนักงาน','" . $_REQUEST['fname'] . " " . $_REQUEST['lname'] . "'.'เข้าระบบ','" . getenv("REMOTE_ADDR") . "',NOW())");
                    } else {
                        $data = array("status" => false, "message" => $conn->error);
                    }
                } else {
                    $data = array("status" => false, "message" => "Password ไม่ตรงกัน!");
                }
            }

            echo json_encode($data);
            break;
        case 'editUser':
            $sql = $conn->query("UPDATE tb_user SET user_username = '" . $_REQUEST['username'] . "', user_fname = '" . $_REQUEST['fname'] . "', user_lname = '" . $_REQUEST['lname'] . "' WHERE user_id = '" . $_REQUEST['userId'] . "' ");

            if ($sql) {
                $data = array("status" => true, "message" => "แก้ไขข้อมูลผู้ใช้งานสำเร็จ!");

                $userBy = $conn->query("SELECT CONCAT(user_fname, ' ', user_lname) AS full_name FROM tb_user WHERE user_id = '" . $_REQUEST['userBy'] . "'")->fetch_object();
                $sql = $conn->query("INSERT INTO tb_log (log_user_by,log_action_type,log_action_detail,log_ip,log_create_at) 
                                        VALUE ('" . $userBy->full_name . "','แก้ไขข้อมูลพนักงาน','" . $_REQUEST['fname'] . " " . $_REQUEST['lname'] . "','" . getenv("REMOTE_ADDR") . "',NOW())");
            } else {
                $data = array("status" => false, "message" => $conn->error);
            }
            echo json_encode($data);
            break;
        case 'deleteUser':
            $userOld = $conn->query("SELECT CONCAT(user_fname, ' ', user_lname) AS full_name FROM tb_user WHERE user_id = '" . $_REQUEST['userId'] . "'")->fetch_object();
            $sql = $conn->query("DELETE FROM tb_user WHERE user_id = '" . $_REQUEST['userId'] . "' ");

            if ($sql) {
                $data = array("status" => true, "message" => "ลบผู้ใช้งานสำเร็จ!");


                $userBy = $conn->query("SELECT CONCAT(user_fname, ' ', user_lname) AS full_name FROM tb_user WHERE user_id = '" . $_REQUEST['userBy'] . "'")->fetch_object();
                $sql = $conn->query("INSERT INTO tb_log (log_user_by,log_action_type,log_action_detail,log_ip,log_create_at) 
                                        VALUE ('" . $userBy->full_name . "','ลบพนักงาน','" . $userOld->full_name . "ออกจากระบบ" . "','" . getenv("REMOTE_ADDR") . "',NOW())");
            } else {
                $data = array("status" => false, "message" => $conn->error);
            }
            echo json_encode($data);
            break;
    }
}
