<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/models/moysklad/mmoysklad.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/models/vieschk/mvieschk.php';
require_once 'entity.php';
require_once 'customerorder.php';
require_once 'invoiceout.php';
require_once 'demand.php';
require_once 'paymentin.php';
require_once 'salesreturn.php';



class IMoysklad
{
    function syncCustomerorder($uri ){
        $res_upd=[];
        $last_number='';
        $flag_setlastnumber=true;
        $mmoySklad=new MMoySklad();

        $expand='?expand=attributes,agent,state';
        $uri=$uri.$expand;

        $entity_data=$mmoySklad->getRequest($uri);
        $customerorder= new Customerorder($entity_data);
        $fields=$customerorder->fields;

        $id_rma='88f742c5-425e-11ec-0a80-0684000170c3';
        $attr_rma=$customerorder->getAttrubuteByID($id_rma, $fields['attributes']);
        //Если заказ RMA - ничего не менять, прервать выполнение скрипта
        if($attr_rma['value']===true){
            return $res_upd['error']['msg']='RMA';
        }

        $id_old_name='700c1c55-5abc-11ec-0a80-00ae00227054';

        $attr_old_name=$customerorder->getAttrubuteByID($id_old_name, $fields['attributes']);

        //если у заказа не менялся номер, то обновить номер
        $id_state_new='02425449-5b38-11ec-0a80-0d3200263282';
        $id_state_retail='829e6701-76ab-11eb-0a80-0912004d39af';
        $id_state_zp='1a30f761-e744-11eb-0a80-082b001a29ef';
        $id_state_opt='829e67d6-76ab-11eb-0a80-0912004d39b0';

        if($fields['state']['stateType']==='Regular' && $fields['state']['id']!=$id_state_new && empty($attr_old_name['value'])){
            $name=$customerorder->getName($entity_data);
                switch ($fields['state']['id']){
                    case $id_state_retail :
                        $new_name='R'.$name;
                        $res_upd['name']=$new_name;
                        $res_upd['attributes'][]=$customerorder->setCustomerorderAttribute($id_old_name, 'value', $new_name);
                        break;
                    case $id_state_zp :
                        $new_name='Z'.$name;
                        $res_upd['name']=$new_name;
                        $res_upd['attributes'][]=$customerorder->setCustomerorderAttribute($id_old_name, 'value', $new_name);
                        break;
                    case $id_state_opt :
                        $last_number=(int)$this->getLastNumber();
                        $last_number++;
                        $new_name=$this->formatOrderName($last_number);
                        $res_upd['name']=$new_name;
                        $res_upd['attributes'][]=$customerorder->setCustomerorderAttribute($id_old_name, 'value', $new_name);
                        break;
//                    case $id_state_new :
//                        //$res_upd['name']='Z'.$name;
//                        break;
//                    default :
//                        $last_n=(int)$this->getLastNumber();
//                        $new_name=$this->formatOrderName($last_n);
//                        $res_upd['name']=$new_name;
//                        $res_upd['attributes'][]=$customerorder->setCustomerorderAttribute($id_old_name, 'value', $new_name);
//                        break;
                }
        }



        $id_vies_chk='01c71b4a-586a-11ec-0a80-0c7100022215';
        $attr_vies_chk=$customerorder->getAttrubuteByID($id_vies_chk, $fields['attributes']);

        $id_agent_attr_tin='fb6a7540-7b1d-11eb-0a80-08f8000298ea';
        $agent_tin=$customerorder->getAttrubuteByID($id_agent_attr_tin, $fields['agent']['attributes']);

        if(!empty($agent_tin['value']) && empty($attr_vies_chk['value'])){
            $mvieschk= new MVieschk();

            $attr_agentvalidate=$mvieschk->validateAgent($agent_tin['value']);

            $res_upd['attributes'][]=$customerorder->setCustomerorderAttribute($id_vies_chk, 'value', $attr_agentvalidate['msg']);

            if($attr_agentvalidate['valid']===false){
                $flag_setlastnumber=false;
                $id_notValidstate='1f310cfb-5910-11ec-0a80-028e00005ab4';
                $res_upd['state']=$customerorder->setCustomerorderState($id_notValidstate);
            }
        }
        if(!empty($res_upd)){
            $json=json_encode($res_upd);

                $upd_res=$mmoySklad->updEntityMS($fields['uri'],$json);
                if(!isset($upd_res['errors'])){
                    $res['upd']=$upd_res;
                    if($flag_setlastnumber===true){
                        $res['setLastNumber']=$this->setLastNumber($last_number);
                    }
                }
                else{
                    $res['upd']['error']=$upd_res;
                }
        }
        else{
            $res['upd']='Нет данных для обновления';
        }

        $res['data']=$res_upd;

        return $res;
    }
    function syncPaymentin($uri){
        $mmoySklad=new MMoySklad();

        $expand='?expand=operations';
        $uri=$uri.$expand;

        $entity_data=$mmoySklad->getRequest($uri);

        $paymentin = new Paymentin($entity_data);
        $fields=$paymentin->fields;
        $res['fields']=$fields;

        $paymentinname=$entity_data['name'];
        $customerordername= $entity_data['operations'][0]['name'];

        if(strpos($customerordername, $paymentinname)===false )
        {
            $new_name=!sizeof($entity_data['operations'])>1 ? $entity_data['operations'][0]['name']."_".sizeof($entity_data['operations']) : $entity_data['operations'][0]['name'];
            $res_upd['name']=$new_name;
            $res['upd']='Надо заменить номер';
        }
        if(!empty($res_upd)){
            $json=json_encode($res_upd);
            $res['upd']=$mmoySklad->updEntityMS($fields['uri'],$json);
        }
        else{
            $res['upd']='Нет данных для обновления';
        }

        $res['entity_data']=$entity_data;
        return $res;
    }
    function syncDemand($uri){
        $mmoySklad=new MMoySklad();

       // $expand='';
        $expand='?expand=invoicesOut,customerOrder.invoicesOut';
        $uri=$uri.$expand;

        $entity_data=$mmoySklad->getRequest($uri);

        $demand = new Demand($entity_data);
        $fields=$demand->fields;
        $res['fields']=$fields;

        $demandname=$entity_data['name'];
        //$customerordername=!empty($entity_data['customerOrder']['name']) ? $entity_data['customerOrder']['name'] : $entity_data['invoicesOut']['name'];
        $customerordername=$entity_data['customerOrder']['name'];

        if(strpos($customerordername, $demandname)===false )
        {
            $new_name=!empty($fields['sfx']) ? $customerordername.'_'.$fields['sfx'] : $customerordername;
            $res_upd['name']=$new_name;
            $res['upd']='Надо заменить номер';
        }
        if(!empty($res_upd)){
            $json=json_encode($res_upd);
            $res['upd']=$mmoySklad->updEntityMS($fields['uri'],$json);
        }
        else{
            $res['upd']='Нет данных для обновления';
        }

        $res['entity_data']=$entity_data;
        return $res;
    }
    function syncInvoiceout($uri){
        $res=[];
        $mmoySklad=new MMoySklad();


        $expand='?expand=customerOrder.invoicesOut,demands';
        $uri=$uri.$expand;

        $entity_data=$mmoySklad->getRequest($uri);
        $invoiceout = new Invoiceout($entity_data);
        $fields=$invoiceout->fields;
        $res['fields']=$fields;

        $invoiceoutname=$entity_data['name'];
        $customerordername=!empty($entity_data['customerOrder']['name']) ? $entity_data['customerOrder']['name'] : $entity_data['demands'][0]['name'];

        if(strpos($customerordername, $invoiceoutname)===false )
        {

            $new_name=!empty($fields['sfx']) ? $customerordername.'_'.$fields['sfx'] : $customerordername;
            $res_upd['name']=$new_name;
            $res['upd']='Надо заменить номер';
        }
        if(!empty($res_upd)){
            $json=json_encode($res_upd);
            $res['upd']=$mmoySklad->updEntityMS($fields['uri'],$json);
        }
        else{
            $res['upd']='Нет данных для обновления';
        }

        $res['entity_data']=$entity_data;
        return $res;
    }
    function syncSalesreturn($uri )
    {
        $res_upd = [];

        $flag_setlastnumber = true;
        $mmoySklad = new MMoySklad();

        $expand = '?expand=attributes,demand';
        $uri = $uri . $expand;

        $entity_data = $mmoySklad->getRequest($uri);

        $salesreturn = new Salesreturn($entity_data);
        $fields = $salesreturn->fields;
        $res['fields'] = $fields;

        $id_rma = '61e66252-4266-11ec-0a80-09580001a19b';
        $attr_rma = $salesreturn->getAttrubuteByID($id_rma, $fields['attributes']);
//        //Если заказ RMA - ничего не менять, прервать выполнение скрипта
        if ($attr_rma['value'] === true) {
            return $res_upd['error']['msg'] = 'RMA';
        }

        $id_old_name = '1f9fea0e-5b86-11ec-0a80-05a1002c3ec1';

        $attr_old_name = $salesreturn->getAttrubuteByID($id_old_name, $fields['attributes']);
        $res['attr_old_name']=$attr_old_name;
//        //если у заказа не менялся номер, то обновить номер

        if (empty($attr_old_name['value'])) {

            $last_number = (int)$this->getLastNumber();
            $last_number++;
            $res_upd['last_number'] = $last_number;
            $new_name = $this->formatOrderName($last_number);
            $res_upd['name'] = $new_name;
            $res_upd['attributes'][] = $salesreturn->setSalesreturnrAttribute($id_old_name, 'value', $new_name);

            if (!empty($res_upd)) {
                $json = json_encode($res_upd);

                $upd_res = $mmoySklad->updEntityMS($fields['uri'], $json);
                if (!empty($upd_res) && !isset($upd_res['errors'])) {
                    $res['upd'] = $upd_res;
                    if ($flag_setlastnumber === true) {
                        $res['setLastNumber'] = $this->setLastNumber($last_number);
                    }
                } else {
                    $res['upd']['error'] = $upd_res;
                }
            } else {
                $res['upd'] = 'Нет данных для обновления';
            }


        }
        $res['data'] = $res_upd;
        $res['entity_data'] = $entity_data;
        return $res;
    }



    function getLastNumber(){
        $lastnumber_filename=$_SERVER['DOCUMENT_ROOT'].'/last_number.txt';
        if(file_exists($lastnumber_filename)){
            $data=file_get_contents($lastnumber_filename);
        }
        else{
            $data=1;
            file_put_contents($lastnumber_filename,$data);
        }

        return $data;
    }
    function setLastNumber($last_number){
        $lastnumber_filename=$_SERVER['DOCUMENT_ROOT'].'/last_number.txt';
        if(file_exists($lastnumber_filename)){
            $new_number=$last_number+1;
            $res=file_put_contents($lastnumber_filename, $new_number);
        }
        else{
            $data=1;
            $res=file_put_contents($lastnumber_filename,$data);
        }

        return $res;
    }

    function formatOrderName($last_number)
    {
        //$prefix=date("Y-m-");
        $prefix = date("Ym");
        $sufix = "";
        $count_number = iconv_strlen($last_number);
        if ($count_number < 3) {
            while ($count_number < 3) {
                $sufix .= "0";
                $count_number++;
            }
        }
        $new_name = $prefix . $sufix . $last_number;
        return $new_name;
    }

}