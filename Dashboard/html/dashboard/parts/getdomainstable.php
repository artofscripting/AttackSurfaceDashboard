<table class="sortable-theme-light" data-sortable>
                    <thead class="text-warning">
                      <th>Sub Domain</th>
                      <th>Domain</th>
                      
                      <th>Source</th>
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
            "field": "domain.keyword",
            "order": {
              "_count": "desc"
            },
            "size": 5
          },
          "aggs": {
            "4": {
              "terms": {
                "field": "sources.keyword",
                "order": {
                  "_count": "desc"
                },
                "missing": "__missing__",
                "size": 50
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
    'index' => 'amassscanresults*',
    'body'  => $json
];


$results = $client->search($params);
#echo json_encode($results);
foreach ($results["aggregations"]["2"]["buckets"] as &$value) {
    
	foreach ($value["3"]["buckets"] as &$bucket) {
		
		foreach ($bucket["4"]["buckets"] as &$port) {
			
			
					
					echo "<tr>";
					echo "<td>" . $value["key"] . "</td>";
					echo "<td>" . $bucket["key"] . "</td>";
				
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

#echo $countV;
#echo "done";

                      
                        

?>


	</tbody>
  </table>