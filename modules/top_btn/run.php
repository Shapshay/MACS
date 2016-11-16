<?php
$moduleName = "top_btn";

# MAIN ##################################################################################

$url_ok = '/'.getItemCHPU(2175, 'pages');
$tpl->assign("URL_OK", $url_ok);

$url_err = '/'.getItemCHPU(2174, 'pages');
$tpl->assign("URL_ERR", $url_err);

$tpl->assign(strtoupper($moduleName), '');
?>