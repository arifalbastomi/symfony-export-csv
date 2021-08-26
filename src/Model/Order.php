<?php

namespace App\Model;

class Order
{
    private $order_id;
    private $order_datetime;
    private $total_order_value;
    private $average_unit_price;
    private $distinct_unit_count;
    private $total_units_count;
    private $customer_state;

    public function getOrder_id(){
        return $this->order_id;
    }

    public function setOrder_id($order_id){
        $this->order_id = $order_id;
    }


    public function getOrder_datetime(){
        return $this->order_datetime;
    }

    public function setOrder_datetime($order_datetime){
        $this->order_datetime = $order_datetime;
    }

    public function getTotal_order_value(){

        return $this->total_order_value;
    }

    public function SetTotal_order_value($total_order_value){
        $this->total_order_value = $total_order_value;
    }

    public function getAverage_unit_price(){
        return $this->average_unit_price;
    }

    public function SetAverage_unit_price($average_unit_price){

        $this->average_unit_price = $average_unit_price;
    }

    public function getDistinct_unit_count(){
        return $this->distinct_unit_count;
    }

    public function SetDistinct_unit_count($distinct_unit_count){
        $this->distinct_unit_count = $distinct_unit_count;
    }

    public function getTotal_units_count(){
        return $this->total_units_count;
    }

    public function SetTotal_units_count($total_units_count){
        $this->total_units_count = $total_units_count;
    }

    public function getCustomer_state(){
        return $this->customer_state;
    }

    public function SetCustomer_state($customer_state){
        $this->customer_state = $customer_state;
    }

    public function __toString()
    {
        return $this->order_datetime;
    }
}