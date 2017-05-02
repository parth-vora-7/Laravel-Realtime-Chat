var app = new Vue({
	el: '#app',
	components: {
		message: {
			props: ['sender', 'message', 'createdat'],
			template: '<div><b>{{ sender }}</b> - {{ createdat | showChatTime }}<p>{{ message }}</p></div>',
			filters: {
				showChatTime: function (createdat) {
					var date = new Date(createdat);
					return ("0" + date.getHours()).slice(-2) + ':' + ("0" + date.getMinutes()).slice(-2);
				}
			}
		},
	},
	data: {
		messages: '',
		message: '',
		isTyping: ''
	},
	methods: {
		sendMessage: function(event) {
			if(this.message.trim() == '' || this.message.trim == null) {
				return;
			}
			var th = this;
			axios.post(postChatURL, {
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
		},
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