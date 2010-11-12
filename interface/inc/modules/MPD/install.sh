if [ ! -f "/usr/bin/mpd" ]
then
	apt-get -qqy install devscripts vorbis-tools icecast2 libmp3lame-dev libasound2-plugins alsa alsa-tools alsa-utils
	apt-get -qqy build-dep mpd
	cd /usr/src
	apt-get source mpd
	cd mpd*/
	cp debian/rules debian/rules.bak
	sed 's/--disable-lame/--enable-lame-encoder/g' debian/rules.bak > debian/rules
	rm debian/rules.bak
	debuild binary
	dpkg -i ../*mpd*.deb
	/etc/init.d/mpd stop
	update-rc.d -f mpd remove
	update-rc.d -f icecast2 remove
	mkdir -p /etc/nas/conf/mpd
	cp /etc/default/icecast2 /tmp/icecast2.start
	sed 's/ENABLE=false/ENABLE=true/g' /tmp/icecast2.start > /etc/default/icecast2
	rm /tmp/icecast2.start
	wget -O /usr/share/icecast2/web/stille.mp3 http://gnaanas.xxpro.net/stille.mp3
	echo mpd hold | dpkg --set-selections
fi
