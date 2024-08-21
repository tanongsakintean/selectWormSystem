<?php

if (!isset($_SESSION['ses_id']) || $_SESSION['ses_id'] != session_id()) {
    echo "<script>window.location.replace('login.php')</script>";
}
