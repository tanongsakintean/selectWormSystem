<?php
session_start();
include("../connect.php");



if (isset($_REQUEST['ac'])) {

    switch ($_REQUEST['ac']) {

        case 'login':
            // user role
            // 1 => พนักงาน
            // 2 => แอดมิน

            // user status 
            // 1 => ยังอยู่
            // 2 => ลบ
            $sql = $conn->query("SELECT * FROM tb_user WHERE user_username = '" . $_REQUEST['username'] . "' AND user_password = '" . $_REQUEST['password'] . "'");
            $num = $sql->num_rows;
            if ($num > 0) {
                $fet = $sql->fetch_object();
                $_SESSION['ses_id'] = session_id();
                $_SESSION['user_fullName'] = $fet->user_fname . " " . $fet->user_lname;
                $_SESSION['mem_username'] = $fet->user_username;
                $_SESSION['user_id'] = $fet->user_id;
                $_SESSION['user_role'] = $fet->user_role;
                if ($fet->user_status == '1') {
                    $update = $conn->query("UPDATE tb_user SET user_last_login = NOW() WHERE user_id = '" . $_SESSION['user_id'] . "' ");
                    $data = array("status" => true, "message" => "ยินดีเข้าสู่ระบบ");
                } else {
                    $update = $conn->query("UPDATE tb_user SET user_last_login = NOW() WHERE user_id = '" . $_SESSION['user_id'] . "'  ");
                    $data = array("status" => true, "message" => "ยินดีเข้าสู่ระบบแอดมิน");
                }

                $sql = $conn->query("INSERT INTO tb_log (log_user_by,log_action_type,log_action_detail,log_ip,log_create_at) 
                VALUE ('" . $fet->user_fname . " " . $fet->user_lname . "','เข้าสู่ระบบ','" . $fet->user_fname . " " . $fet->user_lname . "','" . getenv("REMOTE_ADDR") . "',NOW())");
            } else {
                $data = array("status" => false, "message" => "โปรดกรอก username หรือ password ให้ถูกต้อง!");
            }

            echo json_encode($data);
            break;

        case 'reg':
            $sql = $conn->query("SELECT * FROM tb_user WHERE user_username = '" . $_REQUEST['username'] . "'   ");
            $num = $sql->num_rows;
            if ($num > 0) {
                $data = array("status" => false, "message" => "Username ซ้ำ!");
            } else {
                if ($_REQUEST['password'] == $_REQUEST['replyPassword']) {
                    $sql = $conn->query("INSERT INTO tb_user (user_username,user_fname,user_lname,user_password,user_role,user_created_at,user_status) 
                    VALUES ('" . $_REQUEST['username'] . "','" . $_REQUEST['fname'] . "','" . $_REQUEST['lname'] . "','" . $_REQUEST['password'] . "',1,NOW(),1) ");
                    if ($sql) {
                        $data = array("status" => true, "message" => "ลงทะเบียนเข้าระบบสำเร็จ!");
                    } else {
                        $data = array("status" => false, "message" => $conn->error);
                    }
                } else {
                    $data = array("status" => false, "message" => "Password ไม่ตรงกัน!");
                }
            }

            echo json_encode($data);
            break;

        case 'reset_pass':
            $sql = $conn->query("SELECT user_id FROM tb_user WHERE user_id = '" . $_REQUEST['user_id'] . "'   ");
            $num = $sql->num_rows;
            if ($num > 0) {
                if ($_REQUEST['newPassword'] == $_REQUEST['replyPassword']) {
                    $update = $conn->query("UPDATE tb_user SET user_password = '" . $_REQUEST['newPassword'] . "'  WHERE user_id = '" . $_REQUEST['user_id'] . "' ");
                    $data = array("status" => true, "message" => "เปลี่ยนรหัสผ่านสำเร็จ!");
                } else {
                    $data = array("status" => false, "message" => "รหัสผ่านไม่ตรงกัน!");
                }
            } else {
                $data = array("status" => false, "message" => "เกิดข้อผิดพลาดโปรดลองอีกครั้ง!");
            }
            echo json_encode($data);
            break;

        case 'forgot':
            $sql = $conn->query("SELECT user_id FROM tb_user WHERE user_username = '" . $_REQUEST['user_username'] . "'   ");
            $num = $sql->num_rows;
            if ($num > 0) {
                $fet = $sql->fetch_object();
                $data = array("status" => true, "message" => "ยืนยัน username ถูกต้อง!", "userId" => $fet->user_id);
            } else {
                $data = array("status" => false, "message" => "โปรดตรวจสอบ username ให้ถูกต้อง!");
            }

            echo json_encode($data);
            break;
    }
}
