from gvm.connections import UnixSocketConnection
from gvm.protocols.gmp import Gmp
from gvm.transforms import EtreeTransform
from gvm.xml import pretty_print
from elasticsearch import Elasticsearch, RequestsHttpConnection
from datetime import datetime, date, timezone
import json
import os

es_host = "es-container"
es = Elasticsearch([{'host': es_host, 'port': 9200}])
#connection = UnixSocketConnection()
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


path = '/usr/local/var/run/gvmd.sock'
connection = UnixSocketConnection(path=path)

transform = EtreeTransform()

with Gmp(connection, transform=transform) as gmp:
    # Retrieve GMP version supported by the remote daemon
    version = gmp.get_version()

    # Prints the XML in beautiful form
    pretty_print(version)

    # Login
    GVM_USER = os.getenv('GVM_USER')
    GVM_PASSWORD = os.getenv('GVM_PASSWORD')
    gmp.authenticate(GVM_USER,GVM_PASSWORD)

    # Retrieve all tasks
    tasks = gmp.get_tasks()
    #print(dir(gmp))
    
    # Get names of tasks

    #task_names = tasks.xpath('task/name/text()')
    task_names = tasks.xpath('task//@id')
    
    pretty_print(task_names)
   
    for taskid in task_names:
        if taskid == "":
            do = "nothing"
        else:
            task = gmp.get_task(taskid)
            report_ids = tasks.xpath('task/last_report/report/@id')
            for reportid in report_ids:
                print(reportid)
                try:
                    report = gmp.get_report(reportid, ignore_pagination="1")
                    
                    pretty_print(report.xpath('report/task/name'))
                    for results in report.xpath('report/report/results'):
                        pretty_print(results)
                        list_of_nvt = results.xpath('result/nvt/name/text()')
                        list_of_family = results.xpath('result/nvt/family/text()')
                        list_of_oid = results.xpath('result/nvt/@oid')
                        list_of_hosts = results.xpath('result/host/text()')
                        list_of_times = results.xpath('result/modification_time/text()')
                        list_of_ports = results.xpath('result/port/text()')
                        list_of_severity = results.xpath('result/severity/text()')
                       
                        index = 0
                        while index < len(list_of_hosts):
                            #if  float(list_of_severity[index]) > 4.0:
                                
                     
                            data = dict()
                            data["nvt"] = list_of_nvt[index]
                            data["oid"] = list_of_oid[index]
                            
                            data["family"] = list_of_family[index]
                            data["host"] = list_of_hosts[index]
                            data["port"] = list_of_ports[index]
                            data["severity"] = list_of_severity[index]
                            data["time"] = list_of_times[index]
                            
                            
                            
                            
                            
                            
                            
                            data["timestamp"]= datetime.now(timezone.utc).isoformat() 
                            
                            data["network"] = "ORG"
                            id = uuid.uuid1() 
                            es_log = esLog("gvmreports", 'log', id , json.dumps(data, default=str))
                            sendToES(es_log)
                            print(json.dumps(data, default=str))
                
                
                
                            index += 1
                        
                except:
                    print("failure")
                #pretty_print(report)
            break
    