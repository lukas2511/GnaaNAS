if [ ! -f "/etc/lighttpd/lighttpd.conf.bak" ]
then
	apt-get -qqy install php5-curl php5-dev php5-gd php5-imagick php5-imap php5-mcrypt php5-mysql php-pear php5-xmlrpc php5-sqlite php5-ffmpeg
	cp /etc/lighttpd/lighttpd.conf /etc/lighttpd/lighttpd.conf.bak
	sed 's/include_shell "\/usr\/share\/lighttpd\/use-ipv6.pl"//g' /etc/lighttpd/lighttpd.conf.bak > /etc/lighttpd/lighttpd.conf
	apt-get -f install
	/etc/init.d/lighttpd stop
	lighttpd-enable-mod fastcgi
	update-rc.d -f lighttpd remove
fi
