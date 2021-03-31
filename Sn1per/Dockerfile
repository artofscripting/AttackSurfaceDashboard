FROM xerosecurity/sn1per
WORKDIR /code
RUN apt update
RUN apt install dos2unix -y
RUN apt install cron -y
COPY requirements.txt requirements.txt
RUN apt install python3 python3-pip -y
RUN pip3 install -r requirements.txt
#RUN su -c greenbone-nvt-sync abc
RUN crontab -l | { cat; echo " 0 8 * * * cd /code/amass/ && /usr/bin/python3 /code/scan.py > /proc/1/fd/1 2>/proc/1/fd/2"; } | crontab -
RUN crontab -l | { cat; echo " * * * * * echo \"Hello world\" >> /var/log/cron.log 2>&1"; } | crontab -
COPY . .
CMD /usr/sbin/cron -f
