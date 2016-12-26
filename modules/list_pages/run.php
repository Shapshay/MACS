<?php
# SETTINGS #############################################################################
$moduleName = "list_pages";
$prefix = "./modules/".$moduleName."/";

$tpl->define(array(
    $moduleName => $prefix . $moduleName.".tpl",
    $moduleName . "page_rows" => $prefix . "page_rows.tpl",
    $moduleName . "main" => $prefix . "main.tpl",
));
# MAIN #################################################################################

$rows = $dbc->dbselect(array(
        "table"=>"pages",
        "select"=>"id, title",
        "where"=>"parent_id=".PAGE_ID,
        "order"=>"sortfield"
    )
);
$numRows = $dbc->count;
if ($numRows > 0) {
    foreach($rows as $row){
        $url = "/".getItemCHPU($row['id'], 'pages');
        $tpl->assign("LIST_URL", $url);
        $tpl->assign("LIST_TITLE", $row['title']);

        $tpl->parse("LIST_ROWS", ".".$moduleName."page_rows");
    }
    $tpl->parse(strtoupper($moduleName), ".".$moduleName."main");
}
else{
    $tpl->assign(strtoupper($moduleName), "");
}