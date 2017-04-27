Vue.component('pv-message', {
	props: ['sender', 'message'],
	template: '<div><b>{{ sender }}:</b><p>{{ message }}</p></div>'
})

var app = new Vue({
	el: '#app',
	data: {
		message: '',
	},
	mounted: function() {
		var chatContainer = $('.chat-messages');
		if(chatContainer.length) {
			chatContainer.scrollTop(chatContainer[0].scrollHeight);
		}
	},
	methods: {
		sendPrivateMessage: function(evevt) {
			var url = event.currentTarget.getAttribute('action');
			var th = this;
			axios.post(url, {
				'message': th.message,
			})
			.then(function (response) {
				th.message = '';
			})
			.catch(function (error) {
				console.log(error);
			})
		},
		getChat: function() {
			// var th = this;
			// axios.get(getGroupMessageMessages()
			// .then(function (response) {
			// 	console.log(response);
			// })
			// .catch(function (error) {
			// 	console.log(error);
			// })
		},
		sendGroupMessage: function() {
			var th = this;
			axios.post(groupMessageRoute, {
				'message': th.message,
			})
			.then(function (response) {
				th.message = '';
			})
			.catch(function (error) {
				console.log(error);
			})
		},
		userIsTyping: function() {
			Echo.private('chat')
			.whisper('typing', {
				name: loggedInUser.name
			});
		},
		updateChat: function(res) {
			console.log('asd');
		}
	},
})

/*function updateChat(res) {	
	var chatContainer = $('.chat-messages');
	var messageHtml = '<div>';
	messageHtml += '<b>' + res.sender.name + '</b>';
	messageHtml += '<p>' + res.message.message + '</p>';
	messageHtml += '</div>';
	chatContainer.append(messageHtml);
	chatContainer.scrollTop(chatContainer[0].scrollHeight);
}*/