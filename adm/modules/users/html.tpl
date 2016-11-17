<script src="inc/ckeditor/ckeditor.js"></script>
<script src="inc/ckfinder/ckfinder.js"></script>
<script>
function openPopup(id) {
	var finder = new CKFinder();
	finder.selectActionData = "container";
	finder.selectActionFunction = function( fileUrl, data ) {
		$('#'+id).val(fileUrl);
	}
	finder.popup();
}
</script>

<link href="inc/will_pickdate/style.css" media="screen" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="inc/will_pickdate/jquery.mousewheel.js"></script>
<script type="text/javascript" src="inc/will_pickdate/will_pickdate.js"></script>




<script>
$(document).ready(function() {
    $('#stat_table').DataTable( {
        "lengthMenu": [[15, 100, 500, -1], [15, 100, 500, "Все"]]
    } );
} );
function addVal(){
	$('#item_id').val(0);
	$('#item2_id').val(0);
	$('#name').val('');
    $('#login').val('');
    $('#password').val('');
    $('#page_id').val(1);

	$('#tab2_link').click();
}
function edtVal(id){
	$.post("modules/users/item.php", {id:id}, 
		function(data){
			//alert(data);
			var obj = jQuery.parseJSON(data);
			if(obj.result=='OK'){
				$('#item_id').val(id);
				$('#item2_id').val(id);
				$('#name').val(obj.name);
				$('#login').val(obj.login);
				$('#password').val(obj.password);
				$('#page_id').val(obj.page_id);
                getRole(id);
				$('#tab2_link').click();
			}
			else{
				swal("Ошибка Сервера!", "Объект ненайден !", "error"); 
				//alert(data);
			}
		});
}
function getRole(id){
	$.post("modules/users/get_role.php", {id:id}, 
		function(data){
			//alert(data);
			var obj = jQuery.parseJSON(data);
			if(obj.result=='OK'){
				if(obj.count>0){
					var role_arr = jQuery.makeArray(obj.role);
					for(i=0;i<role_arr.length;i++){
						$("#role"+obj.role[i]).attr('checked', true);
					}
				}
			}
			else{
				swal("Ошибка Сервера!", "Объект ненайден !", "error"); 
				//alert(data);
			}
		});
}
function delVal(id){
	swal({   
		 title: "Удаление записи",   
		 text: "Запись\n"+id+"\nБудет удалена !!!",   
		 type: "warning",   
		 showCancelButton: true,   
		 confirmButtonColor: "#DD6B55",   
		 confirmButtonText: "Удалить!",   
		 closeOnConfirm: false 
		 }, 
		 function(){   
			$.post("modules/users/del.php", {id:id}, 
				function(data){
					var obj = jQuery.parseJSON(data);
					if(obj.result=='OK'){
						swal("Успешно", "Запись удалена.", "success"); 
						setTimeout('window.location.reload()', 2000);

					}
					else{
						swal("Ошибка Сервера!", "Объект ненайден !", "error"); 
					}
				});
	});
}
</script>