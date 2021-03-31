<table class="sortable-theme-light" data-sortable>
                    <thead class="text-warning">
                      <th>IP</th>
                      <th>Port</th>
					  <th>HTTPS</th>
                      <th>HTTP</th>
                    
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



$json = '{
	"aggs": {
	  "2": {
		"terms": {
		  "field": "host.keyword",
		  "order": {
			"_count": "desc"
		  },
		  "size": 500
		},
		"aggs": {
		  "3": {
			"terms": {
			  "field": "port.keyword",
			  "order": {
				"_count": "desc"
			  },
			  "size": 50
			}
		  }
		}
	  }
	},
	"size": 0,
	"stored_fields": [
	  "*"
	],
	"script_fields": {},
	"docvalue_fields": [
	  {
		"field": "timestamp",
		"format": "date_time"
	  }
	],
	"_source": {
	  "excludes": []
	},
	"query": {
	  "bool": {
		"must": [],
		"filter": [
		  {
			"bool": {
			  "should": [
				{
				  "match_phrase": {
					"namespace": "'.$_GET["ns"].'"
				  }
				}
			  ],
			  "minimum_should_match": 1
			}
		  },
		  {
			"range": {
			  "timestamp": {
				"gte": "now-1h",
				"lte": "now",
				"format": "strict_date_optional_time"
			  }
			}
		  }
		],
		"should": [],
		"must_not": []
	  }
	}
  }';


$params = [
    'index' => 'downdetector*',
    'body'  => $json
];

$countV = 0;
$results = $client->search($params);
# print_r($results);
foreach ($results["aggregations"]["2"]["buckets"] as &$value) {
    $countV++;	
	foreach ($value["3"]["buckets"] as &$bucket) {
		
		
				
				echo "<tr>";
				echo "<td>" . $value["key"] . "</td>";
				echo "<td>" . $bucket["key"] . "</td>";
				echo "<td> <a href=https://" . $value["key"] . ":". $bucket["key"] . " target=new>https</a></td>";
				echo "<td> <a href=http://" . $value["key"] . ":". $bucket["key"] . " target=new>http</a></td>";
				#echo json_encode($value["key"]);
				#echo json_encode($bucket["key"]);
				#echo json_encode($port["key"]);
				
				#echo json_encode($severity["key"]);
				#echo "<br>";
				echo "</tr>";
		
			}
}

#echo $countV;
#echo "done";

                      
                        

?>


	</tbody>
  </table>