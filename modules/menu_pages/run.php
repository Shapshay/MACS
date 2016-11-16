<?php
# SETTINGS #############################################################################
$moduleName = "menu_pages";
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
        "where"=>"parent_id=2 AND view=1",
        "order"=>"sortfield"
    )
);
$numRows = $dbc->count;
if ($numRows > 0) {
    $cur_m = false;
    foreach($rows as $row){
        
        
        if($row['id']==PAGE_ID){
            $tpl->assign("CUR_MM_MODULES", '  current');
        }
        else{
            $tpl->assign("CUR_MM_MODULES", '');
        }
        $url = "/".getItemCHPU($row['id'], 'pages');
        $tpl->assign("PAGE_M_URL", $url);
        $tpl->assign("PAGE_M_TITLE", $row['title']);

        $tpl->parse("PAGE_ROWS", ".".$moduleName."page_rows");
    }
    $tpl->parse(strtoupper($moduleName), ".".$moduleName."main");
}
else{
    $tpl->assign(strtoupper($moduleName), "");
}