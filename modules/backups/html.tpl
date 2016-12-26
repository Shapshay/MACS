<script>
    $(document).ready(function() {
        $('#stat_table').DataTable( {
            "lengthMenu": [[15, 100, 500, -1], [15, 100, 500, "Все"]]
        } );
    } );
    
    function CreateBackUp() {
        $('#waitGear').show();
        var u_id = '{VER_ID}';
        $.post("modules/backups/back.php", {u_id:u_id},
                function(data){
                    //alert(data);
                    var obj = jQuery.parseJSON(data);
                    if(obj.result=='OK'){
                        //$('#waitGear').hide();
                        window.location.reload();
                    }
                    else{
                        swal("Ошибка Сервера!", "Объект ненайден !", "error");
                    }
                });
    }
    function BackRestore(back_id, back_date) {
        var u_id = '{VER_ID}';
        swal({
                title: "Вы уверенны что хотите востановить BackUp?",
                text: "Все данные после '"+back_date+"' будут уничтожены",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Да, востановить!",
                closeOnConfirm: false
            },
            function(){
                $('#waitGear').show();
                $.post("modules/backups/back_restore.php", {u_id:u_id, back_id:back_id},
                        function(data){
                            //alert(data);
                            var obj = jQuery.parseJSON(data);
                            if(obj.result=='OK'){
                                console.log(obj.sql);
                                $('#waitGear').hide();
                                swal("Готово", "Востановлен BackUp за '"+back_date+"'.", "success");
                            }
                            else{
                                swal("Ошибка Сервера!", "Объект ненайден !", "error");
                            }
                        });
            });
    }
    function DelBack(back_id, back_date, el) {
        var u_id = '{VER_ID}';
        swal({
                title: "Вы уверенны что хотите удалить BackUp '"+back_date+"' ?",
                text: "Данная операция необратима",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Да, удалить!",
                closeOnConfirm: false
            },
            function(){
                $('#waitGear').show();
                $.post("modules/backups/back_del.php", {u_id:u_id, back_id:back_id},
                        function(data){
                            //alert(data);
                            var obj = jQuery.parseJSON(data);
                            if(obj.result=='OK'){
                                $('#waitGear').hide();
                                $('#'+el).hide();
                                swal("Готово", "Удален BackUp за '"+back_date+"'.", "success");
                            }
                            else{
                                swal("Ошибка Сервера!", "Объект ненайден !", "error");
                            }
                        });
            });
    }
</script>