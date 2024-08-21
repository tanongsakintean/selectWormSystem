<?php
include "./checkSessiton.php";

$transactions = $conn->query("
    SELECT * FROM tb_transactions tt LEFT JOIN tb_categories tc ON tt.category_id = tc.category_id ORDER BY tt.transaction_id DESC
");

$transactionsData = [];
while ($transaction = $transactions->fetch_object()) {
    $transactionsData[] = $transaction;
}

$categories = $conn->query("SELECT * FROM tb_categories");
$categoriesData = [];
while ($category = $categories->fetch_object()) {
    $categoriesData[] = $category;
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
                    <button class="btn btn-primary mx-2" type="button" data-toggle="modal" data-target="#transactionModal" onclick="createTransaction()">เพิ่มรายรับรายจ่ายเข้าระบบ</button>
                </div>
                <div class="table-responsive">
                    <table class="display" id="excel-cust-bolder">
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
                                    <td><?php
                                    $date = new DateTime(
                                        $transaction->transaction_date
                                    );
                                    $dayMonth = $date->format("d/m");
                                    $year = (int) $date->format("Y");

                                    // แปลงปีเป็นพุทธศักราช (เพิ่ม 543 ปี)
                                    $yearBuddhist = $year + 543;

                                    // แสดงผลวันที่ในรูปแบบ dd/mm/yyyy (ปี พ.ศ.)
                                    $formattedDate =
                                        $dayMonth . "/" . $yearBuddhist;

                                    echo $formattedDate;
                                    ?></td>
                                    <td>
                                        <button data-toggle="modal" data-target="#transactionModal" onclick="editTransaction('<?php echo $transaction->transaction_id; ?>','<?php echo $transaction->category_id; ?>','<?php echo $transaction->transaction_date; ?>','<?php echo $transaction->description; ?>','<?php echo $transaction->amount; ?>')" class="btn btn-primary" type="button">แก้ไข</button>
                                        <button onclick="deleteTransaction('<?php echo $transaction->transaction_id; ?>')" class="btn btn-danger" type="button">ลบ</button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

 <div class="modal fade" id="transactionModal" tabindex="-1" role="dialog" aria-labelledby="transactionModal" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="transactionTitle">แก้ไขรายรับรายจ่าย</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form class="transaction-validation" action="action/ac_transaction.php?ac=editTransaction" id="transactionForm" novalidate="">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom02">หมวดหมู่</label>
                                <div class="col-md-12 mb-3">
                                    <select name="category" onchange="setCategoryName()" class="custom-select" required="" id="category" >
                                        <option value="">เลือกหมวดหมู่</option>
                                        <?php foreach (
                                            $categoriesData
                                            as $key => $value
                                        ) { ?>
                                        <option value="<?php echo $value->category_id; ?>"><?php echo $value->name .
    " -> " .
    $value->type; ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="invalid-feedback">โปรดเลือกหมวดหมู่</div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">จำนวนเงิน</label>
                                <input name="amount" class="form-control" id="amount" type="number" placeholder="" required="">
                                <input name="transactionId" class="form-control" id="transactionId" type="text" placeholder="" hidden>
                                <input name="categoryName" class="form-control" id="categoryName" type="text" placeholder="" hidden>
                                <input name="userBy" hidden value="<?php echo $_SESSION[
                                    "user_id"
                                ]; ?>" class="form-control" id="userBy" type="text" placeholder="">
                                <input hidden class="form-control" id="transactionQuestion" type="text" placeholder="">
                                <div class="invalid-feedback">โปรดกรอกจำนวนเงิน</div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">รายละเอียด</label>
                                <textarea class="form-control" name="description" id="description"></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">วันที่บันทึก</label>
                                <input type="datetime-local" id="transactionDate" name="transactionDate" class="form-control" required >
                                <div class="invalid-feedback">โปรดกรอกวันที่บันทึก</div>
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
  function setCategoryName(){
    $("#categoryName").val($("#category option:selected").text())
  }


    function createTransaction() {
        $("#transactionForm").attr("action", "action/ac_transaction.php?ac=addTransaction")
        $("#transactionQuestion").val("คุณต้องการเพิ่มรายรับรายจ่ายหรือไม่?")
        $("#transactionTitle").text("เพิ่มรายรับรายจ่าย");
        $("#transactionId").val("");
        $("#category").val("");
        $("#transactionDate").val("")
        $("#description").val("")
        $("#transactionId").val("");
        $("#amount").val("");
    }

    function editTransaction(transactionId,category,transactionDate,description,amount) {
        $("#transactionForm").attr("action", "action/ac_transaction.php?ac=editTransaction")
        $("#transactionQuestion").val("คุณต้องการแก้ไขรายรับรายจ่ายหรือไม่?")
        $("#transactionTitle").text("แก้ไขรายรับรายจ่าย");
        $("#transactionId").val(transactionId);
        $("#category").val(category);
        $("#transactionDate").val(transactionDate)
        $("#description").val(description)
        $("#amount").val(amount);
    }


    function deleteTransaction(transactionId) {
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
                    url: `action/ac_transaction.php?ac=deleteTransaction&transactionId=${transactionId}&userBy=<?php echo $_SESSION[
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
