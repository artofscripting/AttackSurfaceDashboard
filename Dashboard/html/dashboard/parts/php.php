<?PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require '../vendor/autoload.php';
use Elasticsearch\ClientBuilder;


$hosts = [
    "3.133.235.65"      // IP + Port
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
            "field": "nvt.keyword",
            "order": {
              "_count": "desc"
            },
            "size": 500
          },
          "aggs": {
            "4": {
              "terms": {
                "field": "port.keyword",
                "order": {
                  "_count": "desc"
                },
                "size": 500
              },
              "aggs": {
                "5": {
                  "terms": {
                    "field": "severity.keyword",
                    "order": {
                      "_count": "desc"
                    },
                    "size": 5
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
      "field": "time",
      "format": "date_time"
    },
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
          "match_all": {}
        }
      ],
      "filter": [
        {
          "range": {
            "time": {
              "gte": "now-7d",
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

echo $countV;
#echo "done";


?>