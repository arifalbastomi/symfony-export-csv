<?php

namespace App\Command;

class ExtractData
{
    public function extract($json_lines){

        $order_list=array();
        $order_list_item=0;
        foreach ($json_lines as $json_line) {

            $json=json_decode($json_line,true);
            $isDiscount=false;
            $disc_type="";
            $disc_value=0;
            if(!empty($json['$discounts'])){
                $isDiscount=true;
                $discounts=$json['$discounts'];
                $disc_type=$discounts['type'];
                $disc_value=$discounts['value'];

            }
            $customer_state=$json['customer']['shipping_address']['state'];

            if(!empty($json['items'])){

                $total_order_value=0;
                $average_unit_price=0;
                $distinct_unit_count=0;
                $total_units_count=0;
                foreach ($json['items'] as $item) {

                    $total_order_value=$total_order_value+$item['unit_price'];
                    if($isDiscount){
                        if($disc_type=='PERCENTAGE'){
                            $disc_value=$total_order_value*($disc_value/100);
                        }
                        $total_order_value= $total_order_value - $disc_value;
                    }

                    $distinct_unit_count++;
                    $total_units_count=$total_units_count+$item['quantity'];
                }

                $average_unit_price=$total_order_value/$distinct_unit_count;
                /*$getPosition = new Geocode();
                $address=$json['customer']['shipping_address']['street'];
                $lat='';
                $lng='';
                if(!empty($address)){
                    $latlong = $getPosition->getLatLong($address);
                    $lat=$latlong['lat'];
                    $lng=$latlong['lng'];
                }*/
                $order=array('order_id'=>$json['order_id'],
                    'order_date'=>$json['order_date'],
                    'total_order_value'=>$total_order_value,
                    'average_unit_price'=>$average_unit_price,
                    'distinct_unit_count'=>$distinct_unit_count,
                    'total_units_count'=>$total_units_count,
                    'customer_state'=>$customer_state);
                $order_list[$order_list_item++]=$order;
            }
        }
        return $order_list;
    }
}