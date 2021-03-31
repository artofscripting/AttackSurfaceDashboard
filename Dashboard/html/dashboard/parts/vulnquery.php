<?php
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
          "query_string": {
            "query": "network : \"'.$_GET["ns"].'\"",
            "analyze_wildcard": true,
            "time_zone": "America/Chicago"
          }
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
?>