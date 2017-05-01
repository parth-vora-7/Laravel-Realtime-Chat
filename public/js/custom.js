var app = new Vue({
	el: '#app',
	components: {
		message: {
			props: ['sender', 'message'],
			template: '<div><b>{{ sender }}</b><p>{{ message }}</p></div>'		
		}
	},
	data: {
		messages: '',
		message: '',
	},
	mounted: function() {
		if(fetchChatURL) {
			this.fetchChat();
		}
	},
	methods: {
		sendPrivateMessage: function(event) {
			var th = this;
			axios.post(savePrivateChatURL, {
				'message': th.message,
			})
			.then(function (response) {
				th.message = '';
				th.messages.push(response.data);
				th.adjustChatContainer();
			})
			.catch(function (error) {
				console.log(error);
			})
		},
		fetchChat: function() {
			var th = this;
			axios.get(fetchChatURL)
			.then(function (response) {
				th.messages = response.data.messages;
				th.adjustChatContainer();
			})
			.catch(function (error) {
				console.log(error);
			})
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
			this.messages.push(res.message);
		}, 
		adjustChatContainer: function() {
			var chatContainer = document.getElementById('messages');
			if(chatContainer) {
				chatContainer.scrollTop = chatContainer.scrollHeight;
			}
		},
		userIsTyping: function(chatRoomId) {
			console.log(chatRoomId);
			Echo.private('typing-room-' + chatRoomId)
			.whisper('typing', {
				name: window.Laravel.user.name
			});
		}
	},
})