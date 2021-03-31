import csv
import os
from elasticsearch import Elasticsearch, RequestsHttpConnection
import uuid 
import json

from datetime import datetime, date, timezone
import sys, os.path


es = Elasticsearch([{'host': "es-container", 'port': 9200}])

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

f = open('/code/targets.txt')
csv_f = csv.reader(f)

for row in csv_f:
    print(row[1])
    os.system('/usr/bin/masscan -p25,22,443,8443,1434,2001,80,990,21,179 ' + row[0] + ' --rate=10000 --wait 3 -oJ /tmp/' + row[1] +   '.json')
    print(row[1] +   '.json')

    #try:
    import codecs
    with codecs.open("/tmp/" + row[1] +   '.json', 'r', encoding='utf8') as f:
        datasource = f.read()
    #print(datasource[:-4] + "]")
    print(datasource)
    data = json.loads(datasource[:-4] + "]")
    print(data)
    os.system('rm /tmp/' + row[1] +   '.json')
    for el in data:
        el["timestamp"]= datetime.now(timezone.utc).isoformat()
        el["network"] = row[1]
        el["namespace"] = row[2]
        id = uuid.uuid1()
        es_log = esLog("masscantopports", 'log', id , json.dumps(el, default=str))
        sendToES(es_log)
        print(el)
    #except:
    #    donothing = ""