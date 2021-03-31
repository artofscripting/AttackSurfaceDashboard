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

$namespaceArray = [
    
    "org" => 'ORG',
	"amsys" => 'ORG',
];



include("vulnquery.php");

$params = [
    'index' => 'gvmreports',
    'body'  => $json
];

$countV = 0;
$results = $client->search($params);
# print_r($results);
foreach ($results["aggregations"]["2"]["buckets"] as &$value) {
    
	foreach ($value["3"]["buckets"] as &$bucket) {
		
		foreach ($bucket["4"]["buckets"] as &$port) {
			
			foreach ($port["5"]["buckets"] as &$severity) {
				if ($severity["key"] == "0.0"){
					#$countV++;	
				}else{	
					if(strpos($bucket["key"], "SSL") !== false){
						##echo "Word Found!";
						$countV++;
					} else{
						#echo "Word Not Found!";
					}
					#echo json_encode($value["key"]);
					#echo json_encode($bucket["key"]);
					#echo json_encode($port["key"]);
					
					#echo json_encode($severity["key"]);
					#echo "<br>";
					#echo "<br>";
					#$countV++;
					#echo $countV;
				}
			}
		}
	}
}

echo $countV;
#echo "done";


?>