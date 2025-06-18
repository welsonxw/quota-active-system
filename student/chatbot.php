<?php
// Chatbot functionality will be implemented here
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <!-- Floating Chatbot Button -->
    <button class="chatbot-btn" id="chatbotToggle">
        <i class="fas fa-comment-dots"></i>
    </button>

    <!-- Chatbot Container -->
    <div class="chatbot-container" id="chatbotContainer">
        <div class="chatbot-header">
            Quota System Assistant
        </div>
        <div class="chatbot-messages" id="chatbotMessages">
            <!-- Messages will appear here -->
        </div>
        <div class="chatbot-input">
            <input type="text" id="chatbotInput" placeholder="Type your message...">
            <button id="chatbotSend">Send</button>
        </div>
    </div>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
    <!-- JavaScript for chatbot functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('chatbotToggle');
            const chatContainer = document.getElementById('chatbotContainer');
            const chatMessages = document.getElementById('chatbotMessages');
            const chatInput = document.getElementById('chatbotInput');
            const chatSend = document.getElementById('chatbotSend');

            // Toggle chat visibility
            toggleBtn.addEventListener('click', function() {
                if (chatContainer.style.display === 'flex') {
                    chatContainer.style.display = 'none';
                } else {
                    chatContainer.style.display = 'flex';
                }
            });

            // Send message function
            function sendMessage() {
                const message = chatInput.value.trim();
                if (message) {
                    // Add user message
                    addMessage(message, 'user');
                    chatInput.value = '';
                    
                    // Simulate bot response
                    setTimeout(() => {
                        addMessage('I\'m a simple chatbot. More functionality can be added here.', 'bot');
                    }, 500);
                }
            }

            // Add message to chat
            function addMessage(text, sender) {
                const messageDiv = document.createElement('div');
                messageDiv.className = `message ${sender}`;
                messageDiv.textContent = text;
                chatMessages.appendChild(messageDiv);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }

            // Send message on button click or Enter key
            chatSend.addEventListener('click', sendMessage);
            chatInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    sendMessage();
                }
            });
        });
    </script>
</body>
</html>