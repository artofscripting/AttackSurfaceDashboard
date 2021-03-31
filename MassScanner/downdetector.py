from elasticsearch import Elasticsearch
from datetime import datetime, date, timezone
import time
import socket
import uuid 
from twilio.rest import Client
import os

def checkhosts(namespace):
    es_host = "es-container"
    elastic_client  = Elasticsearch([{'host': es_host, 'port': 9200}])
    query_body = {
      "aggs": {
        "2": {
          "terms": {
            "field": "ip.keyword",
            "order": {
              "_count": "desc"
            },
            "size": 500
          },
          "aggs": {
            "3": {
              "terms": {
                "field": "ports.port",
                "order": {
                  "_count": "desc"
                },
                "size": 5
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
                      "namespace.keyword": namespace
                    }
                  }
                ],
                "minimum_should_match": 1
              }
            },
            {
              "range": {
                "timestamp": {
                  "gte": "now-1d",
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
    }
    query_body2 = {
      "aggs": {
        "2": {
          "terms": {
            "field": "ip.keyword",
            "order": {
              "_count": "desc"
            },
            "size": 500
          },
          "aggs": {
            "3": {
              "terms": {
                "field": "ports.port",
                "order": {
                  "_count": "desc"
                },
                "size": 5
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
                      "namespace.keyword": namespace
                    }
                  }
                ],
                "minimum_should_match": 1
              }
            },
            {
              "range": {
                "timestamp": {
                  "gte": "now-15m",
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
    }
    res = elastic_client.search(index="masscantopports", body=query_body)
    res2 = elastic_client.search(index="masscantopports", body=query_body2)

    class esLog:
        indexName = str()
        i_d = str()
        type_of_doc = str()
        js = str()

        def __init__(self, indexName, type_of_doc, i_d, js):
            self.indexName = indexName
            self.i_d = i_d
            self.type_of_doc = type_of_doc
            self.js = js


    def sendToES(esllog):
        elastic_client.index(index=esllog.indexName, doc_type=esllog.type_of_doc,
                 id=esllog.i_d, body=json.loads(esllog.js))

    import json

    oneday = list()
    fifteenminutes = list()
    #print(res["aggregations"]["2"]["buckets"])
    for bucket in res["aggregations"]["2"]["buckets"]:
        for buck in bucket["3"]["buckets"]:
            #print(bucket["key"] + ":" + str(buck["key"]))
            oneday.append(bucket["key"] + ":" + str(buck["key"]))


    for bucket in res2["aggregations"]["2"]["buckets"]:
        #print(bucket["key"])
        #print(bucket["3"]["buckets"])

        for buck in bucket["3"]["buckets"]:
            #print(bucket["key"] + ":" + str(buck["key"]))
            fifteenminutes.append(bucket["key"] + ":" + str(buck["key"]))

    
    count_missing = 0
    #print(len(fifteenminutes))
    #print(len(oneday))
    for oned in oneday:
        if oned in fifteenminutes:
            donothing = ""
            #print("ok")
        else:
            count_missing = count_missing + 1
            data = dict()
            data["host"] = oned.split(":")[0]
            data["port"] = oned.split(":")[1]
            data["namespace"] = namespace
            
            data["timestamp"]= datetime.now(timezone.utc).isoformat() 
            id = uuid.uuid1()
            es_log = esLog("downdetector", 'log', id , json.dumps(data, default=str))
            sendToES(es_log)
            print(data)
    if count_missing > int(os.environ.get('MAX_DOWN')):
        client = Client(os.environ.get('TWILIO_API_CLIENT'),os.environ.get('TWILIO_API_KEY'))
        client.messages.create(to="+"+os.environ.get('TWILIO_API_PHONE_TO'), from_="+"+os.environ.get('TWILIO_API_PHONE_FROM'), body="Downdetector Alert!")
    else:
        print("No Mass Outage Detected")
    

            
namespaces = list()
namespaces.append("ORG")


for namespace in namespaces:
    checkhosts(namespace)




    

    
    
