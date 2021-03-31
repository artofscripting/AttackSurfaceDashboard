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


include("namespace.php");

$json = '{
  "aggs": {
    "1": {
      "cardinality": {
        "field": "ip.keyword"
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
            "query": "namespace : \"' . $namespace . '\"",
            "analyze_wildcard": true,
            "time_zone": "America/Chicago"
          }
        }
      ],
      "filter": [
        {
          "range": {
            "timestamp": {
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
    'index' => 'masscantopports',
    'body'  => $json
];

$countV = 0;
$results = $client->search($params);
echo $results["aggregations"]["1"]["value"];


#echo $countV;
#echo "done";


?>