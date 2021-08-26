<?php

namespace App\Command;

use App\Command\Export;
use App\Model\Order;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Rs\JsonLines\JsonLines;

class DownloaderCommand extends Command
{
    protected static $defaultName='app:downloader';
    public function __construct($projectDir)
    {
        $this->projectDir=$projectDir;
        parent::__construct();
    }

    protected function configure()
    {

        $this->setDescription('Downloader Data')
            ->addArgument('markup',InputArgument::OPTIONAL,'percentage_markup',20)
            ->addArgument('procces_date',InputArgument::OPTIONAL,'date of proccess',date_create()->format('Y-m-d h:i:s'));
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'please wait...',
            '==============',
            '',
        ]);
        $url="https://s3-ap-southeast-2.amazonaws.com/catch-code-challenge/challenge-1-in.jsonl";
        $file_name = basename($url);
        // use csv or xml
        $output_type="csv";
        if($output_type=='csv' || $output_type=='xml'){
            if(file_put_contents($this->projectDir.'/public/download/'.$file_name,file_get_contents($url))){
                $this->getRowJson($file_name,$output_type);
            }else{
                $output->writeln('Downloaded data failed');
            }
        }else{
            $output->writeln('please set valid output type');
        }


    }

    public function getRowJson($file_name,$output_type){

        $file= $this->projectDir.'/public/download/'.$file_name;
        $json_lines = (new JsonLines())->delineEachLineFromFile($file);
        $order= array();
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
        $dir=$this->projectDir.'/public/download/';
        $export = new Export();
        $export->exportFile($order_list,$output_type,$dir);

    }

}