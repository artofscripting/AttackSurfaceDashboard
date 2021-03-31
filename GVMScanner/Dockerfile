FROM isaudits/gvm:gvm-20.8
WORKDIR /code
RUN apt update
RUN apt install dos2unix
COPY requirements.txt requirements.txt
COPY cron cron
#RUN su -c greenbone-nvt-sync abc
COPY cron_run /code/cron_run
COPY server.py /code/server.py
RUN chmod 0744 /code/cron_run
RUN chmod +x /code/cron_run
RUN touch /var/log/cron.log
RUN apt install vim -y
RUN dos2unix /code/cron_run
RUN service cron start
RUN apt install hugepages -y
RUN apt install python3 python3-pip -y
RUN pip3 install -r requirements.txt
RUN chmod +x /code/cron_run
#RUN crontab -l | { cat; echo " 0 8 * * * /bin/bash /code/cron_run > /proc/1/fd/1 2>/proc/1/fd/2"; } | crontab -
#RUN crontab -l | { cat; echo " * * * * * echo \"Hello world\" >> /var/log/cron.log 2>&1"; } | crontab -
EXPOSE 9392
EXPOSE 5432
#ENTRYPOINT ["tail"]
#CMD ["-f","/dev/null"]
#CMD ["flask", "run"]
#CMD /usr/sbin/cron -f
CMD /bin/bash /code/cron && tail -f /dev/null
