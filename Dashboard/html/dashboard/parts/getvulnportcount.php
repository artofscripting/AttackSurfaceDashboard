<?PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require '../vendor/autoload.php';
use Elasticsearch\ClientBuilder;


$hosts = [
    "es-container"      // IP + Port
];
$client = ClientBuilder::create()           // Instantiate a new ClientBuilder
                    ->setHosts($hosts)      // Set the hosts
                    ->build();

include("vulnquery.php");

$params = [
    'index' => 'gvmreports',
    'body'  => $json
];
$ipportarray = [];
$countV = 0;
$results = $client->search($params);
# print_r($results);
foreach ($results["aggregations"]["2"]["buckets"] as &$value) {
    
	foreach ($value["3"]["buckets"] as &$bucket) {
		
		foreach ($bucket["4"]["buckets"] as &$port) {
			if(strpos($port["key"], "general") == false){
				if ($port["key"] == "general/tcp"){
				}elseif($port["key"] == "general/HOST-T"){
				}elseif($port["key"] == "general/CPE-T"){
				}elseif($port["key"] == "general/icmp"){	
					
					
					
				}else{	
					$ipport = $value["key"] . ":" . $port["key"];
					#$print($ipport);
					#
					#echo $ipport;
					#echo "<br>";
					if (in_array($ipport, $ipportarray)) {
						
					}else{
						$countV++;	
						array_push($ipportarray,$ipport);
					}
				}
			
			}			
			foreach ($port["5"]["buckets"] as &$severity) {
				if ($severity["key"] == "0.0"){
					
				}else{					
					#echo json_encode($value["key"]);
					#echo json_encode($bucket["key"]);
					#echo json_encode($port["key"]);
					
					#echo json_encode($severity["key"]);
					#echo "<br>";
					#echo "<br>";
				
					#echo $countV;
				}
			}
		}
	}
}

echo $countV;
#echo "done";


?>