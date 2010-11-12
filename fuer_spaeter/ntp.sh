
# NTP

echo "Installing Time-Services.."
apt-get -qqy install ntp >> installation.log 2>> installation.log
echo " Stopping Time-Services.."
/etc/init.d/ntp stop >> installation.log
echo " Disabling Time-Services.."
update-rc.d -f ntp remove >> installation.log
