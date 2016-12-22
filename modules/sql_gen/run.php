<?php
# SETTINGS #############################################################################
$moduleName = "sql_gen";
$prefix = "./modules/".$moduleName."/";
$tpl->define(array(
		$moduleName => $prefix . $moduleName.".tpl",
		$moduleName . "table_row" => $prefix . "table_row.tpl",
        $moduleName . "html" => $prefix . "html.tpl",
));
# MAIN #################################################################################
$tpl->parse("META_HTML", ".".$moduleName."html");

$tpl->parse(strtoupper($moduleName), $moduleName);
?>