var activeTimer;
socket.on('connect', function() {
	socket.emit('connected', {userId: userId, sessionId: sessionId});
	clearInterval(activeTimer);
	active();
});
socket.on('disconnect', function() {
	console.log('asasd');
	clearInterval(activeTimer);
});

var active = function() {
	clearInterval(activeTimer);
	socket.emit('onlineActive', userId);
	activeTimer = setTimeout(active, 1000);
}

