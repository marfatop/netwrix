<?php
//$GLOBALS['scripts'][]="templates/".basename(__DIR__)."/script.js";
?>
<div class="data_select_box-container">
    <select name="data_select_box" id="data_select_box" data-forquery="true">
        <option value="">Data default</option>
        <? foreach ($arr_result as $index => $item):?>
            <option value=""><?=$item?></option>
        <?endforeach;?>

    </select>
</div>
