<?php
namespace App\Tests;
use App\Command\Export;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ExportTest extends KernelTestCase
{
    public function testExportFile()
    {
        $export = new Export();
        $data = array(
            'order_id' => 0001,
            'order_date' => "Wed, 13 Mar 2019 15:11:39 +0000",
            'total_order_value' => 60.6,
            'average_unit_price' => 30,
            'distinct_unit_count' => 1,
            'total_units_count' => 2,
            'customer_state' => "Victoria"
        );
        $file_type = "csv";
        $order = [$data];
        $test = $export->exportFile($order, $file_type, __dir__);
        $this->assertSame(1, $test);
    }
}