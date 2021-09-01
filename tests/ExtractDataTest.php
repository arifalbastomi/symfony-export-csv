<?php
namespace App\Tests;
use App\Command\ExtractData;
use Rs\JsonLines\JsonLines;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ExtractDataTest extends KernelTestCase
{

    public function testExtract()
    {

       $order = array(
            'order_id' => 1006,
            'order_date' => "Fri, 08 Mar 2019 20:22:51 +0000",
            'total_order_value' => 582.44,
            'average_unit_price' => 58.24,
            'distinct_unit_count' => 10,
            'total_units_count' => 28,
            'customer_state' => "NEW SOUTH WALES"
       );

        $order_list=[$order];
        $extract = new ExtractData();
        $file = __dir__.'/challenge-1-in.jsonl';
        $json_lines = (new JsonLines())->delineEachLineFromFile($file);
        $extract_data = $extract->extract($json_lines);
        $this->assertSame($order_list, $extract_data);

    }
}