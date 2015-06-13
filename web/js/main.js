
$(function(){
	function getUserList(){
		$.ajax({
			type: 'GET',
			url : 'chat/user-list',
			dataType: 'json',
			
			success: function(response){
				var html = '<ul>';

				l = response.data.length;
				for(var i = 0; i < l; i++){
					html += '<li>' 
						+ response.data[i]['username']
						+ '</li>';
				}

				html += '</ul>'; 

				$('#userList').html(html);
			},

			error: function(){
				$('#userList').html('error: can\'t get user list');
			}
		});
	}

	function getMessages(){
		$.ajax({
			type: 'GET',
			url : 'chat/message-list',
			dataType: 'json',
			
			success: function(response){
				//console.log(response);
				var html = '';

				l = response.data.length;
				html += '<ul>'; 

				for(var i = 0; i < l; i++){
					html += '<li>' 
						+ response.data[i].date['date'] 
						+ ' '
						+ response.data[i].username
						+ ': '
						+ response.data[i].content
						+ '</li>';
				}

				html += '</ul>'; 

				$('#messages').html(html);

				var domObject = document.getElementById("messages");
				domObject.scrollTop = domObject.scrollHeight;
			},

			error: function(){
				$('#messages').html('error: can\'t get messages list');
			}
		});
	}

	function postMessage(){
		var messageContent = $('#newMessage').val();
		
		$.ajax({
			type: 'POST',
			url : 'chat/message-add',
			data: {messageContent: messageContent},
			dataType: 'json',

			success: function(){
				getMessages();
				$('#newMessage').val('');
			},

			error: function(){
				
			}
		});
	}

	getUserList();
	getMessages();

	setInterval(function(){
		getUserList();		
	}, 4000);

	setInterval(function(){
		getMessages();		
	}, 2000);

	$('#newMessage').keyup(function(e){
		if(e.which == 13){
			postMessage();	
		}
	});
});



