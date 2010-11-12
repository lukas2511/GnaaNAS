#!/bin/bash

usermod -c "" -d /mnt $(cat /etc/passwd | grep :1000: | awk -F ':' '{print $1}') >> installation.log 2>> installation.log

mkdir -p /etc/nas/conf /etc/nas/services /etc/nas/build
echo "server.port = 81" > /etc/nas/conf/port

mkdir -p /var/nas /var/nas/inc/installed
chown 33.33 /var/nas

chown 1000.1000 /mnt
chmod 777 /mnt
echo "umask 00" >> /etc/profile

if [ ! "$(cat /etc/debian_version)" = "squeeze/sid" ]
then
	echo 'Installation only under Debian Squeeze *hrhr*'
	exit 1;
fi

cat > /etc/apt/sources.list << EOF
deb http://ftp.de.debian.org/debian/ testing main contrib non-free
deb-src http://ftp.de.debian.org/debian/ testing main contrib non-free
deb http://mirror.optus.net/debian-multimedia/ testing main
deb-src http://mirror.optus.net/debian-multimedia/ testing main
EOF

# System Update

echo "Updating System.."
echo " Fetching package lists.."
apt-get -qq update 2>> installation.log
echo " Installing optional keyrings.."
apt-get --force-yes -qqy install debian-multimedia-keyring >> installation.log 2>> installation.log
echo " Installing subversion.."
apt-get -qqy install subversion >> installation.log 2>> installation.log
echo " Fetching package lists.. again.."
apt-get -qq update >> installation.log 2>> installation.log
echo " Installing Software Updates.."
apt-get -qqy upgrade >> installation.log 2>> installation.log
echo " Installing System Updates.."
apt-get -qqy dist-upgrade >> installation.log 2>> installation.log

# WebInterface

echo "Configuring WebInterface.."
apt-get -qqy install curl lighttpd php5-cgi php5-cli screen bzip2 sudo >> installation.log 2>> installation.log
cp -R /var/log/lighttpd /var/log/nas
chown www-data.www-data /var/log/nas -R
mkdir -p /etc/nas/ssl
pwd="$(pwd)"
cd /etc/nas/ssl
openssl req -new -x509 -keyout server.pem -out server.pem -days 365 -nodes -batch
chown -R www-data.www-data /etc/nas/ssl -R
chmod 600 /etc/nas/ssl -R
cd "$pwd"

version=`curl http://gnaanas.xxpro.net/version.php 2> /dev/null`
echo $version>/etc/nas/version.txt
wget -q -O /tmp/gnaanas.tar.bz2 http://gnaanas.xxpro.net/releases/$version.tar.bz2 >> installation.log 2>> installation.log
mkdir -p /var/nas/inc/modules
tar xf /tmp/gnaanas.tar.bz2 -C /var/nas
chown www-data.www-data /var/nas -R
chmod 750 /var/nas -R
echo "www-data ALL=NOPASSWD: ALL" >> /etc/sudoers
ln -s /var/nas/lib/nas.conf /etc/nas/nas.conf
sed 's/lighttpd/nas/g' /etc/init.d/lighttpd > /etc/init.d/nas.tmp
sed 's/sbin\/nas/sbin\/lighttpd/g' /etc/init.d/nas.tmp > /etc/init.d/nas
rm /etc/init.d/nas.tmp
chmod a+x /etc/init.d/nas
update-rc.d nas defaults >> installation.log
/etc/init.d/nas start >> installation.log 2>> installation.log
