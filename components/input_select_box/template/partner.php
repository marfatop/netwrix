<?php
//$GLOBALS['scripts'][]="templates/".basename(__DIR__)."/script.js";
?>
<div class="data_select_box-container">
    <select name="data_select_box" id="data_select_box_<?=$template_name?>" data-column="status" data-forquery="true">
        <option value="">TYPE</option>
        <? foreach ($arrResult as $index => $item):?>
            <option value=<?=$item['status']?>><?=$item['status']?></option>
        <?endforeach;?>
    </select>
</div>
