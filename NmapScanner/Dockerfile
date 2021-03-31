FROM debian
WORKDIR /code
ENV FLASK_APP=app.py
ENV FLASK_RUN_HOST=0.0.0.0
COPY requirements.txt requirements.txt
RUN apt update
RUN apt install libpcap-dev -y
RUN apt install python3 python3-pip -y
RUN apt install nmap -y
RUN apt install dos2unix -y
RUN apt install cron vim watch -y
COPY cron_run /code/cron_run
RUN chmod 0744 /code/cron_run
RUN chmod +x /code/cron_run
RUN touch /var/log/cron.log
RUN pip3 install -r requirements.txt
RUN crontab -l | { cat; echo " 0 7 * * * /bin/bash /code/cron_run > /proc/1/fd/1 2>/proc/1/fd/2"; } | crontab -
RUN crontab -l | { cat; echo " * * * * * echo \"Hello world\" >> /var/log/cron.log 2>&1"; } | crontab -
RUN dos2unix /code/cron_run
RUN service cron start



# Run the command on container startup
#CMD cron && tail -f /var/log/cron.log

EXPOSE 5000
COPY . .
#CMD ["flask", "run"]
CMD /usr/sbin/cron -f
