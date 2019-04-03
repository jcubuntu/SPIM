var express              = require('express');
var app                  = express();
var server               = require('http').createServer(app);
var io                   = require('socket.io').listen(server, { log: false });
var port                 = 3030;
var userList             = [];
var chatLogs			 = [];
var maxChatLogs 		 = 50;
var recheckTimer;

server.listen(port, function() {
    console.log('Listening on port: ' + port);
}); 

app.get('/', function(req, res) {
	res.sendfile(__dirname + '/index.html');
});

io.sockets.on('connection', function(socket) {
	socket.on('disconnect', function() {
		var id 	  = socket.id;
		var index = findIndexOfUserById(id);
		if(index > -1) {
			var user = userList[index];
			if(user.id.length <= 1) {
				userList.splice(index, 1);
				console.log(user.displayName + ' has disconnected (ID: ' + id + ')');
			} else {
				var indexOfSocketId = user.id.indexOf(id);
				userList[index].id.splice(indexOfSocketId, 1);
				console.log(user.displayName + ' has close a tab (ID: ' + id + ')');
			}
			io.sockets.emit('renderUser', userList);
		}
   	});

	socket.on('onConnected', function(user) {
		var index    = findIndexOfUserByUserId(user.user_id);
		var findUser = findUserByUserId(user.user_id);
		var id       = socket.id;
		if(index == -1) { // new User
			userList.push({
				id: [id], 
				user_id: user.user_id, 
				profileImage: user.profileImage, 
				displayName: user.displayName,
				gender: user.gender,
				type: user.type,
			});
			findUser = findUserByUserId(user.user_id);
			console.log(user.displayName + ' has connected (ID: ' + id + ')');
		} else {
			findUser.id.push(id);
		}

		socket.emit('onConnected', {id: id, user: findUser, chatLogs: chatLogs});
		io.sockets.emit('renderUser', userList);
	});

	socket.on('sendMessage', function(data) {
		var message  = data.message;
		var dateTime = data.dateTime;
		var user     = findUserById(data.id);
		var chatData = {message: message, user: user, dateTime: dateTime};
		if(user) {
			if(chatLogs.length >= maxChatLogs) {
				chatLogs.splice(0, 1);
			}
			chatLogs.push(chatData);
			console.log(user.displayName + ': ' + message);
			io.sockets.emit('sendMessage', chatData);
		}
	});

	socket.on('checkServerStatus', function() {
		socket.emit('checkServerStatus');
	});

	socket.on('recheckUserList', function(user) {
		var index    = findIndexOfUserByUserId(user.user_id);
		var findUser = findUserByUserId(user.user_id);
		var id       = socket.id;
		if(index == -1) { // new User
			userList.push({
				id: [id], 
				user_id: user.user_id, 
				profileImage: user.profileImage, 
				displayName: user.displayName,
				gender: user.gender,
				type: user.type,
			});
			findUser = findUserByUserId(user.user_id);
		} else {
			findUser.id.push(id);
		}
	});

	var recheckUserFunction = function() {
		io.sockets.emit('renderUser', userList);
		userList = [];
		io.sockets.emit('recheckUserList');
		recheckTimer = setTimeout(recheckUserFunction, 30000);
	};

	if(!recheckTimer) {
		recheckUserFunction();
	}

});

function findIndexOfUserByUserId(user_id) {
	var returnIndex = -1;
	userList.forEach(function(user, index) {
		if(user.user_id == user_id) {
			returnIndex = index;
		}
	});
	return returnIndex;
}
function findIndexOfUserById(id) {
	var returnIndex = -1;
	userList.forEach(function(user, index) {
		if(user.id.indexOf(id) > -1) {
			returnIndex = index;
		}
	});
	return returnIndex;
}
function findUserByUserId(user_id) {
	var returnUser = null;
	userList.forEach(function(user, index) {
		if(user.user_id == user_id) {
			returnUser = user;
		}
	});
	return returnUser;
}
function findUserById(id) {
	var returnUser = null;
	userList.forEach(function(user, index) {
		if(user.id.indexOf(id) > -1) {
			returnUser = user;
		}
	});
	return returnUser;
}