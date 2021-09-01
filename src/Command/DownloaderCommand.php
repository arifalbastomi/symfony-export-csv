<?php
namespace App\Command;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Rs\JsonLines\JsonLines;

class DownloaderCommand extends Command
{
    protected static $defaultName = 'app:downloader';
    public function __construct($projectDir)
    {
        $this->projectDir = $projectDir;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Downloader Data')
            ->addArgument('process_date', InputArgument::OPTIONAL, 'date of proccess', date_create()
                ->format('Y-m-d h:i:s'));
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $output->writeln(['please wait...', '==============', '', ]);
        $url = "https://s3-ap-southeast-2.amazonaws.com/catch-code-challenge/challenge-1-in.jsonl";
        $file_name = basename($url);
        $output_type = 'csv';
        if ($output_type == 'csv' || $output_type == 'xml')
        {
            if (file_put_contents($this->projectDir . '/public/download/' . $file_name, file_get_contents($url)))
            {
                $this->getRowJson($file_name, $output_type);
                dd("success");
            }
            else
            {
                $output->writeln('Downloaded data failed');
            }
        }
        else
        {
            $output->writeln('please set valid output type');
        }

    }

    public function getRowJson($file_name, $output_type)
    {

        $file = $this->projectDir . '/public/download/' . $file_name;
        $json_lines = (new JsonLines())->delineEachLineFromFile($file);
        $order = new ExtractData();
        $order_list = $order->extract($json_lines);
        $dir = $this->projectDir . '/public/download/';
        $export = new Export();
        $export->exportFile($order_list, $output_type, $dir);

    }

}

