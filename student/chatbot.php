<!-- chatbot.php -->
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

<!-- Font Awesome (only load once per site) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

<!-- JavaScript -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('chatbotToggle');
    const chatContainer = document.getElementById('chatbotContainer');
    const chatMessages = document.getElementById('chatbotMessages');
    const chatInput = document.getElementById('chatbotInput');
    const chatSend = document.getElementById('chatbotSend');

    toggleBtn.addEventListener('click', function () {
      chatContainer.style.display = chatContainer.style.display === 'flex' ? 'none' : 'flex';
    });

    function sendMessage() {
      const message = chatInput.value.trim();
      if (message) {
        addMessage(message, 'user');
        chatInput.value = '';
        setTimeout(() => {
          addMessage("I'm a simple chatbot. More functionality can be added here.", 'bot');
        }, 500);
      }
    }

    function addMessage(text, sender) {
      const messageDiv = document.createElement('div');
      messageDiv.className = `message ${sender}`;
      messageDiv.textContent = text;
      chatMessages.appendChild(messageDiv);
      chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    chatSend.addEventListener('click', sendMessage);
    chatInput.addEventListener('keypress', function (e) {
      if (e.key === 'Enter') sendMessage();
    });
  });
</script>
