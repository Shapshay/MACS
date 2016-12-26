<?php
/**
 * Created by PhpStorm.
 * User: Skiv
 * Date: 23.12.2016
 * Time: 10:42
 */
error_reporting (E_ALL);
ini_set("display_errors", 1);
require_once("../../adm/inc/BDFunc.php");
$dbc = new BDFunc;
date_default_timezone_set ("Asia/Almaty");

// получение заголовка страницы
function isUser($u_id) {
    global $dbc;
    $row = $dbc->element_find_by_field('users','ver_id',$u_id);
    if($dbc->count>0){
        return true;
    }
    else{
        return false;
    }

}

// чистим текстовую $_GET[]
function SuperSaveGETStr($name) {
    $name = preg_replace("/[^a-zA-Z0-9_]/","",$name);
    return $name;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$u_id = '';
$back = '';
if(isset($_POST['u_id'])){
    $u_id = SuperSaveGETStr($_POST['u_id']);
}
if(isUser($u_id)){
    $sql = "SHOW TABLES LIKE '%_".$u_id."'";
    $tables = $dbc->db_free_query($sql);
    //Цикл по всем таблицам и формирование данных
    foreach($tables as $table){
        $rows = $dbc->dbselect(array(
            "table"=>$table[0],
            "select"=>"*"
        ));
        $num_fields = $dbc->count;
        $back.= 'DROP TABLE '.$table[0].';';
        $rows2 = $dbc->db_free_query('SHOW CREATE TABLE '.$table[0]);
        $row2 = $rows2[0];
        $back.= "\n\n".$row2[1].";\n\n";
        for ($i = 0; $i < $num_fields; $i++){
            foreach($rows as $row){
                $back.= 'INSERT INTO '.$table[0].' VALUES(';
                for($j=0; $j<$num_fields; $j++){
                    $row[$j] = addslashes($row[$j]);
                    $row[$j] = ereg_replace("\n","\\n",$row[$j]);
                    if (isset($row[$j])) { $back.= '"'.$row[$j].'"' ; } else { $back.= '""'; }
                    if ($j<($num_fields-1)) { $back.= ','; }
                }
                $back.= ");\n";
            }
        }
        $back.="\n\n\n";
    }
    //Сохраняем файл
    $dir = '../../backups/backups_'.$u_id;
    $file_name = 'back_'.date("YmdHis");
    $handle = fopen($dir.'/'.$file_name.'.sql','w+');
    fwrite($handle,$back);
    fclose($handle);
    
    // архивируем файл
    $zip = new ZipArchive(); // подгружаем библиотеку zip
    $zip_name = $dir.'/'.$file_name.".zip"; // имя файла
    if($zip->open($zip_name, ZIPARCHIVE::CREATE)!==TRUE){
        $error = "* Sorry ZIP creation failed at this time";
        $out_row['result'] = $error;
    }
    else{
        $zip->addFile($dir.'/'.$file_name.'.sql', $file_name.'.sql'); // добавляем файлы в zip архив
        $zip->close();
        unlink($dir.'/'.$file_name.'.sql');

        // запись в базу
        $dbc->element_create("backups",array(
            "user_id" => $u_id,
            "date_back" => 'NOW()',
            "name_back" => $file_name.".zip"));
        $out_row['result'] = 'OK';
        $out_row['sql'] = $file_name;
    }
}
else{
    $out_row['result'] = 'Err';
}
header("Content-Type: text/html;charset=utf-8");
$result = preg_replace_callback('/\\\u([0-9a-fA-F]{4})/', create_function('$_m', 'return mb_convert_encoding("&#" . intval($_m[1], 16) . ";", "UTF-8", "HTML-ENTITIES");'),json_encode($out_row));
echo $result;