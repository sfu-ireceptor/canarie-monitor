# iReceptor CANARIE monitor

## Installation
1. Install [Docker](https://docs.docker.com/install/linux/docker-ce/ubuntu/)
2. Create a file `services.txt` with the list of iReceptor services to monitor, for example:
```
APP_SERVICE_URL_1=https://ipa1.ireceptor.org/
APP_SERVICE_URL_2=https://ipa2.ireceptor.org/
```

`services.txt` can contain up to 10 services. Make sure to increment the number in the variable name (`APP_SERVICE_URL_3`, `APP_SERVICE_URL_4`, etc).

4. Download and launch the Docker container:
```
sudo docker run -p 80:80 --env-file services.txt --rm ireceptor/canarie-monitor
```

## Check it's working

Go to <http://localhost/service/stats> or execute:
```
curl http://localhost/service/stats
```
