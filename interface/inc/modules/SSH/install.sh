apt-get -qqy install ssh
/etc/init.d/ssh stop
update-rc.d -f ssh remove
