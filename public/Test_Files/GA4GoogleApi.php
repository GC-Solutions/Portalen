<?php
ini_set("memory_limit", "-1");
set_time_limit(0);
ini_set('display_errors', 1);
error_reporting(E_ALL);


// Load the Google API PHP Client Library.
$path  =  explode("\public", dirname(__DIR__) );
$path  = $path[0];

// Load the Google API PHP Client Library.
require  $path  . '/vendor/autoload.php';

//require 'vendor/autoload.php';


use Google\Analytics\Data\V1beta\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\Dimension;
use Google\Analytics\Data\V1beta\Metric;


$property_id = '301911084';

// Using a default constructor instructs the client to use the credentials
// specified in GOOGLE_APPLICATION_CREDENTIALS environment variable.


//C:\MAMP\htdocs\Babcportal\BabcPortal_Dev\Dev_Git\public\Test_Files
// specify the path to your application credentials 
putenv('GOOGLE_APPLICATION_CREDENTIALS=C:\MAMP\htdocs\Babcportal\BabcPortal_Dev\Dev_Git\public\Test_Files\gcsproject-1652800581967-c214f292e12b.json');

$client = new BetaAnalyticsDataClient();


// Make an API call.
$response = $client->runReport([
    'property' => 'properties/' . $property_id,
    'dateRanges' => [
        new DateRange([
           
            'start_date' => '90daysAgo',
            'end_date' => 'yesterday'
        ]),
    ],
    'dimensions' => [new Dimension(
        [
            'name' => 'city',
        ]
    ),
    ],
    'metrics' => [new Metric(
        [
            'name' => 'activeUsers',
        ]
    )
    ]
]);

// Print results of an API call.
print 'Report result: ' . PHP_EOL;

foreach ($response->getRows() as $row) {
    print $row->getDimensionValues()[0]->getValue()
        . ' ' . $row->getMetricValues()[0]->getValue() . PHP_EOL;
}
?>