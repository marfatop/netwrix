<?php
require_once "header.php";
?>

<!--<div class="container">-->
<!--    <div class="col-md-3">-->
<!--        <p>Меню</p>-->
<!--        <ul>-->
<!--            <li><a href="config">Конфиг</a></li>-->
<!--            <li><a href="lastdata">Последние данные</a></li>-->
<!--            <li><a href="error">Ошибки</a></li>-->
<!--            <li><a href="reports">Отчеты</a></li>-->
<!--        </ul>-->
<!--    </div>-->



            <?=$display?>
<!--</div>-->

<?php
//$q = array
//(
//    'post' => array
//    (
//        'data' => array
//        (
//            'merchantId' => 6554,
//            'shipments' => array
//            (
//                0 => array
//                (
//                    'shipmentId' => 858629124,
//                    'shipmentDate' => '2022 - 01 - 12T10:29:17 + 03:00',
//                    'items' => array
//                    (
//                        0 => array
//                        (
//                            'itemIndex' => 1,
//                            'goodsId' => '100023036985',
//                            'offerId' => '100020',
//                            'itemName' => ' Сумка - переноска Ladioli 28x45x28см М - 90 красный, розовый, синий, белый',
//                            'price' => '3150',
//                            'finalPrice' => '3150',
//                            'discounts' => [],
//                            'quantity' => 1,
//                            'taxRate' => 'NOT',
//                            'reservationPerformed' => 1,
//                            'isDigitalMarkRequired' => '',
//                        )
//                    ),
//                    'label' => array
//                    (
//                        'deliveryId' => 825134640,
//                        'region' => 'Москва',
//                        'city' => 'Москва',
//                        'address' => 'г Москва, пр - кт Мира, д 62 стр 1',
//                        'fullName' => ' Тестович Тест Тестов',
//                        'merchantName' => 'ООО "БУММАРКЕТ"',
//                        'merchantId' => 6554,
//                        'shipmentId' => 858629122,
//                        'shippingDate' => '2022 - 01 - 13T18:00:00 + 03:00',
//                        'deliveryType' => 'Самовывоз из пункта выдачи',
//                        'labelText' => ''
//                    ),
//                    'shipping' => array
//                    (
//                        'shippingDate' => '2022 - 01 - 13T18:00:00 + 03:00',
//                        'shippingPoint' => 855008,
//                    ),
//
//                    'fulfillmentMethod' => 'FULFILLMENT_BY_MERCHANT',
//                )
//
//            )
//
//        ),
//
//        'meta' => array
//        (
//            'source' => 'OMS'
//        )
//
//    )
//
//);
//
//echo json_encode($q);
?>

<?php
require_once "footer.php";
?>