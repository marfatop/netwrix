<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/interfaces/moysklad/imoysklad.php';

class CMoysklad
{
    function syncMoySklad($inputdata){
        //$res['inputdata']=$inputdata;
        $imoysclad= new IMoysklad();
        $events_data=$this->getEventsData($inputdata);
        //$res['$events_data']=$events_data;

        switch ($events_data['type']){
            case 'customerorder':
                $res= $imoysclad->syncCustomerorder($events_data['href']);
                break;
            case 'invoiceout':
                $res= $imoysclad->syncInvoiceout($events_data['href']);
                break;
            case 'demand':
                $res=$imoysclad->syncDemand($events_data['href']);
                break;
            case 'paymentin':
                $res=$imoysclad->syncPaymentin($events_data['href']);
                break;
            case 'salesreturn':
                $res=$imoysclad->syncSalesreturn($events_data['href']);
                break;

        }
        return $res;
    }


    function getEventsData($data){
        $events_data=$data['events'][0];
        $res=[
            'type'=>$events_data['meta']['type'],
            'href'=>$events_data['meta']['href'],
            'action'=>$events_data['action']
            ];
        return $res;
    }
}