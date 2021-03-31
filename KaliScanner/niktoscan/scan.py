from elasticsearch import Elasticsearch
from datetime import datetime, date, timezone
import time
import socket
import os
import json
import xmltodict    
import uuid
import csv

es_host = "3.133.235.65"

elastic_client  = Elasticsearch([{'host': es_host, 'port': 9200}])


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
    

def scan(http_s, csv_f):
    for row in csv_f:
        print(row[1])
        os.system(' nikto --host ' + http_s + '://' + row[0] + ' --Format csv -o /tmp/' + row[0] + '.csv')
        f2 = open('/tmp/' + row[0] + '.csv')
        csv_f2 = csv.reader(f2)

        for row2 in csv_f2:
            if not skipfirstrow:
                print(row2)
                site = row2[0]
                ip = row2[1]
                port = row2[2]
                findingid = row2[3]
                method = row2[4]
                url = row2[5]
                description = row2[6]
                #namespace = row[3]
                network = row[1]

                log = dict()
                log["timestamp"]= datetime.now(timezone.utc).isoformat()
                log["site"] = site
                log["ip"] = ip
                log["port"] = port
                log["findingid"] = findingid
                log["method"] = method
                log["url"] = url
                log["description"] = description
                log["namespace"] = "ORG"
                log["network"] = network
                id = uuid.uuid1()
                es_log = esLog("niktoscans", 'log', id , json.dumps(log, default=str))
                try:
                    sendToES(es_log)
                except:
                    donothing = ""
            else:
               skipfirstrow = False
    
f = open('/home/kali/niktoscan/targets.txt')
csv_f = csv.reader(f)
skipfirstrow = True
try:
    scan("http", csv_f)
except:
    one = 1
try:
    scan("https", csv_f)
except:
    one = 1

    
 
