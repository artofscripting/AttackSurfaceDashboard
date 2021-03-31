import time
import socket
import json
from elasticsearch import Elasticsearch
es_host2 = "es-container"
es2  = Elasticsearch([{'host': es_host2, 'port': 9200}])
def get_list(typeoftarget):
    query  ={

      "size": 500,
      "sort": [
        {
          "_score": {
            "order": "desc"
          }
        }
      ],
      "stored_fields": [
        "*"
      ],
      "script_fields": {},
      "docvalue_fields": [],
      "_source": {
        "excludes": []
      },
      "query": {
        "bool": {
          "must": [],
          "filter": [
            {
              "match_all": {}
            },
            {
              "match_phrase": {
                "enabled": True
              }
            }
          ],
          "should": [],
          "must_not": []
        }
      },
      "highlight": {
        "pre_tags": [
          "@kibana-highlighted-field@"
        ],
        "post_tags": [
          "@/kibana-highlighted-field@"
        ],
        "fields": {
          "*": {}
        },
        "fragment_size": 2147483647
      }
    }
    res = es2.search(index="targetselection", body=query)
    lst = list()
    #print(res["hits"]["hits"])
    for hit in res["hits"]["hits"]:
        #@print(hit['_source'])
        h = hit['_source']
        
        if h["type_of_target"] == typeoftarget:
            lst.append(h)
    return lst
    
    
    

