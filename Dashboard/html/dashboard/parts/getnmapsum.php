<table class="sortable-theme-light" data-sortable>
                    <thead class="text-warning">
                      <th>Name</th>
                      <th>Output</th>
                      <th>IP</th>
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



$json = '{
  "aggs": {
    "2": {
      "terms": {
        "field": "name.keyword",
        "order": {
          "_count": "desc"
        },
        "size": 500
      },
      "aggs": {
        "3": {
          "terms": {
            "field": "output.keyword",
            "order": {
              "_count": "desc"
            },
            "size": 50
          },
          "aggs": {
            "4": {
              "terms": {
                "field": "host.keyword",
                "order": {
                  "_count": "desc"
                },
                "size": 500
              },
              "aggs": {
                "5": {
                  "terms": {
                    "field": "port.keyword",
                    "order": {
                      "_count": "desc"
                    },
                    "size": 500
                  }
                }
              }
            }
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
      "must": [
        {
          "query_string": {
            "query": "namespace : \"'.$_GET["ns"].'\"",
            "analyze_wildcard": true,
            "time_zone": "America/Chicago"
          }
        }
      ],
      "filter": [
        {
          "range": {
            "timestamp": {
              "gte": "now-24h",
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
    'index' => 'nmapscripts*',
    'body'  => $json
];


$results = $client->search($params);
#echo json_encode($results);
foreach ($results["aggregations"]["2"]["buckets"] as &$name) {
    
	foreach ($name["3"]["buckets"] as &$domain) {
		
		foreach ($domain["4"]["buckets"] as &$ip) {
			foreach ($ip["5"]["buckets"] as &$port) {
					if(strpos($domain["key"], "ERROR") !== false){
					}elseif(strpos($domain["key"], "Please") !== false){
					}elseif(strpos($domain["key"], "alert") !== false){	
					}elseif(strpos($domain["key"], "No previously reported") !== false){
					}elseif(strpos($domain["key"], "time") !== false){	
					}elseif(strpos($domain["key"], "Host appears to be clean") !== false){	
					}elseif(strpos($domain["key"], "403") !== false){	
					}elseif(strpos($domain["key"], "Couldn't find any") !== false){
					

					}elseif(strpos($name["key"], "http") !== false){	
					}elseif(strpos($name["key"], "tls") !== false){	
					
					
					}elseif(trim($domain["key"]) == ""){	
					} else{
						
						echo "<tr>";
						echo "<td>" . $name["key"] . "</td>";
						echo "<td>" . $domain["key"] . "</td>";
					
						echo "<td>" . $ip["key"] . "</td>";
						echo "<td>" . $port["key"] . "</td>";
						#echo json_encode($value["key"]);
						#echo json_encode($bucket["key"]);
						#echo json_encode($port["key"]);
						
						#echo json_encode($severity["key"]);
						#echo "<br>";
						echo "</tr>";
					
						#echo $countV;
						
					}
					
					
				
			}
		}
	}
}

#echo $countV;
#echo "done";

                      
                        

?>


	</tbody>
  </table>