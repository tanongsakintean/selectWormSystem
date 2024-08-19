<?php
include "./checkSessiton.php";
// ตอน loop ให้ดักไม่เอาไอดีที่เราจะใช้เป็นเลือกหน้าร้านแทน เพราะเดะเอาเป้น condition ของ slip

$transports = $conn->query(
    "SELECT * FROM tb_transport WHERE tp_status = 1  ORDER BY tp_id DESC"
);
$transportData = [];
while ($transport = $transports->fetch_object()) {
    $transportData[] = $transport;
}
?>
<div class="container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-lg-6 main-header">
                <h2 class="ml-5">ระบบจัดการขนส่ง</h2>
            </div>
            <div class="col-lg-6 breadcrumb-right">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="?p=dashboard"><i class="pe-7s-home"></i></a></li>
                    <li class="breadcrumb-item active">ระบบจัดการขนส่ง </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid" style="background-color: #fdfeff !important;">


    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h3>ขนส่งทั้งหมด</h3>
                <div class="mb-3 float-right">
                    <button class="btn btn-primary mx-2" type="button" data-toggle="modal" data-target="#transportModal" onclick="createTranport()">เพิ่มขนส่งเข้าระบบ</button>
                </div>
                <div class="table-responsive">
                    <table class="display" id="basic-1">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ชื่อขนส่ง</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (
                                $transportData
                                as $key => $transport
                            ) { ?>
                                <tr>
                                    <td><?php echo ++$key; ?></td>
                                    <td><?php echo $transport->tp_name; ?></td>
                                    <td>
                                        <button data-toggle="modal" data-target="#transportModal" onclick="editTransport('<?php echo $transport->tp_id; ?>','<?php echo $transport->tp_name; ?>')" class="btn btn-primary" type="button">แก้ไข</button>
                                        <button onclick="deleteTransport('<?php echo $transport->tp_id; ?>')" class="btn btn-danger" type="button">ลบ</button>
                                    </td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="transportModal" tabindex="-1" role="dialog" aria-labelledby="transportModal" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="transportTitle">แก้ไขขนส่ง</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form class="transport-validation" action="action/ac_transport.php?ac=editTransport" id="transportForm" novalidate="">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">ชื่อขนส่ง</label>
                                <input name="tpName" class="form-control" id="tpName" type="text" placeholder="" required="">
                                <input name="tpId" class="form-control" id="tpId" type="text" placeholder="" hidden >
                                <input name="userBy" hidden value="<?php echo $_SESSION[
                                    "user_id"
                                ]; ?>" class="form-control" id="userBy" type="text" placeholder="">
                                <input hidden class="form-control" id="transportQuestion" type="text" placeholder="">
                                <div class="invalid-feedback">โปรดกรอกชื่อขนส่ง</div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" onclick="$('#transportForm').trigger('reset')" type="button" data-dismiss="modal">ยกเลิก</button>
                        <button class="btn btn-primary" type="submit">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</div>
<script>
    function createTranport() {
        $("#transportForm").attr("action", "action/ac_transport.php?ac=addTransport")
        $("#transportQuestion").val("คุณต้องการเพิ่มขนส่งหรือไม่?")
        $("#transportTitle").text("เพิ่มขนส่ง");
        $("#tpId").val("");
        $("#tpName").val("");
    }

    function editTransport(tpId, tpName) {
        $("#transportForm").attr("action", "action/ac_transport.php?ac=editTransport")
        $("#transportQuestion").val("คุณต้องการแก้ไขขนส่งหรือไม่?")
        $("#transportTitle").text("แก้ไขขนส่ง");
        $("#tpId").val(tpId);
        $("#tpName").val(tpName);
    }


    function deleteTransport(tpId) {
        let url = "";
        Swal.fire({
            icon: "question",
            title: "คุณต้องการลบขนส่งนี้หรือไม่?",
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: "ใช่",
            denyButtonText: "ยกเลิก",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `action/ac_transport.php?ac=deleteTransport&tpId=${tpId}&userBy=<?php echo $_SESSION[
                        "user_id"
                    ]; ?>`,
                    type: "POST",
                    data: {
                        tpId,
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
