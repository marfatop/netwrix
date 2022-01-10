<?php
//$GLOBALS['scripts'][]="templates/".basename(__DIR__)."/script.js";
?>
<div class="input_list_box-container">
    <input list="countries_covered" name="input_select_box" id="data_select_box_<?=$template_name?>" data-column="countries_covered" data-forquery="true" placeholder="Country">
       <datalist id="countries_covered">
        <option value="">COUNRTY</option>
        <? foreach ($arrResult as $index => $item):?>
            <option value="<?=$item['name']?>" label="<?=$item['short_name']?>" data-country_id="<?=$item['country_id']?>"></option>
        <?endforeach;?>
       </datalist>


</div>
