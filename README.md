
# Attack Surface Mapping Dashboard

Start the enviroment
From the folder that the docker-compose.yml file is in

`docker-compose up ` 

or 

 `docker-compose up --force-recreate  --build`

To connect to a container.

` docker exec -it <container name> /bin/bash`

For easy management install Portainer is install on port 9000

# Links
|Application| host:port|
|-----|-----|
|GVM |host:8080|
|TargetSelector |host:5001|
|Portainer |host:9000|
|Kibana |host:5601|
|Dashboard |host:80|
|PW Pusher |host:5003|

# Apps
- Sn1per Server
- Nmap server
- Kali Server
- WPScan
- Nikto
- Amass
- masscan
- Kibana
- Greenbone's Vulnerability Management

# Automation
- masscan scans every 5 mins
- wpscan runs once a day 
- nikto runs once a day
- GVM reports are pulled into database once a day
- amass scan runs once a day
- nmap vulnerability scan runs once a day agaist all live masscan targets

# Parts
## MassScanner

### MassScanner Has a cron job Scheduled by the Dockerfile to run every 5 mins for IP discovery from the targets.txt

#### Targets.txt should have no new line after last line.
Targets.txt should have the format 

> NMAPTARGET,NETWORK_SEGMENT_TAG,ORG

Each target must end with “,ORG”
ORG is the tag that pushes the data to the dashboard.

Manual run - 

    python3 monitor.py

All data is pushed to ElasticSearch Database

### MassScanner Has a cron job Scheduled by the Dockerfile to run every 10 mins for IP down detection.
downdetector.py

All data is pushed to ElasticSearch Database

## NmapScanner

Has a script monitor.py that will pull all IP and ports from the masscans and run Nmap scripts. Useful for finding poodle and similar vulnerabilities.

Manual run -

     python3 monitor.py

All data is pushed to ElasticSearch Database

## KaliScanner

 ## niktoscan

- Folder niktoscan has scan.py
#### Targets are selected from a file called targets.txt
Targets.txt should have the format 

> NIKTO_TARGET,NETWORK_SEGMENT_TAG,ORG

Each target must end with “,ORG”
ORG is the tag that pushes the data to the dashboard.

Manual run - 

    python3 scan.py

## wpscanner

Folder wpscanner has “scan.py”
Targets are selected from ElasticSearch Database. 

Manual run - 

    python3 scan.py

All data is pushed to ElasticSearch Database

## amass

- Folder amass has “scan.py”
- Targets are selected from ElasticSearch Database.

Manual run - python3 scan.py

## GVMScanner


Must be run manually from host:8080

Cron script must be run to schedule reports to dashboard.

    “dos2unix cron”
    
    “./cron”

Manual run - 

    python3 server.py

## PWPusher

Runs on port 5003

# Configure
docker-compose.yml
    
>      TWILIO_API_CLIENT=
>      TWILIO_API_KEY=
>      TWILIO_API_PHONE_TO=
>      TWILIO_API_PHONE_FROM=
>      WPSCAN_API_KEY=
>      MAX_DOWN= 

Masscanner downdetector.py
Set Limit for how many need to be down before Texting

` if count_missing > 10:
        client = Client("CLIENT", "KEY")
        client.messages.create(to="+PHONENUMBER", from_="+13213042557", body="Downdetector Alert!")
    else:
        print("No Mass Outage Detected")`
Masscanner targets.txt

niktoscan targets.txt

Go to host:5001/index to input hosts

