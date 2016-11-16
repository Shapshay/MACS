<?php
error_reporting (E_ALL);
ini_set("display_errors", 1);
require_once("adm/inc/BDFunc.php");
require_once("adm/inc/RFunc.php");
$dbc = new BDFunc;
$rfq = new RFunc;
require_once('adm/inc/simple_html_dom.php');

//############### USERS #############################################

function getRootID($usrname) {
	global $dbc;
	$resp = $dbc->element_find_by_field('roots','login',$usrname);
	return $resp['id'];
}

function getRootName($usrname) {
	global $dbc;
	$resp = $dbc->element_find_by_field('roots','login',$usrname);
	return $resp['name'];
}

function isRolePage($role_id,$page_id) {
	global $dbc;
	$rows = $dbc->dbselect(array(
			"table"=>"r_page_role",
			"select"=>"id",
			"where"=>"page_id = '".$page_id."' AND role_id=".$role_id,
			"limit"=>"1"
			)
		);
	$numRows = $dbc->count; 
	if ($numRows > 0) {
		$row = $rows[0];
		return $row['id'];
	}
	else{
		return 0;
	}
}

//############### ROUTING ###########################################

// получение настроек страницы
function getPageMenuTpl($menu_id = 0, $type='') {
	global $rfq;
	global $dbc;
	$page_arr = array();
	if(isset($_SESSION['lgn'])){
		$root = $rfq->get_start_page(ROOT_ID);
		$menu_parent = $root['page_id'];
	}
	else{
		$menu_parent = 0;
	}
	if($menu_id == 0){
		if($menu_parent==0){
			$row = $dbc->element_find_by_field('pages','start',1);
			$page_id = $row['id'];
			$page_tpl = $row[$type.'template'];
			$page_content = $row['content'];
			$page_title = $row['title'];
			$page_menu = $row['group_id'];
		}
		else{
			$row = $dbc->element_find('pages',$menu_parent);
			$page_id = $row['id'];
			$page_tpl = $row[$type.'template'];
			$page_content = $row['content'];
			$page_title = $row['title'];
			$page_menu = $row['group_id'];
		}
	}
	else{
		$row = $dbc->element_find('pages',$menu_id);
		$page_id = $row['id'];
		$page_tpl = $row[$type.'template'];
		$page_content = $row['content'];
		$page_title = $row['title'];
		$page_menu = $row['group_id'];
	}
	$page_arr['id'] = $page_id;
	$page_arr[$type.'template'] = $page_tpl;
	$page_arr['content'] = $page_content;
	$page_arr['title'] = $page_title;
	$page_arr['group_id'] = $page_menu;
	$page_arr['seo_title'] = $row['seo_title'];
	$page_arr['seo_key'] = $row['seo_key'];
	$page_arr['seo_desc'] = $row['seo_desc'];
	$page_arr['parent_id'] = $row['parent_id'];
	return $page_arr;
}

// получение ID первой вложеной страницы (проверка ее существования)
function getPageFirstChildrenID($page_id) {
	global $dbc;
	$rows = $dbc->dbselect(array(
			"table"=>"pages",
			"select"=>"id",
			"where"=>"parent_id = '".$page_id."'",
			"order"=>"sortfield",
			"limit"=>1
			)
		);
	$numRows = $dbc->count;
	if ($numRows > 0) {
		return $rows[0]['id'];
	}
	return 0;
}

// Возвращает ID родительской машины
function getPageParentID($page_id) {
	global $dbc;
	$rows = $dbc->dbselect(array(
			"table"=>"pages",
			"select"=>"parent_id",
			"where"=>"id = '".$page_id."'",
			"limit"=>1
			)
		);
	$numRows = $dbc->count;
	if ($numRows > 0) {
		return $rows[0]['parent_id'];
	}
	return 0;
}

// получение заголовка страницы
function getPageTitle($page_id) {
	global $dbc;
	$resp = $dbc->element_find('pages',$page_id);
	return $resp['title'];
}

// получаем номер сортировки
function getNewSortfield(){
	global $dbc;
	$rows = $dbc->dbselect(array(
			"table"=>"pages",
			"select"=>"MAX(sortfield) AS num"
			)
		);
	$row = $rows[0];
	$cur_max = $row['num'];
	$newSort = $cur_max + 1;
	return $newSort;
}

// возражает ссылку на страницу
function getPageTitleLink($title, $page_id, $class) {
	$baseURL = 'index.php?menu_id='.$page_id;
	$url = getCodeBaseURL($baseURL);
	$link = '<a href="'.$url.'" class="'.$class.'">'.$title.'</a>';
	return $link;
}

// Цепочка ссылок для страницы PARENT / CHILD / .. / SUBCHILD
function getPagesChains($page_id, $delimiter, $css_class, $uri_params) {
	global $dbc;
	$items = array(1=> array("title" => "", "url" => ""));
	$items[1]['title'] = '<strong>'.getPageTitle($page_id).'</strong>';
	$items[1]['url'] = '';
	$parent_id = getPageParentID($page_id);
	$i = 1;
	while ($parent_id > 0) {
		$row = $dbc->element_find('pages',$parent_id);
		$numRows = $dbc->count; 
		if ($numRows > 0) {
			$row2 = $dbc->element_find('pages',$row['id']);
			$numRows = $dbc->count; 
			if ($numRows > 0) {
				$i++;
				$parent_id = $row2['parent_id'];
				$items[$i]['title'] = $row['title'];
				$url = 'index.php?menu_id='.$row2['id'];
				//if (!empty($uri_params)) $url.= '&'.$uri_params;
				$url = getCodeBaseURL($url);
				$items[$i]['url'] = $url;
			} else { $parent_id = 0; }
		} else { $parent_id = 0; }
	}
	$str = '';
	$items_count = count($items);
	if ($items_count > 1) $items_count = $items_count - 1;
	for ($i = $items_count; $i > 0; $i--) {
		$title = $items[$i]['title'];
		
		if ($i != 1) $str.= '<a href="'.$items[$i]['url'].'" class="'.$css_class.'">'.$title.'</a>';
			else $str.= $title;
		
		if ($i != 1) $str.= '<span class="'.$css_class.'">'.$delimiter.'</span>';
	}
	return $str;
}

//############### STRINGS ###########################################

// модернизированный implode
function string_build($param_array, $operand) {
	$condition_array = array();
	foreach ($param_array as $param) {
		if ($param != '') $condition_array[] = $param;
	}
	$res = implode(" ".$operand." ", $condition_array);
	return $res;
}

// чистим текстовую $_GET[]
function SuperSaveGETStr($name) {
	//$name = preg_replace("/[^a-zA-ZА-Яа-я0-9_]/","",$name);
	$name = preg_replace("/[^a-zA-Z0-9_]/","",$name);
	return $name;
}

//############### CURL ###########################################

// поиск файлов в папках на сервере
function find($dir, $tosearch) { 
	global $file_arr;
	$files = array_diff( scandir( $dir ), Array( ".", ".." ) );     
	foreach( $files as $d ) { 
	    if( !is_dir($dir."/".$d) ) { 
	         if ($d == $tosearch) 
	             $file_arr[] = $dir."/".$d; 
	     } else { 
	         $res = find($dir."/".$d, $tosearch); 
	     } 
	} 
	return $file_arr; 
}

// получение страницы через GET
function get_web_page( $url ){
	$uagent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322)";
	
	$ch = curl_init( $url );
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   // ���������� ���-��������
	curl_setopt($ch, CURLOPT_HEADER, 0);           // �� ���������� ���������
	//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);   // ��������� �� ����������
	curl_setopt($ch, CURLOPT_ENCODING, "");        // ������������ ��� ���������
	curl_setopt($ch, CURLOPT_USERAGENT, $uagent);  // useragent
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120); // ������� ����������
	curl_setopt($ch, CURLOPT_TIMEOUT, 120);        // ������� ������
	curl_setopt($ch, CURLOPT_MAXREDIRS, 10);       // ��������������� ����� 10-��� ���������
	curl_setopt($ch, CURLOPT_COOKIEJAR, "inc/coo.txt");
	curl_setopt($ch, CURLOPT_COOKIEFILE,"inc/coo.txt");
	
	$content = curl_exec( $ch );
	$err     = curl_errno( $ch );
	$errmsg  = curl_error( $ch );
	$header  = curl_getinfo( $ch );
	curl_close( $ch );
	
	$header['errno']   = $err;
	$header['errmsg']  = $errmsg;
	$header['content'] = $content;
	
	return $header;
}

// получение страницы через POST
function post_content ($url,$postdata) {
	$uagent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322)";
	
	$ch = curl_init( $url );
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_ENCODING, "");
	curl_setopt($ch, CURLOPT_USERAGENT, $uagent);  // useragent
	curl_setopt($ch, CURLOPT_TIMEOUT, 120);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
	curl_setopt($ch, CURLOPT_COOKIEJAR, "inc/coo.txt");
	curl_setopt($ch, CURLOPT_COOKIEFILE,"inc/coo.txt");
	
	$content = curl_exec( $ch );
	$err     = curl_errno( $ch );
	$errmsg  = curl_error( $ch );
	$header  = curl_getinfo( $ch );
	curl_close( $ch );
	
	$header['errno']   = $err;
	$header['errmsg']  = $errmsg;
	$header['content'] = $content;
	
	return $header;
}

function checkUser1Clogin($login1C){
	$url = 'http://akk.coap.kz/inc/ajax/mobil_polis.php?code1C='.$login1C;
	$result = get_web_page( $url );
	$j_str = $result['content'];
	$IBAnswer = json_decode($j_str);
    return $IBAnswer;
}

// SOAP объект в массив
function objectToArray($d) {
    if (is_object($d)) {
        $d = get_object_vars($d);
    }
    if (is_array($d)) {
        return array_map(__FUNCTION__, $d);
    }
    else {
        return $d;
    }
}

// SOAP std в массив
function stdToArray($obj){
    $rc = (array)$obj;
    foreach($rc as $key => &$field){
        if(is_object($field))$field = $this->stdToArray($field);
    }
    return $rc;
}

//############### STATISTIC ###########################################

// возращает было ли посещение страницы сайта сегодня с данного IP
function getIPtoSiteStatisticID($ip, $menu, $item_id) {
	global $dbc;
	$rows = $dbc->dbselect(array(
			"table"=>"stat",
			"select"=>"id",
			"where"=>"ip = '".$ip."' AND menu = '".$menu."' AND item_id = '".$item_id."' AND DATE_FORMAT(date, '%Y%m%d') = ".date("Ymd"),
			"limit"=>"1"
			)
		);
	$numRows = $dbc->count; 
	if ($numRows > 0) {
		$row = $rows[0];
		return $row['id'];
	}
	else{
		return 0;
	}
}

//############### CLIENTS ###########################################

function getClientIDfromCode($code_1C) {
    global $dbc;
    $resp = $dbc->element_find_by_field('sto','code_1C',$code_1C);
    if($dbc->count>0){
        return $resp['id'];
    }
    return 0;
}

?>