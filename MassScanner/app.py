import time

from flask import Flask
from pymongo import MongoClient
from bson.json_util import dumps



app = Flask(__name__)
import urllib.parse
username = urllib.parse.quote_plus('root')

password = urllib.parse.quote_plus('amsec')

myclient = MongoClient('mongodb://%s:%s@mongo' % (username, password))

mydb = myclient["SCANS"]

mycol = mydb["MASSCANS"]

def get_hit_count():
    retries = 5
import json
import os
@app.route('/scan')
def startScan():
    home_dir = os.system("masscan -oJ /code/results.json --ports 80,443 --wait 2 160.153.73.131 &")
    return "Started Scan"

@app.route('/')
def hello():

    myresult = mycol.find().limit(500)
    output = ""
    # print the result:
    for x in myresult:
        output = output + dumps(x) + ", "

    return str(output)


    count = 0
    return 'Hello World! I have been seen {} times.\n'.format(count)