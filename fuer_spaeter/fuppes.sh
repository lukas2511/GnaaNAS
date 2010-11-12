# FUPPES (UPNP)

#echo "Installing FUPPES.."
#echo " Installing needed tools for FUPPES (this could take some time).."
#apt-get -qqy install libmpeg4ip-dev libmp4v2-dev build-essential subversion autoconf automake gettext libtool libpcre3-dev libxml2-dev libsqlite3-dev libfaad-dev libmad0-dev libflac-dev libmagickwand-dev libvorbis-dev libtwolame-dev libmpcdec-dev uuid-dev libavformat-dev libavutil-dev libavcodec-dev libtag1-dev libexpat1-dev >> installation.log 2>> installation.log
#echo " Downloading FUPPES.."
#svn co https://fuppes.svn.sourceforge.net/svnroot/fuppes/trunk /tmp/fuppes >> installation.log
#cd /tmp/fuppes
#echo " Compiling FUPPES.."
#autoreconf -vfi >> installation.log 2>> installation.log
#./configure --prefix=/usr --sysconfdir=/etc >> installation.log 2>> installation.log
#make -j2 >> installation.log 2>> installation.log
#make install >> installation.log 2>> installation.log
