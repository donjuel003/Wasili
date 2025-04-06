<?php
session_start();
$conn = new mysqli("localhost", "root", "", "myshop");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id='$user_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

// Get admin ID
$admin_query = $conn->query("SELECT id FROM users WHERE role='admin' LIMIT 1");
$admin = $admin_query->fetch_assoc();
$admin_id = $admin['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Messages | WASILI</title>
    <style>
        body {
            width: 100%;
            height: 100vh;
            background: linear-gradient(to left, rgba(13, 13, 25, 0.5) 50%, rgba(13, 13, 25, 0.5) 50%), url(scania.jpg) center / cover;
            background-repeat: no-repeat;
        }
        main {
            width: 90%;
            max-width: 1200px;
            padding: 2rem;
            background: rgba(46, 44, 44, 0.2);
            backdrop-filter: blur(6px);
            border-radius: 1rem;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        .messages-container {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
            border-radius: 10px;
            background-color: transparent;
            padding: 20px;
            color: #ffffff;
        }
        .messages-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .messages-header h2 {
            color: #ffffff;
        }
        .conversation {
            flex-grow: 1;
            overflow-y: auto;
            margin-bottom: 20px;
            padding-right: 10px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .message {
            max-width: 70%;
            padding: 12px;
            border-radius: 12px;
        }
        .message p {
            margin: 0;
            word-wrap: break-word;
        }
        .message .timestamp {
            font-size: 0.7rem;
            color: #aaa;
            text-align: right;
            margin-top: 5px;
        }
        .message.admin {
            align-self: flex-start;
            background-color: #444857;
            border-bottom-left-radius: 4px;
        }
        .message.user {
            align-self: flex-end;
            background-color: #058283;
            border-bottom-right-radius: 4px;
        }
        .message-input {
            display: flex;
            gap: 10px;
        }
        .message-input input[type="text"] {
            flex-grow: 1;
            padding: 10px;
            border: none;
            border-radius: 5px;
            outline: none;
            background-color: #444857;
            color: #ffffff;
        }
        .message-input button {
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #058283;
            color: #ffffff;
            cursor: pointer;
        }
        .message-input button:hover {
            background-color: #066666;
        }
    </style>
</head>
<body class="dark-mode">
    <div class="container">
        <aside>
            <div class="toggle">
                <div class="profile">
                    <div class="info">
                        <p>Hey, <b><?php echo htmlspecialchars($user['name']); ?></b></p>
                        <small class="text-muted"><?php echo ucfirst($user['role']); ?></small>
                    </div>
                </div>
            </div>
        </aside>

        <main>
            <div class="messages-container">
                <div class="messages-header">
                    <h2>Messages</h2>
                    <button id="refresh-messages" title="Refresh Messages">
                        <span class="material-icons-sharp">refresh</span>
                    </button>
                </div>

                <div class="conversation" id="conversation">
                    <!-- Messages will load here -->
                </div>

                <div class="message-input">
                    <input type="text" id="message-input" placeholder="Type your message here...">
                    <button id="send-message">
                        <span class="material-icons-sharp">send</span>
                    </button>
                </div>
            </div>
        </main>
    </div>

    <script>
    const conversation = document.getElementById("conversation");
    const messageInput = document.getElementById("message-input");
    const sendButton = document.getElementById("send-message");
    const refreshButton = document.getElementById("refresh-messages");

    const currentUserId = <?php echo $user_id; ?>;
    const adminId = <?php echo $admin_id; ?>;

    function formatTimestamp(timestamp) {
        const date = new Date(timestamp);
        return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) + 
               ' • ' + date.toLocaleDateString([], { month: 'short', day: 'numeric' });
    }

    function loadMessages() {
        fetch(`fetch_messages.php?user1_id=${currentUserId}&user2_id=${adminId}`)
            .then(response => {
                if (!response.ok) throw new Error('Network error');
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    conversation.innerHTML = '';
                    data.messages.forEach(msg => {
                        const messageDiv = document.createElement('div');
                        const isCurrentUser = msg.sender_id == currentUserId;
                        messageDiv.className = `message ${isCurrentUser ? 'user' : 'admin'}`;
                        messageDiv.innerHTML = `
                            <p>${msg.message}</p>
                            <div class="timestamp">${formatTimestamp(msg.timestamp)}</div>
                        `;
                        conversation.appendChild(messageDiv);
                    });
                    conversation.scrollTop = conversation.scrollHeight;
                } else {
                    console.error('Error:', data.error);
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function sendMessage() {
        const message = messageInput.value.trim();
        if (message) {
            fetch('send_message.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `sender_id=${currentUserId}&receiver_id=${adminId}&message=${encodeURIComponent(message)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    messageInput.value = '';
                    loadMessages();
                }
            });
        }
    }

    // Event listeners
    sendButton.addEventListener('click', sendMessage);
    refreshButton.addEventListener('click', loadMessages);
    messageInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') sendMessage();
    });

    // Initial load and refresh every 3 seconds
    loadMessages();
    setInterval(loadMessages, 3000);
    </script>
</body>
</html>