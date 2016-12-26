<script>
var field_num = 1;
$(function(){

});
function validater_field(field) {
    var pattern = new RegExp(/[0-9a-z_]+$/i);
    return pattern.test(field);
}
function CreateField() {
    var field = '<tr id="field_'+field_num+'">'+
            '<td><input class="text-input small-input field_name" type="text" id="field_name" name="field_name['+field_num+']" value="field_name'+field_num+'" /></td>'+
            '<td>'+
            '<select class="field_type" id="field_type" name="field_type['+field_num+']" onchange="ChangeFieldType(\'field_'+field_num+'\');">'+
            '{FIELD_TYPES}'+
            '</select>'+
            '</td>'+
            '<td><input class="text-input small-input field_default" type="text" id="field_default" name="field_default['+field_num+']" value="0" /></td>'+
            '<td><a href="javascript:DelField(\'field_'+field_num+'\');" title="Delete"><img src="images/cross.png" alt="Delete" /></a></td>'+
            '</tr>';
    $('#fields_table > tbody:last').append(field);
    field_num++;
}
function DelField(field_id) {
    if(field_id!='field_0') {
        $('#' + field_id).remove();
    }
    else{
        swal("Ошибка!", "Нельзя удалять первый элемент !", "error");
    }
}

function ChangeFieldType(el) {
    var f_type = $('#'+el).find('#field_type').val();
    var def_val = '';
    switch (f_type){
        case 'int':
            def_val = 0;
            break;
        case 'double':
            def_val = 0;
            break;
        case 'varchar':
            def_val = '';
            break;
        case 'text':
            def_val = '';
            break;
        case 'datetime':
            def_val = '0000-00-00 00:00:00';
            break;
        case 'tinyint':
            def_val = 0;
            break;
    }
    $('#'+el).find('#field_default').val(def_val);
}

function CreateTable() {
    var send = true;
    var f_names = new Array();
    var f_types = new Array();
    var f_def = new Array();
    var table_name = $('#db_table').val();

    if(!validater_field(table_name)){
        swal("Ошибка!", "Название таблицы только лат.буквы и цифры !", "error");
        send = false;
        return;
    }

    $('.field_name').each(function(i,elem) {
        var cur = $(this).val();
        if($.inArray(cur, f_names)==-1 && cur!='') {
            if(!validater_field(cur)) {
                swal("Ошибка!", "Название поля только лат.буквы и цифры !", "error");
                send = false;
                return;
            }
            else{
                f_names.push(cur);
            }
        }
        else{
            swal("Ошибка!", "Поля немогут иметь одинаковое или пустое значение !", "error");
            send = false;
            return;
        }
    });

    $('.field_type').each(function(i,elem) {
        var cur = $(this).val();
        f_types.push(cur);
    });

    $('.field_default').each(function(i,elem) {
        var cur = $(this).val();
        f_def.push(cur);
    });

    if(send){
        $('#CreateTableFrm').submit();
    }
}
</script>