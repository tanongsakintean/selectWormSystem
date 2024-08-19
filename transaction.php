<?php
include "./checkSessiton.php";

$transactions = $conn->query("
    SELECT * FROM tb_transactions tt LEFT JOIN tb_categories tc ON tt.category_id = tc.category_id
");
$transactionsData = [];
while ($transaction = $transactions->fetch_object()) {
    $transactionsData[] = $transaction;
}
?>

<div class="container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-lg-6 main-header">
                <h2 class="ml-5">ระบบจัดการรายรับรายจ่าย</h2>
            </div>
            <div class="col-lg-6 breadcrumb-right">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="?p=dashboard"><i class="pe-7s-home"></i></a></li>
                    <li class="breadcrumb-item active">ระบบจัดการรายรับรายจ่าย </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid" style="background-color: #fdfeff !important;">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h3>รายรับรายจ่ายทั้งหมด</h3>
                <div class="mb-3 float-right">
                    <button class="btn btn-primary mx-2" type="button" data-toggle="modal" data-target="#categoriesModal" onclick="createCategories()">เพิ่มรายรับรายจ่ายเข้าระบบ</button>
                </div>
                <div class="table-responsive">
                    <table class="display" id="basic-1">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ชื่อหมวดหมู่</th>
                                <th>ประเภท</th>
                                <th>จำนวนเงิน</th>
                                <th>วันที่บันทึก</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (
                                $transactionsData
                                as $key => $transaction
                            ) { ?>
                                <tr>
                                    <td><?php echo ++$key; ?></td>
                                    <td><?php echo $transaction->name; ?></td>
                                    <td><?php echo $transaction->type; ?></td>
                                    <td><?php echo $transaction->amount; ?></td>
                                    <td><?php echo $transaction->transaction_date; ?></td>
                                    <td>
                                        <button data-toggle="modal" data-target="#categoriesModal" onclick="edtiCategories('<?php echo $transaction->transaction_id; ?>','<?php echo $transaction->name; ?>','<?php echo $transaction->type; ?>')" class="btn btn-primary" type="button">แก้ไข</button>
                                        <button onclick="deleteCategories('<?php echo $transaction->transaction_id; ?>')" class="btn btn-danger" type="button">ลบ</button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

 <div class="modal fade" id="categoriesModal" tabindex="-1" role="dialog" aria-labelledby="categoriesModal" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="transactionTitle">แก้ไขรายรับรายจ่าย</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form class="categories-validation" action="action/ac_categories.php?ac=edtiCategories" id="transactionForm" novalidate="">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">ชื่อหมวดหมู่</label>
                                <input name="name" class="form-control" id="name" type="text" placeholder="" required="">
                                <input name="transactionId" class="form-control" id="transactionId" type="text" placeholder="" hidden>
                                <input name="userBy" hidden value="<?php echo $_SESSION[
                                    "user_id"
                                ]; ?>" class="form-control" id="userBy" type="text" placeholder="">
                                <input hidden class="form-control" id="transactionQuestion" type="text" placeholder="">
                                <div class="invalid-feedback">โปรดกรอกชื่อหมวดหมู่</div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom02">ประเภท</label>
                                <div class="col-md-12 mb-3">
                                    <select name="type" class="custom-select" required="" id="type" >
                                        <option value="">เลือกประเภท</option>
                                        <option value="รายรับ">รายรับ</option>
                                        <option value="รายจ่าย">รายจ่าย</option>
                                    </select>
                                    <div class="invalid-feedback">โปรดเลือกประเภท</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" onclick="$('#transactionForm').trigger('reset')" type="button" data-dismiss="modal">ยกเลิก</button>
                        <button class="btn btn-primary" type="submit">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function createCategories() {
        $("#transactionForm").attr("action", "action/ac_categories.php?ac=addCategories")
        $("#transactionQuestion").val("คุณต้องการเพิ่มรายรับรายจ่ายหรือไม่?")
        $("#transactionTitle").text("เพิ่มรายรับรายจ่าย");
        $("#transactionId").val("");
        $("#type").val("");
        $("#name").val("");
    }

    function edtiCategories(transactionId, name,type) {
        $("#transactionForm").attr("action", "action/ac_categories.php?ac=edtiCategories")
        $("#transactionQuestion").val("คุณต้องการแก้ไขรายรับรายจ่ายหรือไม่?")
        $("#transactionTitle").text("แก้ไขรายรับรายจ่าย");
        $("#transactionId").val(transactionId);
        $("#type").val(type);
        $("#name").val(name);
    }


    function deleteCategories(transactionId) {
        let url = "";
        Swal.fire({
            icon: "question",
            title: "คุณต้องการลบรายรับรายจ่ายนี้หรือไม่?",
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: "ใช่",
            denyButtonText: "ยกเลิก",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `action/ac_categories.php?ac=deleteCategories&transactionId=${transactionId}&userBy=<?php echo $_SESSION[
                        "user_id"
                    ]; ?>`,
                    type: "POST",
                    data: {
                        transactionId,
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
