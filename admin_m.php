<?php
session_start();
require_once 'db_config.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$admin_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Admin Messages | WASILI</title>
    <style>
        .messages-container {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
            border-radius: 10px;
            background-color: #202528;
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

        .user-selector {
            margin-bottom: 20px;
        }

        .user-selector select {
            padding: 8px;
            border-radius: 5px;
            background-color: #181a1e;
            color: #ffffff;
            border: none;
            width: 100%;
        }

        .conversation {
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding: 10px;
            overflow-y: auto;
            background-color: #202528;
            border-radius: 4px;
            margin-bottom: 15px;
        }

        .message {
            max-width: 70%;
            padding: 12px;
            border-radius: 12px;
            position: relative;
        }

        .message.admin {
            background-color: transparent;
            margin-left: auto; /* This pushes it to the right */
            border-bottom-right-radius: 4px;

        }

        .message.user {
            background-color: transparent;
            margin-right: auto; /* This keeps it on the left */
            border-bottom-left-radius: 4px;
        }

        .message p {
            margin: 0px;
            padding: 10px;
            border-radius: 6px;
            word-wrap: break-word;
        }

        .message.admin p {
            background-color: #058283;
            color: #fff
        }

        .message.user p {
            background-color: #058283;
            color: #fff;
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
        .message .timestamp {
            font-size: 0.7rem;
            color: #666;
            text-align: right;
            margin-top: 4px;
            }

        .message.admin .timestamp {
            color: #4a6ea9;
        }

        .message.user .timestamp {
            color: #4a8f4a;
        }

        .message-header {
        font-weight: bold;
        margin-bottom: 4px;
        font-size: 0.85rem;
    }
    </style>
</head>

<body class="dark-mode">
    <div class="container">
        <!-- Sidebar Section -->
        <aside>
            <div class="toggle">
                <div class="logo">
                    <img src="images/logo.png">
                    <h2>WASILI<span class="danger"></span></h2>
                </div>
                <div class="close" id="close-btn">
                    <span class="material-icons-sharp">close</span>
                </div>
            </div>

            <div class="sidebar">
                <a href="dashboard.php" class="nav-link">
                    <span class="material-icons-sharp">dashboard</span>
                    <h3>Dashboard</h3>
                </a>
                <a href="Booking-Widget.php" class="nav-link">
                    <span class="material-icons-sharp">calendar_month</span>
                    <h3>Booking Widget</h3>
                </a>
                <a href="view_bookings.php" class="nav-link">
                    <span class="material-icons-sharp">local_shipping</span>
                    <h3>View Bookings</h3>
                </a>
                <a href="pricer.php" class="nav-link">
                    <span class="material-icons-sharp">credit_card</span>
                    <h3>Pricing Calculator</h3>
                </a>
                <a href="approved_shipments.php" class="nav-link">
                    <span class="material-icons-sharp">print</span>
                    <h3>Manage Shipments &amp; Print Invoice</h3>
                </a>
              
                <a href="admin_m.php" class="nav-link active">
                    <span class="material-icons-sharp">mail_outline</span>
                    <h3>Messages</h3>
                    <span class="message-count" id="message-count">.</span>
                </a>
                <a href="users.php" class="nav-link">
                    <span class="material-icons-sharp">person_outline</span>
                    <h3>Users</h3>
                </a>
                <a href="reports.php" class="nav-link">
                    <span class="material-icons-sharp">receipt_long</span>
                    <h3>Reports</h3>
                </a>

                <a href="#" class="nav-link">
                    <span class="material-icons-sharp">add</span>
                    <h3>New Login</h3>
                </a>
                <a href="logout.php" class="nav-link">
                    <span class="material-icons-sharp">logout</span>
                    <h3>Logout</h3>
                </a>
            </div>
        </aside>
        <!-- End of Sidebar Section -->

        <!-- Main Content -->
        <main>
            <div class="messages-container">
                <div class="messages-header">
                    <h2>Messages</h2>
                    <button id="refresh-btn">
                        <span class="material-icons-sharp">refresh</span>
                    </button>
                </div>

                <div class="user-selector">
                    <select id="user-select">
                        <!-- Options will be populated by JavaScript -->
                    </select>
                </div>

                <div class="conversation" id="conversation">
                    <!-- Messages will appear here -->
                </div>

                <div class="message-input">
                    <input type="text" id="message-input" placeholder="Type your message...">
                    <button id="send-btn">Send</button>
                </div>
            </div>
        </main>
    </div>

    <script>
    const adminId = <?php echo $admin_id; ?>;
    let currentPartnerId = null;

    // DOM elements
    const userSelect = document.getElementById('user-select');
    const conversationDiv = document.getElementById('conversation');
    const messageInput = document.getElementById('message-input');
    const sendBtn = document.getElementById('send-btn');
    const refreshBtn = document.getElementById('refresh-btn');

    // Load conversations list
    function loadConversations() {
        fetch('get_conversations.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    userSelect.innerHTML = '';
                    data.conversations.forEach(conv => {
                        const option = document.createElement('option');
                        option.value = conv.partner_id;
                        option.textContent = `${conv.partner_name} (${conv.partner_role})`;
                        userSelect.appendChild(option);
                    });
                    
                    // Load messages for first user by default
                    if (data.conversations.length > 0) {
                        currentPartnerId = data.conversations[0].partner_id;
                        loadMessages();
                    }
                }
            });
    }

    // Load messages for selected user
    function loadMessages() {
        currentPartnerId = userSelect.value;
        fetch(`fetch_messages.php?partner_id=${currentPartnerId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    conversationDiv.innerHTML = '';
                    data.messages.forEach(msg => {
                        const messageDiv = document.createElement('div');
                        messageDiv.className = `message ${msg.is_current_user ? 'user' : 'admin'}`;
                        // Inside the loadMessages function, update the messageDiv creation:
                        messageDiv.innerHTML = `
                            <div class="message-header">
                                ${msg.sender_name} (${msg.sender_role})
                            </div>
                            <p>${msg.message}</p>
                            <div class="timestamp">${formatTimestamp(msg.timestamp)}</div>
                        `;

                        // Keep the same formatTimestamp function
                        function formatTimestamp(timestamp) {
                            const date = new Date(timestamp);
                            return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) + 
                                ' • ' + date.toLocaleDateString([], { month: 'short', day: 'numeric' });
                        }
                        conversationDiv.appendChild(messageDiv);
                    });
                    conversationDiv.scrollTop = conversationDiv.scrollHeight;
                }
            });
    }

    // Send new message
    function sendMessage() {
        const message = messageInput.value.trim();
        if (message && currentPartnerId) {
            fetch('send_message.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `receiver_id=${currentPartnerId}&message=${encodeURIComponent(message)}`
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
    userSelect.addEventListener('change', loadMessages);
    sendBtn.addEventListener('click', sendMessage);
    refreshBtn.addEventListener('click', () => {
        loadConversations();
        if (currentPartnerId) loadMessages();
    });

    // Send message on Enter key
    messageInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });

    // Initialize
    loadConversations();
    setInterval(() => {
        if (currentPartnerId) loadMessages();
    }, 3000);
    </script>
</body>
</html>