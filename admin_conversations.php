<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Admin Conversations | WASILI</title>
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

        .user-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .user-item {
            padding: 10px;
            background-color: #444857;
            border-radius: 5px;
            cursor: pointer;
            color: #ffffff;
        }

        .user-item:hover {
            background-color: #058283;
        }
    </style>
</head>

<body class="dark-mode">
    <div class="container">
        <!-- Main Content -->
        <main>
            <h2>User Conversations</h2>
            <div class="user-list" id="user-list">
                <!-- User list will be dynamically loaded here -->
            </div>
        </main>
    </div>

    <script>
        const userList = document.getElementById("user-list");

        // Fetch users who have sent messages to the admin
        fetch("fetch_users_with_messages.php")
            .then(response => response.json())
            .then(users => {
                users.forEach(user => {
                    const userItem = document.createElement("div");
                    userItem.classList.add("user-item");
                    userItem.innerHTML = `${user.name} (${user.email})`;
                    userItem.addEventListener("click", () => {
                        window.location.href = `admin_m.php?user_id=${user.id}`;
                    });
                    userList.appendChild(userItem);
                });
            });
    </script>
</body>

</html>