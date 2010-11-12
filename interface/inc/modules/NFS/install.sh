apt-get -qqy install nfs-kernel-server
/etc/init.d/nfs-kernel-server stop
update-rc.d -f nfs-kernel-server remove
