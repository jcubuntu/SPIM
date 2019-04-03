/* Global Script Variables (important!)
================================================================================================================== */
var tmp = {}, c = new Array();

/* This is executed when all scripts are loaded. This will also execute few other functions
================================================================================================================== */
$(function() {
	// Bind Facebook & Twitter buttons
	$('.share-area .facebook, .share-area .twitter').on('click', function() {

		if ( tmp['facebook-url'] == null || tmp['twitter-url'] == null ) return false;
		window.open( ( ( $(this).hasClass('facebook') ) ? tmp['facebook-url'] : tmp['twitter-url'] ), 'share', 'width=800, height=400');

		return false;

	});
console.log('asdasd');
	prepare();
});

/* Handle channel change (rebind things, change etc...)
================================================================================================================== */
function prepare() {

	// Reset per channel stuff
	tmp.onair = null;

	$('.onair .time').html('00:00');

	// Now the heavy work: init player, show loading and start reading stats, again
	clearInterval(tmp.radioinfo);
	tmp.radioinfo = setInterval(radioInfo, (parseInt(s.stats_refresh) * 1000));
	radioInfo();

	loadSound();
	txt(s.lang['status-stopped'], true);
};

/*================================================================================================================== */
function loadSound() {
	if(s.server_url) {
		createjs.Sound.registerSound(s.server_url, 1);
	}
	else {
		// Offline
	}
}


/* Most important function of them all, use jPlayer lib to deploy player and set things up!
================================================================================================================== */
function initPlayer () {

	var solution, supplied, autoplay, supplied = '';


	// Use HTML5 Solution as primary and Flash as fallback if no solution is found (DEFAULT)
	solution = 'html, flash';


	// Check for solutions from stream urls
	var suparr = new Array();
	$.each( s.channel.streams[tmp.quality], function(key, value) { suparr.push(key); } );
	supplied = suparr.join(', ');

	// Auto play check
	if (s.autoplay == 'true') {
		autoplay = 'play';
	}


	// Check cookie for volume
	var gVol = getcookie('volume');
	gVol = ((gVol != null) ? gVol : '0.5')


	// Error, exit before attempting to deploy
	if ( s.channel.streams[tmp.quality] == null ) {
		alert('ERROR: There has been issue with player configuration !');
		return false;
	}


	// If we have active radio clear media to set new Quality
	$("#jplayer-object").jPlayer("destroy");

	// Initiate settings and object
	var obj = $("#jplayer-object"), ready = false;
	obj.jPlayer({

		swfPath: "assets/flash/jquery.jplayer.swf",
		solution: solution,
		supplied: supplied,
		smoothPlayBar: false,
		errorAlerts: false,
		cssSelectorAncestor: "",
		volume: gVol,
		preload: 'none',
		cssSelector: {
			play: ".play",
			pause: ".stop",
			mute: ".volume-icon #volume",
			unmute: ".volume-icon #muted",
			volumeBar: ".volume-slider .vol-progress",
			volumeBarValue: ".volume-slider .vol-progress .vol-bar",
		},

		ready: function (event) {

			if(event.jPlayer.status.noVolume) {

				// Add a class and then CSS rules deal with it.
				$('.volume-control').addClass('no-volume');
				$('.volume-slider .player-status').css({ 'margin-top': '0' });

			}

			ready = true;

			if ( s.channel.streams[tmp.quality] == null ) {
				alert('ERROR: There has been issue with player configuration !');
				return false;
			}

			$(this).jPlayer('setMedia', s.channel.streams[tmp.quality]).jPlayer(autoplay);

		},

		pause: function() {
			$(this).jPlayer('clearMedia');
			txt(s.lang['status-stopped'], true);
		},

		error: function(event) {

			if (ready && event.jPlayer.error.type === $.jPlayer.error.URL_NOT_SET) {

				// Setup the media stream again and play it.
				$(this).jPlayer("setMedia", s.channel.streams[tmp.quality]).jPlayer('play');

			} else if (ready && event.jPlayer.error.type === $.jPlayer.error.URL) { 

				txt('ERROR: Unable to load stream!', true);

			} else {

				$('.preloader').removeClass('loadComplete').css({ 'visibility': 'visible', 'opacity' : 1 });
				$('.preloader .text_area').html('<span style="color: red;"><div style="font-weight: 500;">PLAYBACK ERROR</div> ' + event.jPlayer.error.message + '</span>');

			}
		},

		volumechange: function(event) {

			// Change main volume icons
			if (event.jPlayer.options.muted) {

				$('.volume-icon #volume').hide();
				$('.volume-icon #muted').show();

			} else {

				$('.volume-icon #muted').hide();
				$('.volume-icon #volume').show();

			}

			if (event.jPlayer.options.muted) { txt(s.lang['status-muted']); } else { txt(s.lang['status-volume'].replace('{LEVEL}', Math.floor(event.jPlayer.options.volume * 100) + '%')); }
			setcookie('volume', parseFloat(event.jPlayer.options.volume).toFixed(2), 365);

		}

	});


	// Create the volume slider control
	$('.volume-control').mousedown(function() {

		// Select specific element
		parent = $('.volume-slider .vol-progress');

		// Disable selecting any text on body while moving mouse
		$('body').css({ 
			'-ms-user-select': 'none',
			'-moz-user-select': 'none',
			'-webkit-user-select': 'none',
			'user-select': 'none'
		});

		// Bind mouse move event
		$(document).mousemove(function(e) {

			// Only work within the left/right limit
			if ( (e.pageX - $(parent).offset().left) < 1 ) { return false; }

			// Set other settings/variables
			var total = $('.volume-slider .vol-progress').width();
			obj.jPlayer("option", "muted", false);
			obj.jPlayer("option", "volume", (e.pageX - $(parent).offset().left +1) / total);
			tmp.moving = true;

		});

		// Unbind mousemove once we release mouse
		$(document).mouseup(function() {

			// Allow selecting text after releasing drag & drop
			$('body').removeAttr('style');

			// Unbind move events
			$(document).unbind('mousemove');

		});

	});


	// If Playlist is clicked, stop playback
	$('.playlists a').unbind('click').on('click', function() {

		if ( ready == true ) {
			obj.jPlayer('clearMedia'); 
			txt(s.lang['status-stopped'], true);
		}

	});


	// Remove loading message when player starts playing
	obj.unbind($.jPlayer.event.play); obj.unbind($.jPlayer.event.playing);
	obj.bind($.jPlayer.event.play, function(event) { txt(s.lang['status-init'].replace('{STREAM}', s.channel.name), true); });
	obj.bind($.jPlayer.event.playing, function(event) { txt(s.lang['status-playing'].replace('{STREAM}', s.channel.name), true); });

};


/* Few helper functions, not so much important that's why they're on bottom :)
================================================================================================================== */
function radioInfo() { // Ajax calls to get stream information

	// No channel yet? fine...
	if ( s.channel.name == null ) { return false; }


	// Call ajax
	$.ajax({

		url: 'index.php?c=' + s.channel.name,
		cache: false,
		dataType: 'json',
		timeout: (parseInt(s.stats_refresh) * 1000) - 1000, // Stats Refresh Speed -1000ms

		success: function(data) {

			// Few checks to ensure empty data isn't displayed and that we use tmp storage for artist/title
			if ( tmp.onair == null ) tmp.onair = {};			
			if ( data.artist == null || data.title == null ) return false;
			if ( data.artist == tmp.onair.artist && data.title == tmp.onair.title ) return false;

			// Now we're done with checks, do DOM content changes etc...
			$('.stats .artist').html('<a class="css-hint" data-title="' + data.artist + '" href="#">' + shorten(data.artist, s.artist_length) + '</a>'); 		// Change artist
			$('.stats .title').html('<a class="css-hint" data-title="' + data.title + '" href="#">' + shorten(data.title, s.title_length) + '</a>');			// Change title

			// Load image with preloader
			$('.artist-preload').show();
			$('#artist-img').attr('src', data.image).one('load', function() {
				$('.artist-preload').hide();
			});

			// If TRUE change window title on track load
			if ( s.dynamic_title == 'true' ) {
				if ( tmp.ptitle == null ) tmp['ptitle'] = document.title;
				document.title = data.artist + ' - ' + data.title + ' | ' + tmp['ptitle'];
			}

			// Check what do we share with twitter, radio name + channel or artist/title
			if ( data.artist == s.default_artist && data.title == s.default_title ) {

				var twitter_title 	= '' + s.title + ' #' + s.channel.name + '';

			} else { // Use artist & title

				var twitter_title 	= '"' + data.artist + ' - ' + data.title + '"';

			}

			// Global variables for Twitter & Facebook (Share/Tweet URL's)
			var currentURL = window.location.href.split('#')[0];
			tmp['facebook-url'] 	= 'https://www.facebook.com/sharer/sharer.php?u=' + currentURL; /* ?fbc=' + s.channel.name + '&a=' + data.artist + '&t=' + data.title; */
			tmp['twitter-url'] 		= 'https://twitter.com/share?url=' + currentURL + '&text=' + encodeURIComponent(s.lang['twitter-share'].replace('{TRACK}', twitter_title));

			// Set TMP variables
			tmp.onair = data;
			tmp.onair.timer = new Date().getTime();
			onairTime();

			// Disable checking if stats are disabled (this is a fix)
			if ( data.status != null && data.status == 'disabled' ) {
				clearInterval(tmp.radioinfo); 	// Stop refreshing
			}


	}}).fail(function( jqxhr, textStatus, error ) { $('.artist-preload').hide(); console.log( "Request Failed: " + textStatus + ', ' + error); });

}

// Simple function to show time since track was changed
function onairTime() {

	clearInterval(tmp.timer);

	// Don't attempt anything else if disabled
	if ( s.channel['show-time'] != true ) { $('.onair .time').html('00:00').hide(); return false; }

	// Clear and Reset interval
	tmp.timer = setInterval(function() {	

		// Exit if setting disabled
		if ( s.channel['show-time'] != true ) { clearInterval(tmp.timer); $('.onair .time').hide(); return false; }

		// Exit if "start" time is empty
		if ( tmp.onair == null || typeof (tmp.onair.timer) != 'number' ) return false;

		// Set var for easier management
		var ctime = ((new Date().getTime()) - tmp.onair.timer) / 1000;

		// Devide etc to show time with format
		var hour = ( ( Math.floor( ( ctime / 3600 ) % 60 ) > 10 ) ? Math.floor( ( ctime / 3600 ) % 60 ) : '0' + Math.floor( ( ctime / 3600 ) % 60 ) );
		var min  = ( ( Math.floor( ( ctime / 60 ) % 60 ) > 10 ) ? Math.floor( ( ctime / 60) % 60 ) : '0' + Math.floor( ( ctime / 60 ) % 60 ) );
		var sec  = ( ( ( ctime % 60 ) > 10 ) ? Math.floor( ctime % 60 ) : '0' + Math.floor( ctime % 60 ) );

		// Display only active timer (1h 2min 3sec)
		if (hour >= 1) { timer = hour + ':' + min + ':' + sec + ''; }
		else { timer = min + ':' + sec + ''; }

		// Write playtime on player
		$('.onair .time').show().html(timer);

		}, 1000);

}

// Simple function to use some jquery magic
function txt(text, perment) {

	var status = $('.player-status');

	// Set previous text into data-name attribute
	if ( perment == true || typeof(tmp['txt-status']) == undefined ) {
		tmp['txt-status'] = text;
	}

	// Don't set new timeout of there is one already!
	if (tmp['txtobj'] != null) {
		clearTimeout(tmp['txtobj']);
	}

	// Set new text into the element
	status.html(text);

	// Create Timer into window.object
	if ( perment == null ) {
		tmp['txtobj'] = setTimeout(function() { status.hide().html(tmp['txt-status']).fadeIn('slow'); }, 2000);
	}

}

// Shorten a string by specified length
function shorten($text, $length) {

	// Skip if max length defined zero
	if ( $length == '0' ) return $text;

	// Do the magic
	var length = $length || 10;
	if ($text.length > length) {
		$text = $text.substring(0, length)+'&hellip;';
	}

	return $text;
}

// Simple function to write cookie
function setcookie(name, value, expires, path, domain, secure) {

	var today = new Date();
	today.setTime(today.getTime());

	if (expires) {
		expires = expires * 1000 * 60 * 60 * 24;
	}

	var expires_date = new Date(today.getTime() + (expires));

	document.cookie = name+'=' + escape(value) +
	((expires) ? ';expires='+ expires_date.toGMTString() : '') + //expires.toGMTString()
	((path) ? ';path=' + path : '') +
	((domain) ? ';domain=' + domain : '') +
	((secure) ? ';secure' : '');

}

// Read cookievalue
function getcookie( name ) {

	var start = document.cookie.indexOf(name + "=");
	var len = start + name.length + 1;

	if ((!start) && (name != document.cookie.substring(0, name.length))) {
		return null;
	}

	if (start == -1) return null;

	var end = document.cookie.indexOf(';', len);

	if (end == -1) end = document.cookie.length;
	return unescape( document.cookie.substring(len, end));

}

// Delete cookie
function delcookie( name, path, domain ) {

	if (getcookie( name )) document.cookie = name + '=' +
		((path) ? ';path=' + path : '') +
		((domain) ? ';domain=' + domain : '') +
		';expires=Thu, 01-Jan-1970 00:00:01 GMT';

}

function isTouchDevice(){
	return typeof window.ontouchstart !== 'undefined';
}