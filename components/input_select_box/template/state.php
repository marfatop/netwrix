<?php
//$GLOBALS['scripts'][]="templates/".basename(__DIR__)."/script.js";
?>
<div class="data_select_box-container">
    <select disabled name="data_select_box" id="data_select_box_<?=$template_name?>" data-column="state_covered" data-forquery="true">
        <option value="">Выберите штат</option>
        <? foreach ($arrResult as $index => $item):?>
            <option value=<?=$item['short_name']?>><?=$item['name']?></option>
        <?endforeach;?>

    </select>
</div>
