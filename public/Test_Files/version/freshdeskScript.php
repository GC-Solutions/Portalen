<?php

ini_set("memory_limit", "-1");
set_time_limit(0);
ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php';



use Google\Analytics\Data\V1beta\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\Dimension;
use Google\Analytics\Data\V1beta\Metric;


$property_id = '301911084';

// Using a default constructor instructs the client to use the credentials
// specified in GOOGLE_APPLICATION_CREDENTIALS environment variable.



// specify the path to your application credentials
putenv('GOOGLE_APPLICATION_CREDENTIALS='.__DIR__.'/gcsproject-1652800581967-cf6cdac17e55.json');

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