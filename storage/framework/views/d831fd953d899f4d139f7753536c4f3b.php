<!-- Right-Side Chatbox (Draggable) -->
<div id="chatbox" 
     class="position-fixed" 
     style="top: 80px; right: 20px; width: 320px; height: 450px; 
            background: white; border-radius: 10px; 
            box-shadow: 0 4px 10px rgba(0,0,0,0.1); 
            overflow: hidden; display: flex; flex-direction: column; 
            z-index: 1050; cursor: default;">

    <div id="chatHeader" class="bg-gradient-primary text-white p-2 d-flex justify-content-between align-items-center" style="cursor: move;">
        <strong><i class="fa-brands fa-facebook-messenger"></i> Messenger</strong>
        <button id="toggleChatbox" class="btn btn-sm btn-light text-dark p-1">
            <i class="fas fa-minus"></i>
        </button>
    </div>

    <div id="chatMessages" class="flex-grow-1 p-2 overflow-auto" style="font-size: 14px;">
        <div class="text-center text-muted mt-3">Loading messages...</div>
    </div>

    <form id="chatForm" class="p-2 border-top bg-light">
        <div class="input-group">
            <input type="text" id="chatInput" name="message" class="form-control form-control-sm " placeholder="Type a message..." required>
            <button type="submit" class="btn bg-gradient-primary btn-sm ml-1"><i class="fas fa-paper-plane"></i></button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const chatBtn = document.getElementById('chat-floating-btn');
        const chatBox = document.getElementById('chatbox');
        const closeBtn = document.getElementById('toggleChatbox');

        chatBtn.addEventListener('click', () => {
            chatBox.classList.toggle('active');
            chatBox.classList.toggle('d-none');
        });

        closeBtn.addEventListener('click', () => {
            chatBox.classList.add('d-none');
            chatBox.classList.remove('active');
        });
    });

    function renderMessages(messages) {
        const chatMessages = document.getElementById('chatMessages');
        chatMessages.innerHTML = ''; // clear old

        let lastDate = '';

        messages.forEach(msg => {
            // If date changed, show a divider
            if (msg.date_label !== lastDate) {
                const divider = document.createElement('div');
                divider.classList.add('chat-date-divider');
                divider.innerHTML = `<span>${msg.date_label}</span>`;
                chatMessages.appendChild(divider);
                lastDate = msg.date_label;
            }

            // Message bubble
            const messageDiv = document.createElement('div');
            messageDiv.classList.add('mb-2');
            messageDiv.innerHTML = `
                <div class="${msg.user_id === USER_ID ? 'text-right' : 'text-left'}">
                    <div class="p-2 rounded ${msg.user_id === USER_ID ? 'bg-primary text-white' : 'bg-light text-dark'} d-inline-block">
                        <strong>${msg.user_name}:</strong> ${msg.message}
                    </div>
                </div>
            `;
            chatMessages.appendChild(messageDiv);
        });

        // Auto-scroll to bottom
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

</script><?php /**PATH F:\laragon\www\library\resources\views/chat/index.blade.php ENDPATH**/ ?>