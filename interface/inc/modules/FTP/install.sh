apt-get --force-yes -qqy install pure-ftpd unzip
echo no > /etc/pure-ftpd/conf/PAMAuthentication
echo yes > /etc/pure-ftpd/conf/BrokenClientsCompatibility
/etc/init.d/pure-ftpd stop
update-rc.d -f pure-ftpd remove


cp -R /var/nas/inc/modules/FTP/web/* /var/nas/webftp

chown -R www-data.www-data /var/nas/webftp
