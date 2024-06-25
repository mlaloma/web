// Mostrar/ocultar el contenedor del chat al hacer clic en la burbuja
document.getElementById('chat-bubble').addEventListener('click', function() {
    var chatContainer = document.getElementById('chat-container');
    if (chatContainer.style.display === 'none' || chatContainer.style.display === '') {
        chatContainer.style.display = 'block';
    } else {
        chatContainer.style.display = 'none';
    }
});

// Cerrar el contenedor del chat al hacer clic en el botón de cerrar
document.querySelector('.close-button').addEventListener('click', function() {
    document.getElementById('chat-container').style.display = 'none';
});

// Maneja el evento click del botón de enviar
document.getElementById('send-button').addEventListener('click', function() {
    sendMessage();
});

// Maneja el evento keypress del campo de entrada del usuario
document.getElementById('user-input').addEventListener('keypress', function(event) {
    if (event.key === 'Enter') {
        sendMessage();
    }
});

// Función para enviar un mensaje al chatbot
function sendMessage() {
    var userInput = document.getElementById('user-input').value;
    appendMessage('user', userInput);

    // Realiza una solicitud AJAX para obtener la respuesta del chatbot
    var xhr = new XMLHttpRequest();
    xhr.open('POST', chatbot_ajax.ajax_url, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                appendMessage('bot', response.response);
            } else {
                appendMessage('bot', 'Error al obtener la respuesta del chatbot.');
            }
        }
    };
    xhr.send('action=get_chatbot_response&message=' + encodeURIComponent(userInput));

    // Borra el contenido del campo de entrada del usuario
    document.getElementById('user-input').value = '';
}

// Función para agregar un mensaje al contenedor de mensajes del chat
function appendMessage(sender, message) {
    var chatMessages = document.getElementById('chat-messages');
    var messageElement = document.createElement('div');
    messageElement.className = sender === 'user' ? 'user-message' : 'bot-message';
    messageElement.textContent = message;
    chatMessages.appendChild(messageElement);

    // Desplaza automáticamente el contenedor de mensajes hacia abajo para mostrar el último mensaje
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

// Función para ajustar el tamaño del chat
function adjustChatSize(increase) {
    var chatContainer = document.getElementById('chat-container');
    var currentWidth = chatContainer.offsetWidth;
    var currentHeight = chatContainer.offsetHeight;
    var newWidth = increase ? currentWidth + 50 : currentWidth - 50;
    var newHeight = increase ? currentHeight + 50 : currentHeight - 50;
    chatContainer.style.width = newWidth + 'px';
    chatContainer.style.height = newHeight + 'px';
    document.getElementById('chat-messages').style.height = `calc(100% - 120px)`;
}

// Maneja el evento click de los botones de redimensionar
document.getElementById('increase-size').addEventListener('click', function() {
    adjustChatSize(true);
});

document.getElementById('decrease-size').addEventListener('click', function() {
    adjustChatSize(false);
});
