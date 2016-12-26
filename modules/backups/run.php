<?php
# SETTINGS #############################################################################
$moduleName = "backups";
$prefix = "./modules/".$moduleName."/";

$tpl->define(array(
    $moduleName => $prefix . $moduleName.".tpl",
    $moduleName . "page_rows" => $prefix . "page_rows.tpl",
    $moduleName . "main" => $prefix . "main.tpl",
    $moduleName . "html" => $prefix . "html.tpl",
));
# MAIN #################################################################################
$tpl->parse("META_HTML", ".".$moduleName."html");
$rows = $dbc->dbselect(array(
        "table"=>"backups",
        "select"=>"*",
        "where"=>"user_id='".VER_ID."'",
        "order"=>"date_back DESC"
    )
);
$dir = 'backups/backups_'.VER_ID;
//echo $dbc->outsql;
$numRows = $dbc->count;
if ($numRows > 0) {
    $cur_m = false;
    foreach($rows as $row){
        $url = $dir."/".$row['name_back'];
        $tpl->assign("BACK_URL", $url);
        $tpl->assign("BACK_ID", $row['id']);
        $tpl->assign("BACK_DATE", date("d-m-Y H:i:s", strtotime($row['date_back'])));
        $tpl->assign("BACK_FILE", $row['name_back']);

        $tpl->parse("BACK_ROWS", ".".$moduleName."page_rows");
    }
    $tpl->parse(strtoupper($moduleName), ".".$moduleName."main");
}
else{
    $tpl->assign(strtoupper($moduleName), "");
}