# iReceptor CANARIE monitor

## Installation
1. Install [Docker](https://docs.docker.com/install/linux/docker-ce/ubuntu/):
```
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh
```

2. Create a file `services.txt` with the list of iReceptor services to monitor, for example:
```
APP_SERVICE_URL_1=https://ipa1.ireceptor.org/
APP_SERVICE_URL_2=https://ipa2.ireceptor.org/
```
`services.txt` can contain up to 10 services. Make sure to increment the number in the variable name (`APP_SERVICE_URL_3`, `APP_SERVICE_URL_4`, etc).


3. Download the system service
```
sudo curl -o /etc/systemd/system/canarie-monitor.service https://raw.githubusercontent.com/sfu-ireceptor/canarie-monitor/master/util/canarie-monitor.service
```

In the system service (`/etc/systemd/system/canarie-monitor.service`), adjust the path to `services.txt.` if necessary. By default, it's `/home/ubuntu/services.txt`.

4. Enable and start the system service. Note: this will take a while because it will download the Docker image from Docker Hub.
```
sudo systemctl enable /etc/systemd/system/canarie-monitor.service
sudo systemctl start canarie-monitor.service
```

## Check it's working

Go to <http://localhost/service/stats> or execute:
```
curl http://localhost/service/stats
```

## Troubleshooting

### Start/stop system service
```
sudo systemctl start canarie-monitor.service
sudo systemctl stop canarie-monitor.service
```

### System service status
```
sudo systemctl status canarie-monitor.service
```

### System service log
```
journalctl -u canarie-monitor.service 
```
