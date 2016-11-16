<?php
$moduleName = "hello";

# MAIN ##################################################################################
session_name('SID');
@session_start();

$tpl->assign(strtoupper($moduleName), $_SESSION['name']);
?>