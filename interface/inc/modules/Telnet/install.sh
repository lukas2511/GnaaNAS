apt-get -qqy install telnetd
if [ ! -f "/usr/sbin/in.telnetd.enabled" ]
then
	mv /usr/sbin/in.telnetd /usr/sbin/in.telnetd.enabled
fi
if [ ! -f "/usr/sbin/in.telnetd.disabled" ]
then
	echo '#!/bin/bash' > /usr/sbin/in.telnetd.disabled
	echo "exit 0" >> /usr/sbin/in.telnetd.disabled
fi
cp /usr/sbin/in.telnetd.disabled /usr/sbin/in.telnetd
cp /bin/true /bin/true.again
chmod +x /usr/sbin/in.telnetd
