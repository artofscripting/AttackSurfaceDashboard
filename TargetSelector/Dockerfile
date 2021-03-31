FROM debian
WORKDIR /code
RUN apt update
RUN apt install dos2unix -y
COPY requirements.txt requirements.txt
RUN apt install python3 python3-pip -y
RUN pip3 install -r requirements.txt
#RUN su -c greenbone-nvt-sync abc


COPY . .
CMD /usr/bin/python3 /code/targets/targetSelector.py
