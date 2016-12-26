<?php
# SETTINGS #############################################################################
$moduleName = "db_gen";
$prefix = "./modules/".$moduleName."/";
$tpl->define(array(
		$moduleName => $prefix . $moduleName.".tpl",
		$moduleName . "table_row" => $prefix . "table_row.tpl",
        $moduleName . "html" => $prefix . "html.tpl",
	    $moduleName . "main" => $prefix . "main.tpl",
));
# MAIN #################################################################################
$tpl->parse("META_HTML", ".".$moduleName."html");
$result = '';
$result_err = false;
if(isset($_POST['db_table'])){
    $sql_fields = '';
    //print_r($_POST);
    $table = SuperSaveGETStr($_POST['db_table']);
    if($table!='') {
        foreach ($_POST['field_name'] as $k => $v){
            $field = SuperSaveGETStr($v);
            if($field!='') {
                $field_type = SuperSaveGETStr($_POST['field_type'][$k]);
                $field_default = SuperSaveGETStr($_POST['field_default'][$k]);
                switch ($field_type){
                    case 'int':
                        $sql_fields.='`'.$field.'` int(10) DEFAULT \''.$field_default.'\',';
                        break;
                    case 'double':
                        $sql_fields.='`'.$field.'` double(10) DEFAULT \''.$field_default.'\',';
                        break;
                    case 'varchar':
                        $sql_fields.='`'.$field.'` varchar(256) DEFAULT \''.$field_default.'\',';
                        break;
                    case 'text':
                        $sql_fields.='`'.$field.'` text DEFAULT \''.$field_default.'\',';
                        break;
                    case 'datetime':
                        $sql_fields.='`'.$field.'` datetime DEFAULT \'0000-00-00 00:00:00\',';
                        break;
                    case 'tinyint':
                        $sql_fields.='`'.$field.'` tinyint(2) unsigned DEFAULT \''.$field_default.'\',';
                        break;
                }
            }
            else{
                $result = 'Название поля только лат.буквы и цифры !';
                $result_err = true;
            }
        }

        $sql = 'CREATE TABLE `'.$table.'_'.VER_ID.'` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              '.$sql_fields.'
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
            ';

    }
    else{
        $result = 'Название таблицы только лат.буквы и цифры !';
        $result_err = true;
    }

    if(!$result_err && $sql_fields!=''){
        $dbc->db_free_del($sql);
        header("Location: http://".$_SERVER['HTTP_HOST']."/konstruktor_tablic_bd/?act=1");
    }
}

if(isset($_GET['act'])){
    $tpl->assign("DB_RESULT", '<div class="notification success png_bg">
        <div>
            Таблица успешно создана. Для ее просмотра и редактирования перейдите в раздел <a href="http://'.$_SERVER['HTTP_HOST'].'/redaktirovanie_tablic_bd">"Редактирование таблиц БД"</a>.
        </div>
        </div>');
}
else{
    $tpl->assign("DB_RESULT", '');
}

if($result_err){
    $tpl->assign("DB_RESULT", '<div class="notification error png_bg">
        <div>
            Ошибка создания ! Неверные параметры таблицы.
        </div>
        </div>');
}


$field_types = '<option value="int">Числовое (целые числа)</option><option value="double">Числовое (числа с точкой)</option><option value="varchar">Текст (до 256 символов)</option><option value="text">Текст (большой)</option><option value="datetime">Дата и время</option><option value="tinyint">Логическое (0 или 1)</option>';
$tpl->assign("FIELD_TYPES", $field_types);

$tpl->parse(strtoupper($moduleName), ".".$moduleName."main");
?>