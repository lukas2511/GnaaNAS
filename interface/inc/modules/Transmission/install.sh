apt-get --force-yes -qqy install transmission-daemon transmission-cli
update-rc.d -f transmission-daemon remove
/etc/init.d/transmission-daemon stop
