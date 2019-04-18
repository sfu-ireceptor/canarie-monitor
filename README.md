# iReceptor CANARIE monitor

## Installation
On a VM with [Docker](https://docs.docker.com/install/linux/docker-ce/ubuntu/), create a file containing the list of the iReceptor services to monitor. Ex: `services.txt`:
```
APP_SERVICE_URL_1=https://ipa1.ireceptor.org/
APP_SERVICE_URL_2=https://ipa2.ireceptor.org/
```

It can contain up to 10 services. Just make sure to increment the number in the variable name (`APP_SERVICE_URL_3`, `APP_SERVICE_URL_4`, etc).

Then download and launch the container:
```
sudo docker run -p 80:80 --env-file services.txt --rm ireceptor/canarie-monitor
```

To check it's working, go to <http://localhost/service/stats> or execute:
```
curl http://localhost/service/stats
```
