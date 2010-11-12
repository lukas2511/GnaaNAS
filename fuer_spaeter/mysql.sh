
# MySQL-Server

echo "Installing MySQL-Server.."
echo mysql-server-5.0 mysql-server/root_password password admin | debconf-set-selections
echo mysql-server-5.0 mysql-server/root_password_again password admin | debconf-set-selections
echo " Root-Login is 'admin'.."
echo " Installing MySQL-Server.."
apt-get -qqy install mysql-server >> installation.log 2>> installation.log
echo " Stopping MySQL-Server.."
/etc/init.d/mysql stop >> installation.log
echo " Disabling MySQL-Server.."
update-rc.d -f mysql remove >> installation.log

