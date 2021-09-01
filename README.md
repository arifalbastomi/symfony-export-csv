## How to run

symfony console app:downloader

## Description

* This project using symfony console
* Support export csv and xml
* to write csv/xml using library (sonata exporter)
* I made 2 additional classes extract data and export
* extract class function to break data from jsonl into array form
* export class functions to export data that has been extracted into csv or xml format

## Test
* php ./vendor/bin/phpunit
* php ./vendor/bin/phpunit --testdox

## Acknowledgments
Library:
* [sonata-project](https://github.com/sonata-project/exporter)
* [json-line](https://github.com/raphaelstolt/json-lines)
