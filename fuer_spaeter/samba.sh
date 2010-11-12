
# Samba

echo "Installing Samba-Server.."
echo samba samba/run_mode text daemons | debconf-set-selections
echo samba-common samba-common/workgroup text WORKGROUP | debconf-set-selections
echo samba-common samba-common/dhcp text false | debconf-set-selections
apt-get -qqy install samba >> installation.log 2>> installation.log
echo " Stopping Samba-Server.."
/etc/init.d/samba stop >> installation.log
echo " Disabling Samba-Server.."
update-rc.d -f samba remove >> installation.log
