<?php
//$base=$_SERVER['DOCUMENT_ROOT'].'/';

$GLOBALS['scripts'][] = "templates/" . basename(__DIR__) . "/script.js";
?>
<section class="top container">
    <div class="row">
        <div class="col-md-6">
            <div class="logo"><img src="/upload/Netwrix_logo_120x25.png" alt="logo" width="120"></div>
        </div>
    </div>
</section>
<section class="section-banner">
    <div class="container">
        <div class="section-title">
            <h1>Netwrix Partner Locator</h1>
            <p>Hundreds of Netwrix partners around the world are standing by to help you.</p>
            <p>With our Partner Locator you can easily find the list of authorized partners in your area.</p>
        </div>
        <div class="section-search">
            <div class="section-search-container">
                <div class="input-group mb-3">
                    <input type="search" class="form-control section-search-input" placeholder="Search" aria-describedby="search-btn">
                    <span class="input-group-text" id="search-btn"><i class="fa fa-search"></i></span>
                </div>
<!--                <input class="input-search" type="search">-->
<!--                <span class="icon"><i class="fa fa-search"></i></span>-->
            </div>
            <div class="section-search-list">
                <!--   item        -->
                <? $params = [
                    'tbl' => 'partner_locator',
                    'fields' => ['status'],
                    'sort_field' => 'status',
                    'sort_direction' => 'asc',

                    'template' => 'partner'
                ] ?>
                <?= $view->showComponent('data_select_box', $params); ?>

                <!--   /item        -->
                <!--   item        -->

                <? $params = [
                    'tbl' => 'loc_country',
                    'fields' => ['country_id', 'name', 'short_name'],
                    'sort_field' => 'name',
                    'sort_direction' => 'asc',
                    'condition' => [],
                    'template' => 'country'
                ] ?>
                <?= $view->showComponent('input_select_box', $params); ?>

                <!--   /item        -->
                <!--   item        -->

                <? $params = [
                    'tbl' => 'loc_state',
                    'fields' => ['name', 'short_name'],
                    'sort_field' => 'name',
                    'sort_direction' => 'asc',
                    'condition' => [],
                    'template' => 'states',
                    'disabled' => true
                ] ?>
                <?= $view->showComponent('data_select_box', $params); ?>

                <!--   /item        -->
            </div>
        </div>
    </div>
</section>

<section class="section-main container">

        <? $params = [
            'tbl' => 'partner_locator',
            'fields' => ['*'],
            'sort_field' => 'company',
            'sort_direction' => 'asc',
            // 'condition'=>["status LIKE 'Distributor'"],
            //  'template'=>''
        ] ?>
        <?= $view->showComponent('partners', $params); ?>
</section>
