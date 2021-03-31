import csv
import os
from elasticsearch import Elasticsearch
from datetime import datetime, date, timezone
import targets
key = os.environ.get('WPSCAN_API_KEY')
target_list = targets.get_list("WORDPRESS")

es_host = "es-container"

es = Elasticsearch([{'host': es_host, 'port': 9200}])

import uuid 


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
    es.index(index=esllog.indexName, doc_type=esllog.type_of_doc,
             id=esllog.i_d, body=json.loads(esllog.js))
    # print("sent" + i_d)

  

import json

for row in target_list:
    print(row["target"])
    cmd = 'wpscan --url ' + row["target"] + ' --enumerate u --api-token ' + key + ' --format json > /code/wpscanner/' + row["namespace"] + '.json'
    print(cmd)
    os.system(cmd)


   
    import codecs
    with codecs.open("/code/wpscanner/" + row["namespace"] +   '.json', 'r', encoding='utf8') as f:
        datasource = f.read()
    #print(datasource[:-4] + "]")
    #print(datasource)
    data = json.loads(datasource)
    #print(data["version"]["vulnerabilities"])  
    os.system('rm /code/wpscanner/' + row["namespace"] +   '.json')
    print(len(data["version"]["vulnerabilities"]))
    for el in data["version"]["vulnerabilities"]:
        el["timestamp"]= datetime.now(timezone.utc).isoformat() 
        el["network"] = row["network"]
        el["namespace"] = row["namespace"]
        id = uuid.uuid1() 
        es_log = esLog("wpscanvuln", 'log', id , json.dumps(el, default=str))
        sendToES(es_log)
        print(el)
    
