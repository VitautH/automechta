var fs = require('fs');
var mysql = require('mysql');
var https = require('https');
var moment = require('moment');
var express = require('express'),
    http = require('http');
var app = express();
var options = {
    key: fs.readFileSync('./privkey1.pem'),
    cert: fs.readFileSync('./fullchain1.pem'),
    requestCert: false,
    rejectUnauthorized: false
};
var serverPort = 3000;
var server = https.createServer(options, app);
var io = require('socket.io').listen(server);
var redis = require('redis');
var db = mysql.createConnection({
    host: "localhost",
    port: '3306',
    user: "root",
    password: "fONVORK6799",
    database: 'automecht'
});
var redisClientNotifySub = redis.createClient();
var redisClientChatPub = redis.createClient();
var redisClientChatSub = redis.createClient();
var redisClientChatToManagerLoadImageSub = redis.createClient();
var redisClientChatToUserLoadImageSub = redis.createClient();
var redisClientChatPubResponse = redis.createClient();
var redisClientChatSubResponse = redis.createClient();
db.connect();
io.on('connection', function (socket) {
    function sendUserContactData(socket_id, userId, user_name, contact) {
        var user_id_check = {user_id: userId};
        db.query("SELECT id FROM live_chat WHERE ?", user_id_check, function (error, result, fields) {
            if (error) {
                throw error;
            }
            else {
                if (result[0] === undefined) {

                    var user_id_insert = {};
                    user_id_insert.client_id = socket_id;
                    user_id_insert.user_id = userId;
                    user_id_insert.client_id = socket_id;
                    user_id_insert.user_name = user_name;
                    user_id_insert.contact = contact;
                    db.query('INSERT INTO live_chat SET ?', user_id_insert, function (error, results, fields) {
                        if (error) throw error;
                        socket.to(socket_id).emit('statusSendContactInformation', {status:true});
                    });
                }
                else {
                    db.query('UPDATE live_chat SET  ? WHERE  ?', [{
                        client_id: socket_id,
                        user_name: user_name,
                        contact: contact
                    }, {user_id: userId}], function (err, results) {
                        if (err) throw err;
                        socket.emit('statusSendContactInformation#user:'+userId, true);
                    });
                }
            }
        });
    }

    function login(socket_id, userId, message, site_user_id, avatar_url, user_name) {

        var user_id_check = {user_id: userId};
        db.query("SELECT id FROM live_chat WHERE ?", user_id_check, function (error, result, fields) {
            if (error) {
                throw error;
            }
            else {
                if (result[0] === undefined) {

                    var user_id_insert = {};
                    user_id_insert.client_id = socket_id;
                    user_id_insert.user_id = userId;

                    if (typeof site_user_id === undefined) {
                        user_id_insert.site_user_id = null;
                    }
                    else {
                        user_id_insert.site_user_id = site_user_id;
                    }

                    db.query('INSERT INTO live_chat SET ?', user_id_insert, function (error, results, fields) {
                        if (error) throw error;
                        sendMessage(userId, message);
                        sendMessageToAdmin(message, userId, socket_id, avatar_url, user_name);
                    });
                }
                else {

                    if (typeof site_user_id === undefined) {
                        site_user_id = null;
                    }


                    db.query('UPDATE live_chat SET  ? WHERE  ?', [{
                        client_id: socket_id,
                        site_user_id: site_user_id
                    }, {user_id: userId}], function (err, results) {
                        if (err) throw err;
                        sendMessage(userId, message);
                        sendMessageToAdmin(message, userId, socket_id, avatar_url, user_name);
                    });
                }
            }
        });
    }


    function sendMessage(userId, message) {
        var user_id_check = {user_id: userId};
        db.query("SELECT id FROM live_chat WHERE ?", user_id_check, function (error, result, fields) {
            if (error) throw error;
            var live_chat_request_msg = {live_chat_id: result[0].id, message: message, from: 'user', to: 'manager'};
            db.query('INSERT INTO live_chat_dialog SET ?', live_chat_request_msg, function (error, results, fields) {
                if (error) throw error;
            });
        });
    }


    function sendMessageToAdmin(message, user_id, socket_id, avatar_url, user_name) {
        var messageObject = {};
        messageObject.message = message;
        messageObject.time = moment().format('YYYY-MM-DD HH:mm');
        messageObject.user_id = user_id;
        messageObject.socket_id = socket_id;
        if (avatar_url !== undefined) {
            messageObject.avatar_url = avatar_url;
        }
        if (user_name !== undefined) {
            messageObject.user_name = user_name;
        }

        var user_id_check = {user_id: user_id};
        db.query("SELECT id FROM live_chat WHERE ?", user_id_check, function (error, result, fields) {
            if (error) throw error;
            messageObject.dialog_id = result[0].id;
            redisClientChatPub.publish('newMessageNotify', JSON.stringify(messageObject));
            messageObject = null;
        });
    }

    function responseSaveMessage(data) {
        var mess = data.message;
        var urlArray = findUrls(mess);
        urlArray.forEach(function (url) {
            var temp = mess.split(url);
            mess = temp.join("<a href=\"" + url + "\">" + url + "</a>");
        });

        var live_chat_response_msg = {live_chat_id: data.dialog_id, message: mess, from: 'manager', to: 'user'};
        db.query('INSERT INTO live_chat_dialog SET ?', live_chat_response_msg, function (error, results, fields) {
            if (error) throw error;
            var messageObject = {}
            messageObject.user_id = data.user_id;
            messageObject.message = mess;
            messageObject.dialog_id = data.dialog_id;
            messageObject.avatar = data.avatar;
            messageObject.time = moment().format('YYYY-MM-DD HH:mm');
            redisClientChatPubResponse.publish('responseMessage', JSON.stringify(messageObject));
            messageObject = null;

            var setViewed = [1, data.dialog_id];
            db.query('UPDATE live_chat_dialog SET viewed = ? WHERE live_chat_id = ?', setViewed, function (err, results) {
                if (err) throw err;
            });
        });
    }


    //ToDo: rename event "sendMessageRequest"
    socket.on('message', function (data) {

        var mess = data.message;
        var urlArray = findUrls(mess);
        urlArray.forEach(function (url) {
            var temp = mess.split(url);
            mess = temp.join("<a href=\"" + url + "\">" + url + "</a>");
        });

        login(socket.id, data.user_id, mess, data.site_user_id, data.avatar_url, data.user_name);

    });

    socket.on('sendUserContactData', function (data) {

        var user_name = data.user_name;
        var contact = data.contact;

        sendUserContactData(socket.id, data.user_id, data.user_name, data.contact);
    });

    socket.on('responseMessageSend', function (data) {
        responseSaveMessage(data);
    });

    redisClientChatSubResponse.subscribe('responseMessage');
    redisClientChatSubResponse.on("message", function (channel, message) {
        var data = JSON.parse(message);
        socket.emit('message-to:' + data.user_id, message);
        socket.emit('statusDeliveryMessageToClient', message);
    });

    redisClientChatSub.subscribe('newMessageNotify');
    redisClientChatSub.on("message", function (channel, message) {
        var data = JSON.parse(message);
        socket.emit(channel, message);
        socket.emit('statusDeliveryMessageToAdmin#user:' + data.user_id, message);
    });


    /*
    Notification event
     */
    redisClientNotifySub.subscribe('notification');
    redisClientNotifySub.on("message", function (channel, message) {
        socket.emit(channel, message);
    });

    /*
  Notification event
  Load Image to Chat
   */
    redisClientChatToManagerLoadImageSub.subscribe('chatToManagerLoadImage');
    redisClientChatToManagerLoadImageSub.on("message", function (channel, message) {
        socket.emit(channel, message);
    });

    redisClientChatToUserLoadImageSub.subscribe('chatToUserLoadImage');
    redisClientChatToUserLoadImageSub.on("message", function (channel, message) {
        var data = JSON.parse(message);
        socket.emit('upload-file-to:' + data.user_id, message);
    });

});

server.listen(serverPort, function () {

    console.log('server up and running at %s port', serverPort);
});

function findUrls(text) {
    var source = (text || '').toString();
    var urlArray = [];
    var url;
    var matchArray;

    // Regular expression to find FTP, HTTP(S) and email URLs.
    var regexToken = /(((ftp|https?):\/\/)|(www\.)[\-\w@:%_\+.~#?,&\/\/=]+)/g;

    // Iterate through any URLs in the text.
    while ((matchArray = regexToken.exec(source)) !== null) {
        var token = matchArray[0];
        urlArray.push(token);
    }

    return urlArray;
}