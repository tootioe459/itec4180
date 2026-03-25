const chatBox = document.getElementById('chat-box');
const chatForm = document.getElementById('chat-form');
const messageInput = document.getElementById('message');
const statusText = document.getElementById('status');

function escapeHtml(value) {
    const div = document.createElement('div');
    div.textContent = value;
    return div.innerHTML;
}

function renderMessages(messages) {
    const wasNearBottom =
        chatBox.scrollHeight - chatBox.scrollTop - chatBox.clientHeight < 50;

    if (!Array.isArray(messages) || messages.length === 0) {
        chatBox.innerHTML = '<div class="empty-state">No messages yet.</div>';
        return;
    }

    chatBox.innerHTML = messages.map(msg => `
        <div class="message">
            <div class="message-meta">
                <strong>${escapeHtml(msg.username)}</strong>
                <span>${escapeHtml(msg.created_at)}</span>
            </div>
            <div class="message-body">${escapeHtml(msg.message)}</div>
        </div>
    `).join('');

    if (wasNearBottom) {
        chatBox.scrollTop = chatBox.scrollHeight;
    }
}

async function loadMessages() {
    try {
        const response = await fetch(window.CHAT_CONFIG.messagesUrl, {
            headers: {
                'Accept': 'application/json'
            }
        });

        if (!response.ok) {
            statusText.textContent = 'Could not load messages.';
            return;
        }

        const data = await response.json();
        renderMessages(data.messages ?? []);
        statusText.textContent = '';
    } catch (error) {
        statusText.textContent = 'Connection problem while loading messages.';
    }
}

async function sendMessage(message) {
    const response = await fetch(window.CHAT_CONFIG.sendUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ message })
    });

    return response.json();
}

if (chatForm) {
    chatForm.addEventListener('submit', async (event) => {
        event.preventDefault();

        const message = messageInput.value.trim();
        if (!message) return;

        try {
            const result = await sendMessage(message);

            if (result.error) {
                statusText.textContent = result.error;
                return;
            }

            messageInput.value = '';
            statusText.textContent = '';
            await loadMessages();
            messageInput.focus();
        } catch (error) {
            statusText.textContent = 'Could not send message.';
        }
    });

    loadMessages();
    setInterval(loadMessages, 2000);
}
