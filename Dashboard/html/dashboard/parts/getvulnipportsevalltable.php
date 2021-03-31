<table class="sortable-theme-light" data-sortable>
                    <thead class="text-warning">
                      <th>IP</th>
                      <th>Name</th>
                      
                      <th>Severity</th>
					  <th>Port</th>
                    </thead>
                    <tbody>


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
$results = $client->search($params);
# print_r($results);
foreach ($results["aggregations"]["2"]["buckets"] as &$value) {
    $countV++;	
	foreach ($value["3"]["buckets"] as &$bucket) {
		
		foreach ($bucket["4"]["buckets"] as &$port) {
			
			foreach ($port["5"]["buckets"] as &$severity) {
				
				echo "<tr>";
				echo "<td>" . $value["key"] . "</td>";
				echo "<td>" . $bucket["key"] . "</td>";
				
				echo "<td>" . $severity["key"] . "</td>";
				echo "<td>" . $port["key"] . "</td>";
				#echo json_encode($value["key"]);
				#echo json_encode($bucket["key"]);
				#echo json_encode($port["key"]);
				
				#echo json_encode($severity["key"]);
				#echo "<br>";
				echo "</tr>";
		
			}
		}
	}
}

#echo $countV;
#echo "done";

                      
                        

?>


	</tbody>
  </table>