<?php

include("./checkSessiton.php");

$users = $conn->query("SELECT * FROM tb_user WHERE user_status = 1 AND user_role = 1 ORDER BY user_id DESC");
$usersData = [];
while ($user = $users->fetch_object()) {
    $usersData[] = $user;
}
?>
<div class="container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-lg-6 main-header">
                <h2 class="ml-5">ระบบพนักงาน</h2>
            </div>
            <div class="col-lg-6 breadcrumb-right">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="?p=dashboard"><i class="pe-7s-home"></i></a></li>
                    <li class="breadcrumb-item active">ระบบพนักงาน </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid" style="background-color: #fdfeff !important;">


    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h3>พนักงานทั้งหมด</h3>
                <div class="mb-3 float-right">
                    <button class="btn btn-primary mx-2" type="button" data-toggle="modal" data-target="#userModal" onclick="createUser()">เพิ่มพนักงานเข้าระบบ</button>
                </div>
                <div class="table-responsive">
                    <table class="display" id="basic-1">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ชื่อผู้ใช้งาน</th>
                                <th>ชื่อ-นามสกุล</th>
                                <th>วันที่สร้างบัญชี</th>
                                <th>เข้าสู่ระบบล่าสุด</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($usersData as $key => $user) {
                            ?>
                                <tr>
                                    <td><?php echo ++$key ?></td>
                                    <td><?php echo $user->user_username; ?></td>
                                    <td><?php echo $user->user_fname . " " . $user->user_lname; ?></td>
                                    <td><?php echo $user->user_created_at; ?></td>
                                    <td><?php echo $user->user_last_login; ?></td>
                                    <td>
                                        <button data-toggle="modal" data-target="#userModal" onclick="editUser('<?php echo $user->user_id; ?>','<?php echo $user->user_username; ?>','<?php echo $user->user_fname; ?>','<?php echo $user->user_lname; ?>')" class="btn btn-primary" type="button">แก้ไข</button>
                                        <button onclick="deleteUser('<?php echo  $user->user_id; ?>')" class="btn btn-danger" type="button">ลบ</button>
                                    </td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModal" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userTitle">แก้ไขผู้ใช้งาน</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form class="users-validation" action="action/ac_user.php?ac=editUser" id="userForm" novalidate="">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">ชื่อผู้ใช้งาน</label>
                                <input name="username" class="form-control" id="userName" type="text" placeholder="" required="">
                                <input name="userId" hidden class="form-control" id="userId" type="text" placeholder="">
                                <input name="userBy" hidden value="<?php echo $_SESSION['user_id']; ?>" class="form-control" id="userBy" type="text" placeholder="">
                                <input hidden class="form-control" id="userQuestion" type="text" placeholder="">
                                <div class="invalid-feedback">โปรดกรอกชื่อผู้ใช้งาน</div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">ชื่อจริง</label>
                                <input name="fname" class="form-control" id="userFname" type="text" placeholder="" required="">
                                <div class="invalid-feedback">โปรดกรอกชื่อจริง</div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">นามสกุล</label>
                                <input name="lname" class="form-control" id="userLname" type="text" placeholder="" required="">
                                <div class="invalid-feedback">โปรดกรอกนามสกุล</div>
                            </div>
                        </div>


                        <div id="addUser">

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" onclick="$('#userForm').trigger('reset')" type="button" data-dismiss="modal">ยกเลิก</button>
                        <button class="btn btn-primary" type="submit">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</div>
<script>
    function createUser() {
        $("#userForm").attr("action", "action/ac_user.php?ac=addUser")
        $("#userQuestion").val("คุณต้องการเพิ่มผู้ใช้งานหรือไม่?")
        $("#userTitle").text("เพิ่มผู้ใช้งาน");
        $("#userId").val("");
        // $("#userBy").val("");
        $("#userName").val("");
        $("#userFname").val("");
        $("#userLname").val("");
        $("#addUser").append(`
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">รหัสผ่าน</label>
                                <input name="password" class="form-control" id="password" type="password" placeholder="" required="">
                                <div class="invalid-feedback">โปรดกรอกรหัสผ่าน</div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">ยืนยันรหัสผ่าน</label>
                                <input name="replyPassword" class="form-control" id="replyPassword" type="password" placeholder="" required="">
                                <div class="invalid-feedback">โปรดกรอกยืนยันรหัสผ่าน</div>
                            </div>
                        </div>`)
    }

    function editUser(userId, userName, userFname, userLname) {
        $("#userForm").attr("action", "action/ac_user.php?ac=editUser")
        $("#userQuestion").val("คุณต้องการแก้ไขผู้ใช้งานหรือไม่?")
        $("#userTitle").text("แก้ไขผู้ใช้งาน");
        $("#userId").val(userId);
        $("#userName").val(userName);
        $("#userFname").val(userFname);
        $("#userLname").val(userLname);
        $("#addUser").empty();
    }


    function deleteUser(userId) {
        let url = "";
        Swal.fire({
            icon: "question",
            title: "คุณต้องการลบผู้ใช้งานหรือไม่?",
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: "ใช่",
            denyButtonText: "ยกเลิก",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `action/ac_user.php?ac=deleteUser&userId=${userId}&userBy=<?php echo $_SESSION['user_id']; ?>`,
                    type: "POST",
                    data: {
                        userId,
                    },
                    success: function(res) {
                        let {
                            status,
                            message
                        } = JSON.parse(res);

                        if (status) {
                            Swal.fire({
                                title: message,
                                icon: "success",
                                showConfirmButton: false,
                                timer: 1000,
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: message,
                                icon: "error",
                                showConfirmButton: false,
                                timer: 1000,
                            });
                        }
                    },
                });
            }
        });

    }
</script>