
# Transmission Torrent-Client

echo "Installing Transmission Torrent-Client.."
apt-get -qqy install transmission-daemon >> installation.log 2>> installation.log
echo " Stopping Transmission Torrent-Client.."
/etc/init.d/transmission-daemon stop >> installation.log
echo " Disabling Transmission Torrent-Client.."
update-rc.d -f transmission-daemon remove >> installation.log
