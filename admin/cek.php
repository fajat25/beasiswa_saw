<?php
    if (!isset($_SESSION['log']) || empty($_SESSION['user'])) {
        
    } else {
        header("location:login.php");
    }
?>