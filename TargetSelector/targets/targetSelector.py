import time
import socket
import json
import urllib.parse
import requests  as rq
from elasticsearch import Elasticsearch
from flask import Flask, request, render_template,redirect
import app.models as dbHandler

es_host = "es-container"
es  = Elasticsearch([{'host': es_host, 'port': 9200}])

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
    es.index(index=esllog.indexName, doc_type=esllog.type_of_doc, id=esllog.i_d, body=json.loads(esllog.js))

    


app = Flask(__name__)

@app.route('/index')
def my_form():
    return render_template('my-form.html')



@app.route('/list')
def get_list():
    query  = {
      
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
    time.sleep(1)    
    res = es.search(index="targetselection", body=query)
    content = "<table><tr><td>target </td><td>type_of_target </td><td>network </td><td>Enabled</td><td> namespace </td><td>actions</td></tr>"
    for hit in res["hits"]["hits"]:
    
        target = hit["_source"]["target"]
        type_of_target = hit["_source"]["type_of_target"]
        network = hit["_source"]["network"]
        namespace = hit["_source"]["namespace"]
        enabled = str(hit["_source"]["enabled"])
        urlcontent = "target=" + target + "&" + "type_of_target=" + type_of_target + "&" + "network=" + network + "&" + "namespace=" + namespace + "&" + "enabled=" + enabled
        targetname = target
        target = urllib.parse.quote_plus(target)
        
        content = content + "<tr><td>" + targetname + "</td><td>" + type_of_target + "</td><td>" + network + "</td><td><a href='/disabletarget?" + urlcontent + "'>" + enabled + "</a></td><td>" + namespace + "</td><td><a href='/deletetarget?target=" + target + type_of_target + "'>Delete</a> <a href='/deletetarget?target=" + target + "'>LD</a><td></tr>"
    
    content = content + "</table>"
    return content
@app.route('/disabletarget')
def disabletarget():
    target = request.args.get('target') #if key doesn't exist, returns None
    
    type_of_target = request.args.get('type_of_target')
    network = request.args.get('network')
    namespace = request.args.get('namespace')
    enabled = request.args.get('enabled')
    data = dict()
    data["target"] = target
    data["type_of_target"] = type_of_target #CIDR,DNS,URL,IP
    data["network"] = network 
    data["namespace"] = namespace
    if enabled == "True":
        data["enabled"] = False
    if enabled == "False":
        data["enabled"] = True    
    es_log = esLog("targetselection", 'log', target+data["type_of_target"] , json.dumps(data, default=str))
    sendToES(es_log)
    
 
    return redirect("/list", code=302)



@app.route('/deletetarget')
def deletetarget():
    target = request.args.get('target') #if key doesn't exist, returns None
    #curl -X DELETE es_host:9200/targetselection/_doc/target?routing=shard-1&pretty"
    
      
    # Making a DELETE request 
    r = rq.delete('http://' + es_host + ':9200/targetselection/_doc/' + target + '?routing=shard-1&pretty') 
      
    # check status code for response received 
    # success code - 200 
    print(r) 
    return redirect("/list", code=302)


@app.route('/index', methods=['POST'])
def my_form_post():
    data = dict()
    target = request.form['target']
    type_of_target = request.form['type']
    network = request.form['network']
    namespace = request.form['namespace']
    data["target"] = target
    data["type_of_target"] = type_of_target #CIDR,DNS,URL,IP
    data["network"] = network 
    data["namespace"] = namespace
    data["enabled"] = True
    es_log = esLog("targetselection", 'log', target + data["type_of_target"], json.dumps(data, default=str))
    sendToES(es_log)
    #print(data)
    
    
    return json.dumps(data)
    
    
app.run(host='0.0.0.0', port=80,debug=True)


#data = dict()

