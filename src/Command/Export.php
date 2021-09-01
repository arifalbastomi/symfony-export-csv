<?php
namespace App\Command;
use Sonata\Exporter\Handler;
use Sonata\Exporter\Source\ArraySourceIterator;
use Sonata\Exporter\Writer\CsvWriter;
use Sonata\Exporter\Writer\XmlWriter;

class Export
{

    public function exportFile($order_list, $output_type, $dir)
    {

        $source = new ArraySourceIterator($order_list);

        if ($output_type == 'csv')
        {
            if (file_exists($dir . '/out.csv'))
            {
                unlink($dir . '/out.csv');
            }
            $writer = new CsvWriter($dir . '/out.csv');
        }
        else
        {
            if (file_exists($dir . '/out.csv'))
            {
                unlink($dir . '/out.xml');
            }
            $writer = new XmlWriter($dir . '/out.xml');
        }

        Handler::create($source, $writer)->export();
        return 1;

    }
}

