<div class="iconsidebar-menu">
    <div class="sidebar">
        <ul class="iconMenu-bar custom-scrollbar">
            <?php if ($_SESSION['user_role'] == 2) {  ?>
                <li class="open"><a class="bar-icons" href="index.php">
                        <!--img(src='../assets/images/menu/home.png' alt='')--><i class="pe-7s-home"></i><span>หน้าหลัก </span></a>
                </li>

                <li><a class="bar-icons" href="?p=user"><i class="pe-7s-user"></i><span>ระบบพนักงาน</span></a>
                <?php } ?>
                <li class="<?php if ($_SESSION['user_role'] != 2) {
                                echo "open";
                            } ?>"><a class="bar-icons " href="?p=stock"><i class="pe-7s-portfolio"></i><span>ระบบการผลิต</span></a>

                </li>
                <li><a class="bar-icons" href="?p=products"><i class="pe-7s-server"></i><span>ระบบคลัง</span></a>

                </li>

                <li><a class="bar-icons" href="?p=payment"><i class="pe-7s-graph3"></i><span>ระบบการขาย</span></a> </li>
                <?php if ($_SESSION['user_role'] == 2) {  ?>
                    <li><a class="bar-icons" href="?p=monitor"><i class="pe-7s-graph3"></i><span>ระบบรายงานผล</span></a> </li>
                <?php } ?>
        </ul>
    </div>
</div>