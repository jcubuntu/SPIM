var socket = io.connect(configs.server_url);
var reconnectTimer;
var checkServerStatusTimer;
var id;
var scrolling = false;
var latestMessageClick = false;
$sendBtn = $('button#sendBtn');
$messageBox = $('textarea#message');

var checkServerStatus = function() {
	socket.emit('checkServerStatus');
	checkServerStatusTimer = setTimeout(reconnectToServer, 5000);
};

var setServerStatus = function(status, count) {
	var html;
	var label = $('.server-status > span.label');
	var toggleBtn = $('#toggle-chat-server');
	if(status) {
		toggleBtn.addClass('btn-danger').removeClass('btn-success');
		toggleBtn.html('<i class="fa fa-close"></i> Stop');
		label.addClass('label-success').removeClass('label-danger').html('ONLINE: <span id="user-online">' + count + '</span>');
	} else {
		toggleBtn.addClass('btn-success').removeClass('btn-danger');
		toggleBtn.html('<i class="fa fa-check"></i> Start');
		label.addClass('label-danger').removeClass('label-success').html('OFFLINE');
	}
}

var bindLink = function() {
	$('a[href="#"]').not('.message').unbind().click(function(e) {
		e.preventDefault();
	});
}

var getUserLink = function(user, message) {
	var url = (user.type == 'user' ? (configs.basePath + '/profile/' + user.user_id) : '#.');
	var target = (user.type == 'user' ? 'target="_blank"' : '');
	return '<a href="' + url + '"' + target + ' title="' + (user.displayName) + '" data-toggle="tooltip">'+(!!message ? message : user.displayName)+'</a>';
}
var showLatestMessage = function(message) {
	$('.latestMessage').show();
	$('.latestMessage a.message').html(message);
}
var hideLatestMessage = function() {
	$('.latestMessage').hide();
}

var sendMessage = function(message, dateTime, user) {
	var html          = '';

	var height = $('.message-box').scrollTop() | 0;
    if(height == $(".message-box")[0].scrollHeight-400 && !scrolling) {
		scrollToBot();
		hideLatestMessage();
    } else {
    	var latestMessage = '';
    	if(!!user) {
    		latestMessage = '<strong>' + user.displayName + ': </strong>' + message;
    	} else {
    		latestMessage = '<strong>STSTEM: </strong>' + message;
    	}
    	showLatestMessage(latestMessage);
    }

	if(!!user) {
		message = _.escape(message);
		html  = '<tr>' + 
				'	<td class="avatar">' + 
				'		' + getUserLink(user, '<img src="' + user.profileImage + '" alt="' + user.displayName + '" class="img-rounded">') + 
				'	</td>' + 
				'	<td>' + 
				'		<div class="name col-xs-6">' + getUserLink(user) + '</div> <small class="time col-xs-6 text-right"><i class="fa fa-clock-o"></i> ' + dateTime + '</small>' + 
				'		<div class="clearfix"></div>' + 
				'		<div class="message">' + message + '</div>' + 
				'	</td>' + 
				'</tr>';
	} else {
		html  = '<tr class="system">' +
				'	<td colspan="2">' +
				'		<div class="alert alert-warning"><strong>SYSTEM:</strong> ' + message + '</div>' +
				'	</td>' +
				'</tr>';
	}

	$('.message-box table').append(html);
	bindLink();
}

var connectToServer = function() {
	if(!(!!id)) {
		$sendBtn.button('loading');
		$messageBox.attr('disabled', true);
		socket.emit('onConnected', userInfo);
		reconnectTimer = setTimeout(reconnectToServer, 5000);
	}
}
var renderUserList = function(userList) {
	$('.user-list ul').find('li').not('.sender').remove();

	$.each(userList, function(index, user) {
		if(user && user.type == 'user') {
			var genderIcon;
			if(user.gender == 'M') genderIcon = 'fa-mars';
			else if(user.gender == 'F') genderIcon = 'fa-venus';
			else genderIcon = 'fa-transgender';

			if(!!user.id && user.id.indexOf(id) == -1) {
				var li = $('<li>'+getUserLink(user, '<i class="fa ' + genderIcon + '"></i> ' + user.displayName)+'</li>');
				li.appendTo($('.user-list ul'));
			} else {
				$('.user-list ul').find('li.sender').html(getUserLink(user, '<i class="fa ' + genderIcon + '"></i> ' + user.displayName));
			}
		}
	});

	$.each(userList, function(index, user) {
		if(user && user.type == 'guest') {
			var genderIcon;
			if(user.gender == 'M') genderIcon = 'fa-mars';
			else if(user.gender == 'F') genderIcon = 'fa-venus';
			else genderIcon = 'fa-transgender';

			if(!!user.id && user.id.indexOf(id) == -1) {
				var li = $('<li class="guest">'+getUserLink(user, '<i class="fa ' + genderIcon + '"></i> ' + user.displayName)+'</li>');
				li.appendTo($('.user-list ul'));
			} else {
				$('.user-list ul').find('li.sender').html(getUserLink(user, '<i class="fa ' + genderIcon + '"></i> ' + user.displayName));
			}
		}
	});
	setServerStatus(true, userList.length);
	bindLink();
	$('[data-toggle="tooltip"]').unbind().tooltip({placement: "bottom"});
}

var scrollToBot = function() {
	$(".message-box").animate({ scrollTop: $(".message-box")[0].scrollHeight }, 1000, 'swing', function() {
		latestMessageClick = false;
	});
}

$(document).ready(function() {
	$('#toggle-chat-server').click(function() {
		var url = $(this).data('url');
		var token = $(this).data('token');
		$.ajax({
			url: url,
			method: "POST",
			data: {_token: token},
			success: function(response) {
				if(response.action == 'success') {
					toastr.success(response.message);
				} else {
					toastr.error(response.message);
				}
			},
			complete: function() {
				checkServerStatus();
			}
		});
	});
	$('.message-box').scroll(_.debounce(function(){
		if(!latestMessageClick) {
		    scrolling = true;
		    $('.message-box').stop(true, true);
		    var height = $('.message-box').scrollTop() | 0;
			if(height == $(".message-box")[0].scrollHeight-400) {
				hideLatestMessage();
		    }
		}
	}, 150, { 'leading': true, 'trailing': false }));

	$('.message-box').scroll(_.debounce(function(){
		scrolling = false;
	    var height = $('.message-box').scrollTop();
		if(height == $(".message-box")[0].scrollHeight-400) {
			hideLatestMessage();
	    }
	}, 150));

	$('.latestMessage a.message').click(function(e) {
		e.preventDefault();
		scrollToBot();
		latestMessageClick = true;
		hideLatestMessage();
	});

	connectToServer();

	$messageBox.keydown(function(e){
	    if (e.keyCode == 13 && !e.shiftKey) {
	        $sendBtn.click();
	        e.preventDefault();
	    }
	});

	/* Button */
	$sendBtn.data('loading-text', '<i class="fa fa-send"></i> <span class="visible-lg-inline">Sending...</span>');
	$sendBtn.click(function() { // sending
		var message = $messageBox.val().trim();
		message = message.length > 500 ? message.substring(0, 500) : message;
		if(message.length) {
			var formattedDate = new Date();
			var date          = formattedDate.getDate();
			var month         = formattedDate.getMonth();
			var hour          = formattedDate.getHours();
			var minute        = formattedDate.getMinutes();
			var second        = formattedDate.getSeconds();

			date   = date < 10 ? '0'+date : date;
			hour   = hour < 10 ? '0'+hour : hour;
			minute = minute < 10 ? '0'+minute : minute;
			second = second < 10 ? '0'+second : second;

			var dateTime      = date + ' ' + monthName[month] + ' ' + hour + ':' + minute + ':' + second;

			$sendBtn.button('loading');
			$messageBox.attr('disabled', true);
			setTimeout(function() {
				socket.emit('sendMessage', {id: id, message: message, dateTime: dateTime});
			}, 300);
		} else {
			$messageBox.focus();
		}
	});
});

var reconnectToServer = function() {
	sendMessage('ขออภัยไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้ กำลังลองเชื่อมต่ออีกครั้งใน 5 วินาที...');
	socket.socket.connect();
	connectToServer();
}

/* Callback */

socket.on('connect', function() {
	clearInterval(reconnectTimer);
	$('button#sendBtn').button('reset');
	$messageBox.removeAttr('disabled');
	$('textarea#message').focus();
});
socket.on('disconnect', function() {
	id = null;
	$sendBtn.button('loading');
	$messageBox.attr('disabled', true);
	setServerStatus(false);
	reconnectToServer();
});
socket.on('checkServerStatus', function() {
	clearTimeout(checkServerStatusTimer);
});
socket.on('onConnected', function(data) {
	var dataUser = data.user;
	if(dataUser.user_id == userInfo.user_id) {
		if(dataUser.id.length == 1) {
			sendMessage('เชื่อมต่อเซิร์ฟเวอร์แล้ว');
		}
		userInfo.displayName = dataUser.displayName;
		id                   = data.id;
		$.each(data.chatLogs, function(index, value) {
			sendMessage(value.message, value.dateTime, value.user);
		});
	}
	setTimeout(scrollToBot, 500);
});
socket.on('sendMessage', function(data) {
	$('button#sendBtn').button('reset');
	$('textarea#message').val('');
	$messageBox.removeAttr('disabled');
	$('textarea#message').focus();
	sendMessage(data.message, data.dateTime, data.user);
});
socket.on('renderUser', function(userList) {
	renderUserList(userList);
});
socket.on('recheckUserList', function() {
	socket.emit('recheckUserList', userInfo);
});