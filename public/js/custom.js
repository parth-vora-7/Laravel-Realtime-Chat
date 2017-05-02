var app = new Vue({
	el: '#app',
	components: {
		message: {
			props: ['sender', 'message', 'createdat'],
			template: '<div><b>{{ sender }}</b> {{ createdat }}<p>{{ message }}</p></div>',
		}
	},
	data: {
		messages: '',
		message: '',
		isTyping: ''
	},
	methods: {
		sendPrivateMessage: function(event) {
			if(this.message.trim() == '' || this.message.trim == null) {
				return;
			}
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
				th.messages = response.data;
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
			window.Echo.private(`typing-room-${chatRoomId}`)
			.whisper('typing', {
				name: window.Laravel.user.name
			});
		}
	},
	postedOn: function(created_at) {
		var date = new Date(created_at);
		return date.getHours() + ' ' + date.getMinutes();
	},
	mounted: function() {
		if(fetchChatURL) {
			this.fetchChat();
		}
	},
	updated: function() {
		this.adjustChatContainer();
	},
})