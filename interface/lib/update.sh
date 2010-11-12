version=`curl http://gnaanas.xxpro.net/version.php 2> /dev/null`
wget -q -O /tmp/gnaanas.tar.bz2 "http://gnaanas.xxpro.net/releases/$version.tar.bz2"
tar xf /tmp/gnaanas.tar.bz2 -C /var/nas
chown www-data.www-data /var/nas -R
chmod 750 /var/nas -R
echo $version>/etc/nas/version.txt

