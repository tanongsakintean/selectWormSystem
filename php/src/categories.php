<?php
include "./checkSessiton.php";

$categories = $conn->query("SELECT * FROM tb_categories  ");
$categoriesData = [];
while ($categorie = $categories->fetch_object()) {
    $categoriesData[] = $categorie;
}
?>

<div class="container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-lg-6 main-header">
                <h2 class="ml-5">ระบบจัดการหมวดหมู่</h2>
            </div>
            <div class="col-lg-6 breadcrumb-right">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="?p=dashboard"><i class="pe-7s-home"></i></a></li>
                    <li class="breadcrumb-item active">ระบบจัดการหมวดหมู่ </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid" style="background-color: #fdfeff !important;">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h3>หมวดหมู่ทั้งหมด</h3>
                <div class="mb-3 float-right">
                    <button class="btn btn-primary mx-2" type="button" data-toggle="modal" data-target="#categoriesModal" onclick="createCategories()">เพิ่มหมวดหมู่เข้าระบบ</button>
                </div>
                <div class="table-responsive">
                    <table class="display" id="basic-1">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ชื่อหมวดหมู่</th>
                                <th>ประเภท</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (
                                $categoriesData
                                as $key => $categories
                            ) { ?>
                                <tr>
                                    <td><?php echo ++$key; ?></td>
                                    <td><?php echo $categories->name; ?></td>
                                    <td><?php echo $categories->type; ?></td>
                                    <td>
                                        <button data-toggle="modal" data-target="#categoriesModal" onclick="edtiCategories('<?php echo $categories->category_id; ?>','<?php echo $categories->name; ?>','<?php echo $categories->type; ?>')" class="btn btn-primary" type="button">แก้ไข</button>
                                        <button onclick="deleteCategories('<?php echo $categories->category_id; ?>')" class="btn btn-danger" type="button">ลบ</button>
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
                    <h5 class="modal-title" id="categoriesTitle">แก้ไขหมวดหมู่</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form class="categories-validation" action="action/ac_categories.php?ac=edtiCategories" id="categoriesForm" novalidate="">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="validationCustom01">ชื่อหมวดหมู่</label>
                                <input name="name" class="form-control" id="name" type="text" placeholder="" required="">
                                <input name="categoryId" class="form-control" id="categoryId" type="text" placeholder="" hidden>
                                <input name="userBy" hidden value="<?php echo $_SESSION[
                                    "user_id"
                                ]; ?>" class="form-control" id="userBy" type="text" placeholder="">
                                <input hidden class="form-control" id="categoriesQuestion" type="text" placeholder="">
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
                        <button class="btn btn-secondary" onclick="$('#categoriesForm').trigger('reset')" type="button" data-dismiss="modal">ยกเลิก</button>
                        <button class="btn btn-primary" type="submit">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function createCategories() {
        $("#categoriesForm").attr("action", "action/ac_categories.php?ac=addCategories")
        $("#categoriesQuestion").val("คุณต้องการเพิ่มหมวดหมู่หรือไม่?")
        $("#categoriesTitle").text("เพิ่มหมวดหมู่");
        $("#categoryId").val("");
        $("#type").val("");
        $("#name").val("");
    }

    function edtiCategories(categoryId, name,type) {
        $("#categoriesForm").attr("action", "action/ac_categories.php?ac=edtiCategories")
        $("#categoriesQuestion").val("คุณต้องการแก้ไขหมวดหมู่หรือไม่?")
        $("#categoriesTitle").text("แก้ไขหมวดหมู่");
        $("#categoryId").val(categoryId);
        $("#type").val(type);
        $("#name").val(name);
    }


    function deleteCategories(categoriesId) {
        let url = "";
        Swal.fire({
            icon: "question",
            title: "คุณต้องการลบหมวดหมู่นี้หรือไม่?",
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: "ใช่",
            denyButtonText: "ยกเลิก",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `action/ac_categories.php?ac=deleteCategories&categoryId=${categoriesId}&userBy=<?php echo $_SESSION[
                        "user_id"
                    ]; ?>`,
                    type: "POST",
                    data: {
                        categoriesId,
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
