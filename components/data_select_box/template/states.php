<?php
//$GLOBALS['scripts'][]="templates/".basename(__DIR__)."/script.js";
?>
<div class="data_select_box-container <?=$template_name?>">
    <? $dasabled=$params['disabled']===true ? 'disabled' : null;  ?>
    <select <?=$dasabled?> name="data_select_box" id="data_select_box_<?=$template_name?>" data-column="states_covered" data-forquery="true">
        <option value="">Выберите штат</option>
        <? foreach ($arrResult as $index => $item):?>
            <option value=<?=$item['short_name']?>><?=$item['name']?></option>
        <?endforeach;?>

    </select>
</div>
