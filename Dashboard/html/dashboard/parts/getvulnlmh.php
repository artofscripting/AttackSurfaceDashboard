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

$countV = 0;
$countL = 0;
$countM = 0;
$countH = 0;
$countC = 0;
$results = $client->search($params);
# print_r($results);
foreach ($results["aggregations"]["2"]["buckets"] as &$value) {
    
	foreach ($value["3"]["buckets"] as &$bucket) {
		
		foreach ($bucket["4"]["buckets"] as &$port) {
			
			foreach ($port["5"]["buckets"] as &$severity) {
				if (floatval($severity["key"]) == 0.0){
				}elseif (floatval($severity["key"]) > 0.0 && floatval($severity["key"]) <= 3.9){	
					$countL++;
				}elseif (floatval($severity["key"]) >= 4.0 && floatval($severity["key"]) <= 6.9){	
					$countM++;
				}elseif (floatval($severity["key"]) >= 7.0 && floatval($severity["key"]) <= 8.9){	
					$countH++;
				}elseif (floatval($severity["key"]) >= 9.0 && floatval($severity["key"]) <= 10.0){	
					$countC++;
				}else{					
					#echo json_encode($value["key"]);
					#echo json_encode($bucket["key"]);
					#echo json_encode($port["key"]);
					
					#echo json_encode($severity["key"]);
					#echo "<br>";
					#echo "<br>";
					$countV++;
					#echo $countV;
				}
			}
		}
	}
}

echo $countC . " Critical </br> " . $countH . " High </br> " . $countM .  " Medium </br> " . $countL .  " Low";
#echo "done";


?>