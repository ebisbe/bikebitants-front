#!/usr/bin/env bash

########################################################
#
# Get info on currently running "shipit" container
#
APP_CONTAINER=$(sudo docker ps -a -q --filter="name=shipit")
NEW_CONTAINER="shipit`date +"%s"`"

########################################################
#
# Deploy a new container
#

# Pull latest
sudo docker pull localhost:5000/bikebitants.com/app

# Don't deploy if latest image is running
RUNNING_IMAGE=$(sudo ocker inspect $APP_CONTAINER | jq ".[0].Image")
CURRENT_IMAGE=$(sudo docker image inspect localhost:5000/bikebitants.com/app:latest | jq ".[0].Id")

if [ "$CURRENT_IMAGE" == "$RUNNING_IMAGE" ]; then
    echo ">>> Most recent image is already in use"
    exit 0
fi

SHARED_PATHS="-v /var/www/bikebitants_files/app:/var/www/html/storage/app"

# Start new instances
NEW_APP_CONTAINER=$(sudo docker run -d --network=bikebitants -e CONTAINER_ENV=production --restart=always --name="$NEW_CONTAINER" $SHARED_PATHS localhost:5000/bikebitants.com/app)

# Wait for processes to boot up
sleep 5

echo "Started new container $NEW_APP_CONTAINER"

# Update Nginx
sudo sed -i "s/server shipit.*/server $NEW_CONTAINER:80;/" /opt/conf.d/default.conf

# Configtest Nginx
sudo docker exec nginx nginx -t
NGINX_STABLE=$?

if [ $NGINX_STABLE -eq 0 ]; then
    # Reload Nginx
    sudo docker kill -s HUP nginx

    # Stop older instance
    sudo docker stop $APP_CONTAINER
    sudo docker rm -v $APP_CONTAINER
    echo "Removed old app container $APP_CONTAINER"

    # Cleanup, if any dangling images
    DANGLING_IMAGES=$(sudo docker image ls -f "dangling=true" -q)
    if [ ! -z "$DANGLING_IMAGES" ]; then
        sudo docker image rm $(sudo docker image ls -f "dangling=true" -q)
    fi

else
    echo "ERROR: Nginx configuration test failed!"
    exit 1
fi