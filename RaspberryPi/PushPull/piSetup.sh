 #!/bin/bash
#last update April 2016
# Init
FILE="/tmp/out.$$"
GREP="/bin/grep"
#....
# Make sure only root can run our script
if [[ $EUID -ne 0 ]]; then
   echo "This script must be run as root" 1>&2
   exit 1
fi
# ...
	ip=0 #ip=1 means fix ip will start work
	webServer=0
	motion=0 #motion=1 install motion

#update and upgrade
#perl error fix
#For setting up web server webServer=1
#install mysql
#install php
#enable error log
#install apache+time increase
#enable mysql error log
#create a folder under /usr/local/xTron and peast mac.py
#set a cronTab for running mac.py every hour
#modify rc.local 
#install motion	
#setup ip address
	

DIR="/usr/local/xTron"
SERVER="http://pi.parallelthread.com/upload/firmware/mac.zip"

#Setup fix ip address if ip==1
address="10.10.50"
if [ $ip -eq 1 ]
   then
   	sudo perl -pi -e 's/iface eth0 inet dhcp/# iface eth0 inet dhcp/g' "/etc/network/interfaces"
		sudo echo -e "iface eth0 inet static\n \t address $address.193 \n\t netmask 255.255.255.0 \n\t network $address.0 \n\t broadcast $address.255 \n\t gateway $address.1" >> "/etc/network/interfaces"
		sudo ifconfig eth0 down && sudo ifconfig eth0 up
fi

#update and upgrade
sudo apt-get update && sudo apt-get upgrade -y

#no more perl error!
perlLang="/etc/ssh/ssh"
sudo perl -pi -e 's/SendEnv LANG LC_*/#  SendEnv LANG LC_*/g' "$perlLang""_config"
sudo perl -pi -e 's/AcceptEnv LANG LC_*/# AcceptEnv LANG LC_*/g' "$perlLang""d_config"

#start installing web server
if [ $webServer -eq 1 ]
   then
		sudo apt-get install apache2 apache2-doc apache2-utils -y
		sudo service apache2 restart
		#install MySQL
		sudo apt-get install mysql-server php5-mysql php5 php5-mcrypt php5-imagick phpmyadmin -y
		sudo mysql_install_db
		sudo mysql_secure_installation
		sudo php5enmod mcrypt
		sudo service apache2 restart
		#changing file upload size to 8GB!
		phpInI="/etc/php5/apache2/"
		if [ ! -f "$phpInI""original_php.ini" ]; then
			 sudo cp "$phpInIphp.ini" "$phpInIoriginal_php.ini"
		fi
		sudo perl -pi -e 's/upload_max_filesize =/upload_max_filesize = 8000M ; #/g' "$phpInI""php.ini"
		sudo perl -pi -e 's/post_max_size =/post_max_size = 8000M ; #/g' "$phpInI""php.ini"
		#turn on error log for php
		errorLog="/var/log/php_errors.log"
		sudo perl -pi -e 's/;error_log = php_errors.log/error_log = \/var\/log\/php_errors.log/g' "$phpInI""php.ini"
		sudo touch "$errorLog"
		sudo chown www-data "$errorLog"
		#apache upload time increase
		sudo echo "\$cfg['ExecTimeLimit'] = 0;" >> /etc/phpmyadmin/config.inc.php
		sudo service apache2 restart
		#turn on mysql error
		sudo perl -pi -e 's/#general_log = 1/general_log = 1/g' "/etc/mysql/my.cnf"
		sudo perl -pi -e 's/#log = /var/log/mysql/error.log/log = \/var\/log\/mysql\/error.log/g' "/etc/mysql/my.cnf"
		sudo service mysql restart
fi

#setting up folder for all operation
if [ -d "$DIR" ]; then
    printf '%s\n' "Removing ($DIR)"
    rm -rf "$DIR"
		printf '%s\n' "Making ($DIR)..."
		mkdir -p "$DIR"
		printf '%s\n' "complete making... ($DIR)"
else
    printf '%s\n' "Making... ($DIR)"
		mkdir -p "$DIR"
		printf '%s\n' "complete making... ($DIR)"
fi
#download mac.py which will run every hour to keep track of pi is alive
curl -sS $SERVER > mac.zip && \
unzip mac.zip              && \
rm -rf mac.zip
mv mac.py $DIR
crontab -l > mycron
#corntab setup
echo "0 * * * * sudo python /usr/local/xTron/mac.py" >> mycron
#install new cron file
crontab mycron
rm mycron
echo -e "sudo python /usr/local/xTron/mac.py\nexit 0" >> /etc/rc.local
#installing motion
if [ $motion -eq 1 ]
   then
		sudo apt-get install motion -y
fi
sudo init 6
