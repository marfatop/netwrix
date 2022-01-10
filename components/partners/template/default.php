<?php
//$GLOBALS['scripts'][]="templates/".basename(__DIR__)."/script.js";
?>
<div class="main_component-container">
    <? if (!empty($arrResult)): ?>
        <? foreach ($arrResult as $index => $item) : ?>
            <div class="main_component-item">
                <div class="main_component-item-box1">
                    <div class="main_component-item-logo">
                        <img src="<?= $item['logo'] ?>" alt="<?= $item['company'] ?>">
                    </div>
                </div>
                <!--   item         -->
                <div class="main_component-item-box2">
                    <div class="main_component-item-name">
                        <h3><?= $item['company'] ?></h3>
                    </div>
                    <div class="main_component-item-adress">
                        <span><?= $item['address'] ?></span>
                    </div>
                </div>
                <!--   item         -->
                <div class="main_component-item-box3">
                    <div class="main_content-item-body">
                        <div class="main_component-item-site">
                            <a href="<?= $item['website'] ?>" target="_blank">website</a>
                        </div>
                        <div class="main_component-item-phone">
                            <span><?= $item['phone'] ?></span>
                        </div>
                    </div>

                </div>
                <!--   item         -->
                <div class="main_component-item-box4">
                    <div class="main_component-item-status">
                        <span><?= $item['status'] ?></span>
                    </div>
                </div>
            </div>
        <? endforeach; ?>
    <?else:?>
    <div class="main_component-item">
        <p>Your search parameters did not match any partners.</p>
        <p>Please try different search.</p>
    </div>
    <? endif; ?>
    <div>

            <pre>
                <? //=print_r($arrResult, true)?>
            </pre>
        <!--    <select name="data_select_box" id="data_select_box">-->
        <!--        <option value="">DAta</option>-->
        <!--        --><? // foreach ($arr_result as $index => $item):?>
        <!--            <option value="">--><? //=$item?><!--</option>-->
        <!--        --><? //endforeach;?>
        <!---->
        <!--    </select>-->
    </div>
</div>