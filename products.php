<?php
include("./checkSessiton.php");
$products = $conn->query("SELECT * FROM tb_products WHERE product_status = 1 ORDER BY product_id DESC");
$productsData = [];
while ($product = $products->fetch_object()) {
    $productsData[] = $product;
}

$productsLog = $conn->query("SELECT * FROM tb_product_log pl
                            LEFT JOIN tb_products p ON p.product_id = pl.product_id
                            WHERE p.product_status = 1 ORDER BY pl.pl_id DESC ");
$productsLogData = [];
while ($product = $productsLog->fetch_object()) {
    $productsLogData[] = $product;
}



?>
<div class="container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-lg-6 main-header">
                <h2 class="ml-5">ระบบคลัง</h2>
            </div>
            <div class="col-lg-6 breadcrumb-right">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="?p=dashboard"><i class="pe-7s-home"></i></a></li>
                    <li class="breadcrumb-item active">ระบบคลัง </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid" style="background-color: #fdfeff !important;">
    <div class="card">
        <div class="card-body">
            <h3>สินค้าทั้งหมด</h3>
            <div class="row ">
                <?php

                foreach ($productsData as $key => $product) {
                ?>
                    <div class="col-md-2 card bg-primary  m-3" style="padding:1rem 0px 1rem 0px!important;border-radius:15px;">
                        <div class="d-flex justify-content-center my-3">
                            <h4 class="font-weight-bold" style="font-family: 'Courier New', Courier, monospace;"><?php echo $product->product_name; ?></h4>
                        </div>
                        <div class=" mx-2 my-2" style="background-color: white;height:2px;">
                        </div>
                        <div>
                            <div class="d-flex justify-content-center">
                                <h2 class="font-weight-bold"><?php echo $product->product_amount; ?></h2>
                            </div>
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
                    <button class="btn btn-primary mx-2" type="button" data-toggle="modal" data-target="#addProductSystemModal" onclick="createProductSystem()">เพิ่มสินค้าเข้าระบบ</button>
                </div>

                <h3>สินค้าทั้งหมดในระบบ</h3>
                <div class="table-responsive">
                    <table class="display" id="basic-1">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>รหัสสินค้า</th>
                                <th>ชื่อสินค้า</th>
                                <th>ราคา</th>
                                <th>ขนาด</th>
                                <th>หน่วยนับ</th>
                                <th>ประเภท</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $idx = 1;
                            foreach ($productsData as $key => $product) {
                            ?>
                                <tr>
                                    <td><?php echo $idx++ ?></td>
                                    <td><?php echo $product->product_code; ?></td>
                                    <td><?php echo $product->product_name; ?></td>
                                    <td><?php echo $product->product_price; ?></td>
                                    <td><?php echo $product->product_size; ?></td>
                                    <td><?php echo $product->unit_id; ?></td>
                                    <td><?php echo $product->category_id; ?></td>
                                    <td>
                                        <button data-toggle="modal" data-target="#addProductSystemModal" onclick="editProduct('<?php echo $product->product_id; ?>','<?php echo $product->product_name; ?>','<?php echo $product->product_price; ?>','<?php echo $product->product_size; ?>','<?php echo $product->unit_id; ?>','<?php echo $product->category_id; ?>')" class="btn btn-primary" type="button">แก้ไข</button>
                                        <button onclick="deleteProductSystem('<?php echo $product->product_id; ?>')" class="btn btn-danger" type="button">ลบ</button>
                                    </td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                </div>



            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">

                <div class="mb-3 float-right">
                    <button onclick="createProductStock()" class="btn btn-success mx-2" type="button" data-toggle="modal" data-target="#addProductStockModal">เพิ่มสินค้าเข้าคลัง</button>
                </div>

                <h3>สินค้าทั้งหมดในคลัง</h3>
                <div class="table-responsive">
                    <table class="display" id="basic-2">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>รหัสสินค้า</th>
                                <th>ชื่อสินค้า</th>
                                <th>จำนวน</th>
                                <th>วันที่</th>
                                <th>ราคา</th>
                                <th>ขนาด</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $idx = 1;
                            foreach ($productsLogData as $key => $product) {
                            ?>
                                <tr>
                                    <td><?php echo $idx++ ?></td>
                                    <td><?php echo $product->product_code; ?></td>
                                    <td><?php echo $product->product_name; ?></td>
                                    <td><?php echo $product->pl_amount; ?></td>
                                    <td><?php echo $product->pl_created_at; ?></td>
                                    <td><?php echo $product->product_price; ?></td>
                                    <td><?php echo $product->product_size . " " . $product->unit_id; ?></td>
                                    <td>
                                        <button data-toggle="modal" data-target="#addProductStockModal" onclick="editProductStock('<?php echo $product->pl_id; ?>','<?php echo $product->product_id; ?>','<?php echo $product->pl_amount; ?>','<?php echo $product->pl_created_at; ?>')" class="btn btn-primary" type="button">แก้ไข</button>
                                        <button onclick="deleteProductStock('<?php echo $product->pl_id; ?>','<?php echo $product->product_id; ?>')" class="btn btn-danger" type="button">ลบ</button>
                                    </td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                </div>



            </div>
        </div>
    </div>


    <div class="modal fade" id="addProductSystemModal" tabindex="-1" role="dialog" aria-labelledby="addProductSystemModal" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleProductSystem">เพิ่มสินค้าเข้าระบบ</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form class="product-system-validation" action="action/ac_product.php?ac=createProduct" id="addProductSystem" novalidate="">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">ชื่อสินค้า</label>
                                <input name="productName" class="form-control" id="productName" type="text" placeholder="" required="">
                                <input name="productId" hidden class="form-control" id="productId" type="text" placeholder="">
                                <input name="userBy" hidden value="<?php echo $_SESSION['user_id']; ?>" class="form-control" id="userBy" type="text" placeholder="">
                                <input hidden class="form-control" id="question" type="text" placeholder="">
                                <div class="invalid-feedback">โปรดกรอกชื่อสินค้า</div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">ราคาสินค้า</label>
                                <input name="productPrice" class="form-control" id="productPrice" type="number" placeholder="" required="">
                                <div class="invalid-feedback">โปรดกรอกราคาสินค้า</div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">ขนาดสินค้า</label>
                                <input name="productSize" class="form-control" id="productSize" type="number" placeholder="" required="">
                                <div class="invalid-feedback">โปรดกรอกขนาดสินค้า</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationCustom01">หน่วยนับ</label>
                                <input name="productUnit" class="form-control" id="productUnit" type="text" placeholder="" required="">
                                <div class="invalid-feedback">โปรดกรอกหน่วยนับสินค้า</div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">ประเภทสินค้า</label>
                                <input name="productCategory" class="form-control" id="productCategory" type="text" placeholder="" required="">
                                <div class="invalid-feedback">โปรดกรอกประเภทสินค้า</div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" onclick="$('#addProductSystem').trigger('reset')" type="button" data-dismiss="modal">ยกเลิก</button>
                        <button class="btn btn-primary" type="submit">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <div class="modal fade" id="addProductStockModal" tabindex="-1" role="dialog" aria-labelledby="addProductStockModal" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productStockTitle">เพิ่มสินค้าเข้าคลัง</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form class="product-stock-validation" action="action/ac_product.php?ac=addProduct" id="addProductStock" novalidate="">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class=" col-md-12 form-group">
                                <select class="custom-select" name="productId" id="productStockId" required="">
                                    <option value="">เลือกสินค้า</option>
                                    <?php
                                    foreach ($productsData as $key => $product) {                                    ?>
                                        <option value="<?php echo $product->product_id; ?>"><?php echo $product->product_name; ?></option>
                                    <?php } ?>
                                </select>
                                <div class="invalid-feedback">โปรดเลือกสินค้า!</div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">จำนวนสินค้า</label>
                                <input name="productAmount" class="form-control" id="productStockAmount" type="number" placeholder="" required="">
                                <input name="plId" class="form-control" hidden id="plId" type="text" placeholder="">
                                <input name="userBy" class="form-control" value="<?php echo $_SESSION['user_id'] ?>" hidden id="userBy" type="text" placeholder="">
                                <input class="form-control" hidden id="questionStock" type="text" placeholder="">
                                <div class="invalid-feedback">โปรดกรอกจำนวนสินค้า</div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-12 mb-3 ">
                                <label for="">วันที่ผลิต</label>
                                <input name="productStockDate" class="form-control digits" id="productStockDate" placeholder="" type="datetime-local" required="">
                                <div class="invalid-feedback">โปรดเลือกวันที่ทำการผลิต</div>
                            </div>
                        </div>


                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" onclick="$('#addProductStock').trigger('reset')" type="button" data-dismiss="modal">ยกเลิก</button>
                        <button class="btn btn-primary" type="submit">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function deleteProductStock(plId, productId) {
        let url = "";
        Swal.fire({
            icon: "question",
            title: "คุณต้องการลบจำนวนสินค้าหรือไม่?",
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: "ใช่",
            denyButtonText: "ยกเลิก",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `action/ac_product.php?ac=deleteProductStock&plId=${plId}&productId=${productId}&userBy=<?php echo $_SESSION['user_id']; ?>`,
                    type: "POST",
                    data: {
                        plId,
                        productId
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

    function createProductStock() {
        $('#productStockTitle').text('เพิ่มสินค้าเข้าคลัง')
        $("#addProductStock").attr('action', 'action/ac_product.php?ac=addProduct')
        $("#questionStock").val("คุณต้องการเพิ่มสินค้าเข้าคลังหรือไม่?")
        $("#plId").val("");
        $("#productStockAmount").val("");
        $("#productStockId").val("");
        $("#productStockDate").val("");
    }

    function editProductStock(plId, productId, plAmount, productStockDate) {
        $('#productStockTitle').text('แก้ไขสินค้าเข้าคลัง')
        $("#addProductStock").attr('action', 'action/ac_product.php?ac=editProductStock')
        $("#questionStock").val("คุณต้องการแก้ไขสินค้าหรือไม่?")
        $("#plId").val(plId);
        $("#productStockAmount").val(plAmount);
        $("#productStockId").val(productId);
        $("#productStockDate").val(productStockDate);
    }

    function editProduct(productId, productName, productPrice, productSize, productUnit, productCategory) {
        $('#productId').val(productId)
        $('#productName').val(productName)
        $('#productPrice').val(productPrice)
        $('#productSize').val(productSize)
        $('#productUnit').val(productUnit)
        $('#productCategory').val(productCategory)
        $('#titleProductSystem').text('แก้ไขสินค้า')
        $("#addProductSystem").attr('action', 'action/ac_product.php?ac=editProduct')
        $("#question").val("คุณต้องแก้ไขสินค้าหรือไม่?")

    }

    function createProductSystem() {
        $('#titleProductSystem').text('เพิ่มสินค้าเข้าระบบ')
        $("#addProductSystem").attr('action', 'action/ac_product.php?ac=createProduct')
        $("#productName").val("")
        $("#productPrice").val("")
        $("#productSize").val("")
        $("#productUnit").val("")
        $("#productCategory").val("")
        $("#question").val("คุณต้องการเพิ่มสินค้าเข้าระบบหรือไม่?")
    }

    function deleteProductSystem(productId) {
        let url = "";
        Swal.fire({
            icon: "question",
            title: "คุณต้องการลบสินค้าหรือไม่?",
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: "ใช่",
            denyButtonText: "ยกเลิก",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `action/ac_product.php?ac=deleteProduct&productId=${productId}&userBy=<?php echo $_SESSION['user_id']; ?>`,
                    type: "POST",
                    data: {
                        productId
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