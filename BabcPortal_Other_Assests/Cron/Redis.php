<?php
ini_set("memory_limit", "-1");
set_time_limit(0);
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Connecting to Redis server on localhost
$redis = new Redis();
$redis->connect('127.0.0.1', 32771);
// Check whether server is running or not
echo 'Redis is running: ' . $redis->ping() . '<br>';
// Set the value of a key
$key = 'product';
$redis->set($key, 'MAMP PR45O');
// Get the value of a key
echo 'Key "' . $key . '" has the value "' . $redis->get($key) . '"' . '<br>';
// Store data in redis list
$redis->lPush('list', 'MAMP PRO');
$redis->lPush('list', 'Apache');
$redis->lPush('list', 'MySQL');
$redis->lPush('list', 'Redis');
// Get the list data
$list = $redis->lRange('list', 0, 3);
echo '<br>';
echo 'Stored list:';
echo '<pre>';
print_r($list);
echo '</pre>';

$redis->hset("publisher","NAME","Domain");
$redis->hset("publisher","Url","tester");

print_r($redis->exists([ "publisher" , "NAME" ]));

// Clean up
if ($redis->exists([ "publisher" , "NAME"  ]) === 1) {
    echo "jknjkn";
    $redis->del($key);
    $redis->del('list');
    $redis->del("publisher");
    
}









?>