var express              = require('express');
var app                  = express();
var server               = require('http').createServer(app);
var io                   = require('socket.io').listen(server, { log: false });
var port                 = 3130;
var userList             = [];
var reloadTimer;

server.listen(port, function() {
    console.log('Listening on port: ' + port);
}); 

app.get('/', function(req, res) {
	res.sendfile(__dirname + '/index.html');
});

io.sockets.on('connection', function(socket) {
	socket.on('disconnect', function() {
		var user = findIndexOfUserById(socket.id);
	});
	socket.on('connected', function(userId) {
		var index    = findIndexOfUserByUserId(userId);
		var id       = socket.id;
		if(index == -1) { // new User
			userList.push({
				id: id,
				user_id: userId,
				first_seen: getTime(),
				latest_seen: getTime(),
			});
			console.log('User ID: ' + data.userId + ' has connected (ID: ' + data.id + ')');
		}
	});

	socket.on('onlineActive', function(userId) {
		var user = findUserByUserId(userId);
		updateLatestSeen(userId);
	});

	function reloadUserList() {
		userList = [];
		io.sockets.emit('connect');
		reloadTimer = setTimeout(reloadUserList, 10000);
	}
	if(!reloadTimer) {
		reloadUserList();
	}
});

function getTime() {
	var d = new Date();
	var date = [];
	date[0] = d.getFullYear();

	date[1] = d.getMonth()+1;
	date[1] = (date[1] < 10 ? '0' : '')+date[1];

	date[2] = d.getDate();
	date[2] = (date[2] < 10 ? '0' : '')+date[2];

	date[3] = d.getHours();
	date[3] = (date[3] < 10 ? '0' : '')+date[3];

	date[4] = d.getMinutes();
	date[4] = (date[4] < 10 ? '0' : '')+date[4];

	date[5] = d.getSeconds();
	date[5] = (date[5] < 10 ? '0' : '')+date[5];

	return date[0]+'-'+date[1]+'-'+date[2]+' '+date[3]+':'+date[4]+':'+date[5]
}

function updateLatestSeen(userId) {
	var index = findIndexOfUserByUserId(userId);
	userList[index].latest_seen = getTime();
	console.log([userList[index].first_seen, userList[index].latest_seen]);
}

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