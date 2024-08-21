<?php

include("./checkSessiton.php");
$stockStatus = $conn->query("SELECT * FROM tb_stock WHERE stock_status != 0");
$stockStatusData = [];

while ($stock = $stockStatus->fetch_object()) {
    $stockStatusData[] = $stock;
}

$stockExits = [];
foreach ($stockStatusData as $stock) {
    $stockExits[] = $stock->stock_name;
}

$stockDefault = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];

$filteredStockData = array_diff($stockDefault, $stockExits);



?>
<div class="container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-lg-6 main-header">
                <h2 class="ml-5">ระบบการผลิต</h2>
            </div>
            <div class="col-lg-6 breadcrumb-right">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="?p=dashboard"><i class="pe-7s-home"></i></a></li>
                    <li class="breadcrumb-item active">ระบบการผลิต </li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid" style="background-color: #fdfeff !important;">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <h3>สถานะการผลิต</h3>
                <div>
                    <ul>
                        <li class="d-flex ">
                            <div style=" width:1rem;height:1rem;" class="bg-danger">
                            </div>
                            <h6 class="mx-2">ว่าง</h6>
                        </li>
                        <li class="d-flex ">
                            <div style=" width:1rem;height:1rem;" class="bg-warning">
                            </div>
                            <h6 class="mx-2">กำลังผลิต</h6>
                        </li>
                        <li class="d-flex ">
                            <div style=" width:1rem;height:1rem;" class="bg-success">
                            </div>
                            <h6 class="mx-2">ผลิตสำเร็จ</h6>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row ">
                <?php
                for ($i = 1; $i < 13; $i++) {
                    $stockColor = "bg-danger";
                    foreach ($stockStatusData as $key => $stock) {
                        if ($stock->stock_name == $i) {
                            if ($stock->stock_status == 1) {
                                $stockColor = "bg-warning";
                            } else if ($stock->stock_status == 2) {
                                $stockColor = "bg-success";
                            } else {
                                $stockColor = "bg-danger";
                            }
                        }
                    }
                ?>
                    <div class="col-md-2 <?php echo $stockColor; ?>  card m-3" style="padding:1rem 0px 1rem 0px!important;border-radius:15px;cursor: pointer;">
                        <div class="d-flex justify-content-center my-3">
                            <h3 class="font-weight-bold" style="font-family: 'Courier New', Courier, monospace;"><?php echo $i; ?></h3>
                        </div>
                    </div>

                <?php } ?>
            </div>
        </div>
    </div>



    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">

                <div class="mb-3 float-right">
                    <button class="btn btn-primary mx-2" type="button" data-toggle="modal" data-target="#addCreateProductModal" onclick="addStock()">เพิ่มการผลิต</button>
                </div>

                <h3>ตารางการผลิตปุ๋ยมูลไส้เดือน</h3>
                <div class="table-responsive">
                    <table class="display" id="basic-1">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>โซน</th>
                                <th>วันแรกของการผลิต</th>
                                <th>วันสุดท้ายของการผลิต</th>
                                <th>สถานะการผลิต</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($stockStatusData as $key => $stock) { ?>
                                <tr>
                                    <td><?php echo $key + 1; ?></td>
                                    <td><?php echo $stock->stock_name; ?></td>
                                    <td><?php echo $stock->stock_start; ?></td>
                                    <td><?php echo $stock->stock_end; ?></td>
                                    <td>
                                        <?php if ($stock->stock_status == 1) {
                                            echo 'กำลังผลิต';
                                        } elseif ($stock->stock_status == 2) {
                                            echo 'ผลิตสำเร็จ';
                                        }

                                        ?>
                                    </td>
                                    <td>
                                        <button onclick="changeStatus('<?php echo $stock->stock_id; ?>')" class="btn btn-info">เปลี่ยนสถานะ</button>
                                        <button onclick="editStock('<?php echo $stock->stock_id; ?>','<?php echo $stock->stock_name; ?>','<?php echo $stock->stock_start; ?>','<?php echo $stock->stock_end; ?>')" data-toggle="modal" data-target="#addCreateProductModal" class="btn btn-primary" type="button">แก้ไข</button>
                                        <button onclick="deleteStock('<?php echo $stock->stock_id; ?>')" class="btn btn-danger" type="button">ลบ</button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="addCreateProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductStockModal" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStockTitle">เพิ่มการผลิต</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form class="stock-validation" action="action/ac_stock.php?ac=addStock" id="addStock" novalidate="">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class=" col-md-12 form-group">
                                <select class="custom-select" name="stockName" id="stockName" required="">
                                    <option value="">เลือกโซน</option>
                                    <?php
                                    foreach ($filteredStockData as $key => $zone) {
                                    ?>
                                        <option value="<?php echo $zone; ?>"><?php echo $zone; ?></option>
                                    <?php } ?>
                                </select>
                                <div class="invalid-feedback">โปรดเลือกโซนที่จะทำการผลิต!</div>
                            </div>
                        </div>


                        <div class="form-row">
                            <div class="col-md-12 mb-3 ">
                                <label for="">วันแรกที่ทำการผลิต</label>
                                <input name="stockStart" class="form-control digits" id="stockStart" placeholder="" type="datetime-local" required="">
                                <input class="form-control " id="stockQuestion" hidden placeholder="" type="text">
                                <input class="form-control " name="userBy" id="userBy" value="<?php echo $_SESSION['user_id']; ?>" hidden placeholder="" type="text">
                                <input class="form-control " id="stockId" hidden name="stockId" placeholder="" type="text">
                                <div class="invalid-feedback">โปรดเลือกวันที่เริ่มทำการผลิต</div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-12 mb-3 ">
                                <label for="">วันสุดท้ายที่ทำการผลิต</label>
                                <input name="stockEnd" class="form-control digits" id="stockEnd" placeholder="" type="datetime-local" required="">
                                <div class="invalid-feedback">โปรดเลือกวันสุดท้ายที่ทำการผลิต</div>
                            </div>
                        </div>


                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" onclick="$('#addProductStockModal').trigger('reset')" type="button" data-dismiss="modal">ยกเลิก</button>
                        <button class="btn btn-primary" type="submit">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</div>
<script>
    function addStockWithId(stockName) {
        $("#addStockTitle").text("เพิ่มการผลิต");
        $("#addStock").attr('action', 'action/ac_stock.php?ac=addStock')
        $("#stockQuestion").val("คุณต้องเพิ่มการผลิตนี้หรือไม่?")
        $("#stockName").val(stockName)
        $("#stockStart").val("")
        $("#stockEnd").val("")
    }

    function addStock() {
        $("#addStockTitle").text("เพิ่มการผลิต");
        $("#addStock").attr('action', 'action/ac_stock.php?ac=addStock')
        $("#stockQuestion").val("คุณต้องเพิ่มการผลิตนี้หรือไม่?")
        $("#stockName").val("")
        $("#stockStart").val("")
        $("#stockEnd").val("")
    }

    function editStock(stockId, stockName, stockStart, stockEnd) {
        $.ajax({
            url: `action/ac_stock.php?ac=getStock&stockId=${stockId}`,
            type: "GET",
            data: {
                stockId
            },
            success: function(res) {
                let {
                    status,
                    data
                } = JSON.parse(res);

                $("#stockName").empty();
                $("#stockName").append(`<option value="">เลือกโซน</option>`);
                Object.values(data).map((option) => {
                    let opt = `<option value="${option}">${option}</option>`;
                    $("#stockName").append(opt);
                })


                $("#addStockTitle").text("แก้ไขการผลิต");
                $("#addStock").attr('action', 'action/ac_stock.php?ac=editStock')
                $("#stockQuestion").val("คุณต้องการแก้ไขการผลิตนี้หรือไม่?")
                $("#stockId").val(stockId)
                $("#stockName").val(stockName)
                $("#stockStart").val(stockStart)
                $("#stockEnd").val(stockEnd)

            },
        });

    }

    function deleteStock(stockId) {
        Swal.fire({
            icon: "question",
            title: "คุณต้องการลบการผลิตนี้หรือไม่?",
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: "ใช่",
            denyButtonText: "ยกเลิก",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `action/ac_stock.php?ac=deleteStock&stockId=${stockId}&userBy=<?php echo $_SESSION['user_id']; ?>`,
                    type: "POST",
                    data: {
                        stockId
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


    function changeStatus(stockId) {
        Swal.fire({
            icon: "question",
            title: "คุณต้องการเปลี่ยนสถานะการผลิตหรือไม่?",
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: "ใช่",
            denyButtonText: "ยกเลิก",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `action/ac_stock.php?ac=changeStatus&stockId=${stockId}&userBy=<?php echo $_SESSION['user_id']; ?>`,
                    type: "POST",
                    data: {
                        stockId
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