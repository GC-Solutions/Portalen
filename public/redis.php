<?php
$redis = new Redis();
$redis->connect('127.0.0.1', 32771);
// Function to flush all Redis data
function flushRedis() {
    global $redis;
    $redis->flushAll();
    echo "Redis data flushed!";
}
// Function to set the TTL for a specific key
function setTTL($key, $seconds) {
    global $redis;
    if ($seconds > 0) {
        $redis->expire($key, $seconds);
        echo "TTL set for key '$key' to $seconds seconds.";
    } else {
        echo "Invalid TTL value. Please enter a positive number of seconds.";
    }
}

// Function to get all keys in Redis along with their TTL
function getAllKeysWithTTL() {
    global $redis;
    $keys = $redis->keys('*');
    echo "All Redis keys with TTL:<br>";
    foreach ($keys as $key) {
        $ttl = $redis->ttl($key);
        echo "$key (TTL: $ttl seconds)<br>";
    }
}

function getRedisMemoryUsage() {
    global $redis;
    $memoryUsage = $redis->info("memory")['used_memory_human'];
    echo "Redis Memory Usage: $memoryUsage";
}
// Function to get all fields and values of a specific hash key
function getHashKeyAll($key) {
    global $redis;
    $hashData = $redis->hGet($key, $key);
    echo "Data for key '$key': <pre>";
    print_r($hashData);
    echo "</pre>"; 

$inputString = $hashData;
$targetValue = "209778";
$result = findValueAfterFifthComma($inputString, $targetValue);

if ($result !== null) {
    echo "Result: $result";
} else {
    echo "Value not found";
}

}

function findValueAfterFifthComma($inputString, $targetValue) {
    // Split the input string by comma
    $values = explode(",", $inputString);

    $count = 0;
    $result = null;
    $countPickFlag = false;
    foreach ($values as &$value) {
        // Trim whitespace and remove quotes
        $cleanedValue = trim(trim($value, '"'));

        if ($cleanedValue === $targetValue) {
			echo "</br>Value found</br>";
                $countPickFlag = true;
        } elseif ($count === 5) {
			
            $value = '"3"';
			echo "</br>Value ".$cleanedValue."</br>";
			    $countPickFlag = false;
            break;
        }
		if($countPickFlag) {
		$count++;
		}
    }

    if ($result !== null) {
        // Reconstruct the original format with quotes
        $result = '"' . $result . '"';
    }

    // Join the modified values with commas to get the final string
    $outputString = implode(",", $values);

    return $outputString;
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["flushall"])) {
        flushRedis();
    } elseif (isset($_POST["getallkeys"])) {
        getAllKeysWithTTL();
    } elseif (isset($_POST["gethashkey"])) {
        $specificKey = $_POST["specifickey"];
        getHashKeyAll($specificKey);
    } elseif (isset($_POST["getmemoryusage"])) {
        getRedisMemoryUsage();
    } elseif (isset($_POST["setttl"])) {
        $ttlKey = $_POST["ttlkey"];
        $ttlSeconds = (int)$_POST["ttlseconds"];
        setTTL($ttlKey, $ttlSeconds);
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Redis Commands</title>
</head>
<body>
    <h1>Redis Commands</h1>
    
    <form method="post">
        <button type="submit" name="flushall">Flush All</button>
        <button type="submit" name="getallkeys">Get All Keys</button>
        <button type="submit" name="getmemoryusage">Get Memory Usage</button>
        <br><br>
        <label for="specifickey">Enter a specific key for HGETALL:</label>
        <input type="text" name="specifickey" id="specifickey">
        <button type="submit" name="gethashkey">HGETALL</button>
        <br><br>
        <label for="ttlkey">Enter the key to set TTL:</label>
        <input type="text" name="ttlkey" id="ttlkey">
        <label for="ttlseconds">TTL (seconds):</label>
        <input type="number" name="ttlseconds" id="ttlseconds" min="0">
        <button type="submit" name="setttl">Set TTL</button>
    </form>
</body>
</html>
