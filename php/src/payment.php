<?php
include "./checkSessiton.php";
$products = $conn->query(
    "SELECT * FROM tb_products WHERE product_status = 1 AND product_amount != 0"
);
$payments = $conn->query("SELECT p.*,u.user_fname,u.user_lname FROM tb_payment p LEFT JOIN tb_user u
ON p.user_id = u.user_id ORDER BY p.payment_id DESC");

$paymentHistory = [];
while ($payment = $payments->fetch_object()) {
    $paymentHistory[] = $payment;
}

$productData = [];
while ($product = $products->fetch_object()) {
    $productData[] = $product;
}
?>
<div class="container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-lg-6 main-header">
                <h2 class="ml-5">ระบบการขาย</h2> </div>
            <div class="col-lg-6 breadcrumb-right">
                <ol class="breadcrumb">
                    <?php if ($_SESSION["user_role"] == 2) { ?>
                    <li class="breadcrumb-item"><a href="?p=dashboard"><i class="pe-7s-home"></i></a></li>
                    <?php } else { ?>
                    <li class="breadcrumb-item"><a href="?p=stock"><i class="pe-7s-home"></i></a></li>
                    <?php } ?>
                    <li class="breadcrumb-item active">ระบบการขาย </li>
                </ol>
            </div>
        </div>
    </div>
</div>


<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <h3>สินค้าทั้งหมด</h3>
                <div class="mb-3 float-right">
                    <button class="btn btn-primary mx-2" id="payment-btn" type="button" data-toggle="modal" data-target="#addPaymentModal">เพิ่มยอดขาย</button>
                </div>
                <table class="display" id="payment-datable">
                    <thead>
                        <tr>
                            <th class="d-flex justify-content-center">
                                <input type="checkbox" name="select_all" value="1" id="payment-select-all">
                            </th>
                            <th>ชื่อสินค้า</th>
                            <th>จำนวน</th>
                            <th>ราคา</th>
                            <th>ขนาด</th>
                            <th>ประเภท</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productData as $key => $product) { ?>
                            <tr>
                                <td><?php echo $product->product_id; ?></td>
                                <td><?php echo $product->product_name; ?></td>
                                <td><?php echo $product->product_amount; ?></td>
                                <td><?php echo $product->product_price; ?></td>
                                <td><?php echo $product->product_size .
                                    " " .
                                    $product->unit_id; ?></td>
                                <td><?php echo $product->category_id; ?></td>
                            </tr>
                        <?php } ?>
                </table>
            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <h3>ยอดขายทั้งหมด</h3>

                <table class="display" id="basic-1">
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>ผู้ทำรายการ</th>
                            <th>ราคาทั้งหมด</th>
                            <th>วันที่เพิ่มยอดขาย</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($paymentHistory as $key => $payment) { ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $payment->user_fname .
                                    " " .
                                    $payment->user_lname; ?></td>
                                <td><?php echo $payment->payment_total; ?></td>
                                <td><?php echo $payment->payment_create_at; ?></td>
                                <td>
                                    <button onclick="showInfo('<?php echo $payment->payment_id; ?>')" data-toggle="modal" data-target="#infoPaymentModal" class="btn btn-info" type="button">รายละเอียด</button>
                                    <?php if ($payment->tp_id != 0) { ?>
                                    <button onclick="addTransportNumber('<?php echo $payment->payment_id; ?>','<?php echo $payment->transport_number; ?>')" class="btn btn-warning mx-2" id="transport-number-btn" type="button" data-toggle="modal" data-target="#transportNumberModal">เพิ่มรหัสพัสดุ</button>
                                    <?php } ?>
                                    <button onclick="printSlip('<?php echo $payment->payment_id; ?>')" class="btn btn-success mx-2">พิมพ์</button>
                                    <button onclick="deletePayment('<?php echo $payment->payment_id; ?>')" class="btn btn-danger" type="button">ลบ</button>
                                </td>
                            </tr>
                        <?php } ?>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="transportNumberModal" tabindex="-1" role="dialog" aria-labelledby="transportNumberModal" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentTitle">เพิ่มรหัสพัสดุ</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form class="transport-number-validation" action="action/ac_payment.php?ac=addTransportNumber" id="transportNumberForm" novalidate="">
                    <div class="modal-body">
                        <input class="form-control" id="questionTransportNumber" type="text" placeholder="" hidden>
                        <input class="form-control" id="paymentId" name="paymentId" type="text" placeholder="" hidden>
                        <div class="row  ">
                            <div class="col-md-3 mb-3"><h5>รหัสพัสดุ : </h5> </div>
                            <div class="col-md-9 mb-3">
                                <input class="form-control" name="transport_number" id="transportNumber" type="text" placeholder="" required>
                                <div class="invalid-feedback">โปรดกรอกรหัสพัสดุ</div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer " >
                        <button class="btn btn-secondary " id="btn-cancels" onclick="$('#transportNumberForm').trigger('reset')" type="button" data-dismiss="modal">ยกเลิก</button>
                        <button class="btn btn-primary" type="submit">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addPaymentModal" tabindex="-1" role="dialog" aria-labelledby="addPaymentModal" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentTitle">เพิ่มยอดขาย</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form class="payment-validation" action="action/ac_payment.php?ac=addPayment" id="addPayment" novalidate="">
                    <input class="form-control" id="questionPayment" type="text" placeholder="" hidden>
                    <input class="form-control" name="userId" value="<?php echo $_SESSION[
                        "user_id"
                    ]; ?>" id="userId" type="text" placeholder="" hidden>
                    <div class="modal-body">
                    </div>

                    <div class="modal-footer " id="addPaymentModalFooter">
                        <button class="btn btn-secondary " id="btn-cancels" onclick="$('#addPayment').trigger('reset')" type="button" data-dismiss="modal">ยกเลิก</button>
                        <button class="btn btn-primary" type="submit">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="infoPaymentModal" tabindex="-1" role="dialog" aria-labelledby="infoPaymentModal" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentTitle">รายละเอียดยอดขาย</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="row  justify-content-start">
                            <div class="mx-3 mb-3"><h5>ประเภทขนส่ง : </h5></div>
                            <div class="mx-2 mb-3"><h5 id="tpType"></h5></div>
                        </div>
                        <div class="row  justify-content-start">
                            <div class="mx-3 mb-3"><h5>รหัสพัสดุ : </h5></div>
                            <div class="mx-2 mb-3"><h5 id="tpNumber"></h5></div>
                        </div>
                    </div>
                    <table class="display" id="order">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>รหัสสินค้า</th>
                                <th>ชื่อสินค้า</th>
                                <th>จำนวน</th>
                                <th>ขนาด</th>
                                <th>ราคา</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>

      function printSlip(paymentId){
        window.open(`http://localhost:8080/export_pdf/print_slip_pdf.php?payment_id=${paymentId}`)
      }

        function addTransportNumber(paymentId,transportNumber = ""){
          $("#paymentId").val(paymentId)
          $("#transportNumber").val(transportNumber)
        }

        function deletePayment(paymentId) {
            Swal.fire({
                icon: "question",
                title: "คุณต้องการลบยอดขายหรือไม่?",
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: "ใช่",
                denyButtonText: "ยกเลิก",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `action/ac_payment.php?ac=deletePayment&paymentId=${paymentId}&userBy=<?php echo $_SESSION[
                            "user_id"
                        ]; ?>`,
                        type: "POST",
                        data: {
                            paymentId
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

        function showInfo(id) {
            $.ajax({
                url: `action/ac_payment.php?ac=getOrder&paymentId=${id}`,
                type: "GET", // Change this to "GET" for a GET request
                data: {
                    id
                },
                success: function(res) {
                    let {
                        status,
                        data,
                        tpName,
                        tpNumber
                    } = JSON.parse(res)
                    if (status) {
                        $("#tpType").text(tpName)

                        if(tpName === null){
                          $("#tpType").text("รับที่หน้าร้าน")
                          $("#tpNumber").text("ไม่มี")
                        }else{
                          $("#tpType").text(tpName)
                          if(tpNumber === null || tpNumber === ""){
                            $("#tpNumber").text("ไม่มี")
                          }else{
                            $("#tpNumber").text(tpNumber)
                          }

                        }


                        $("#order tbody").empty();
                        $("#order tbody").append(`
                        <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        `)
                        data.map((order, key) => {
                            let tr = `
                            <tr>
                                <td>${key+1}</td>
                                <td>${order.product_code}</td>
                                <td>${order.product_name}</td>
                                <td>${order.order_amount}</td>
                                <td>${order.product_size} ${order.unit_id}</td>
                                <td>${order.product_price}</td>
                            </tr>
                        `;
                            $("#order tbody").append(tr);

                        })
                        $("#order tbody").children().first().remove();
                        $("#order").DataTable()
                    }
                },
            });

        }
    </script>
