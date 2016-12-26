{DB_RESULT}
<form method="post" id="CreateTableFrm">
<p>
    <label>Название таблицы (на английском, без пробелов)</label>
    <input class="text-input medium-input" type="text" id="db_table" name="db_table" value="" />
</p>
<p><button type="button" class="button" onclick="CreateField();">Добавить поле</button></p>
<table id="fields_table">
<thead>
<tr>
    <th>Название поля (на английском, без пробелов)</th>
    <th>Тип содержимого поля</th>
    <th>Значение по умолчанию</th>
    <th>Удалить поле</th>
</tr>
</thead>
<tbody>
<tr id="field_0">
    <td><input class="text-input small-input field_name" type="text" id="field_name" name="field_name[0]" value="field_name0" /></td>
    <td>
        <select class="field_type" id="field_type" name="field_type[0]" onchange="ChangeFieldType('field_0');">
            {FIELD_TYPES}
        </select>
    </td>
    <td><input class="text-input small-input field_default" type="text" id="field_default" name="field_default[0]" value="0" /></td>
    <td><a href="javascript:DelField('field_0');" title="Delete"><img src="images/cross.png" alt="Delete" /></a></td>
</tr>
</tbody>
</table>
<p><button type="button" class="button" onclick="CreateTable();">Создать таблицу</button></p>
</form>


		