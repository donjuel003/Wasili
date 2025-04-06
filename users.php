<?php
require "config.php"; // Database connection

// Handle user deletion
if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
    echo "User deleted successfully.";
    exit();
}

// Handle user update
if (isset($_POST['update_id'])) {
    $id = $_POST['update_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?");
    $stmt->bind_param("sssi", $name, $email, $role, $id);
    $stmt->execute();
    $stmt->close();
    echo "User updated successfully.";
    exit();
}

// Handle new user creation
if (isset($_POST['add_user'])) {
    $name = $_POST['new_name'];
    $email = $_POST['new_email'];
    $password = $_POST['new_password'];
    $role = $_POST['new_role'];
    
    // Simple validation
    if (!empty($name) && !empty($email) && !empty($password)) {
        // Hash the password
        
        
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $password, $role);
        if ($stmt->execute()) {
            echo "User added successfully.";
        } else {
            echo "Error adding user.";
        }
        $stmt->close();
        exit();
    } else {
        echo "All fields are required.";
        exit();
    }
}

// Fetch users
$role_filter = isset($_GET['role']) ? $_GET['role'] : '';
$query = "SELECT * FROM users";
if (!empty($role_filter)) {
    $query .= " WHERE role = ?";
}
$stmt = $conn->prepare($query);
if (!empty($role_filter)) {
    $stmt->bind_param("s", $role_filter);
}
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Manage Users</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        main {
            padding: 20px;
        }
        body {
            display: flex;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        aside {
            width: 250px;
            height: 100vh;
            color: white;
            padding: 20px;
            position: fixed;
            left: 0;
            top: 0;
        }

        main {
            margin-left: 270px;
            padding: 20px;
            width: calc(100% - 270px);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #333;
            color: white;
        }
        tr:hover {
            background-color: #202528;
        }
        .edit-field {
            border: 1px solid #ccc;
            background: white;
            width: 100%;
            padding: 8px;
            font-size: 14px;
            border-radius: 4px;
        }
        .edit-field:focus {
            outline: 2px solid #007bff;
            border-color: #007bff;
        }
        .edit-role {
            width: 100%;
            padding: 8px;
            font-size: 14px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        .actions {
            display: flex;
            gap: 8px;
            justify-content: center;
            align-items: center;
        }
        .btn {
            cursor: pointer;
            padding: 8px 14px;
            border: none;
            color: white;
            border-radius: 5px;
            font-size: 14px;
            transition: background 0.3s ease;
            text-align: center;
        }
        .save-btn {
            background-color: #28a745;
        }
        .delete-btn {
            background-color: #dc3545;
        }
        .add-btn {
            background-color: #17a2b8;
            margin-bottom: 15px;
        }
        .save-btn:hover {
            background-color: #218838;
        }
        .delete-btn:hover {
            background-color: #c82333;
        }
        .add-btn:hover {
            background-color: #138496;
        }
        #addUserModal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: #202528;
            padding: 20px;
            border-radius: 5px;
            width: 400px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            
        }
        .form-group input:focus, .form-group select:focus {
            border-color: #007bff;
            outline: none;
        }
        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }
        .nav-link {
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 5px;
            transition: background-color 0.3s;
        }
        .nav-link:hover {
            background-color: #34495e;
        }
        .nav-link.active {
            background-color: #3498db;
        }
        .material-icons-sharp {
            margin-right: 10px;
        }
    </style>
</head>
<body>
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
            <h3>Manage Shipments &  Print Invoice</h3>
        </a>

        <a href="admin_m.php" class="nav-link">
            <span class="material-icons-sharp">mail_outline</span>
            <h3>Messages</h3>
            <span class="message-count">.</span>
        </a>
        <a href="users.php" class="nav-link active">
            <span class="material-icons-sharp">person_outline</span>
            <h3>Users</h3>
        </a>
        <a href="reports.php" class="nav-link">
            <span class="material-icons-sharp">receipt_long</span>
            <h3>Reports</h3>
        </a>

        <a href="users.php" class="nav-link">
            <span class="material-icons-sharp">add</span>
            <h3>New Login</h3>
        </a>
        <a href="logout.php" class="nav-link">
            <span class="material-icons-sharp">logout</span>
            <h3>Logout</h3>
        </a>
    </div>
</aside>

<main>
    <h1>Manage Users</h1>
    <button class="btn add-btn" onclick="showAddUserModal()">
        <span class="material-icons-sharp">add</span> Add New User
    </button>
    
    <label for="role">Filter by Role:</label>
    <select id="role" onchange="filterUsers()">
        <option value="">All</option>
        <option value="admin" <?= $role_filter == 'admin' ? 'selected' : '' ?>>Admin</option>
        <option value="user" <?= $role_filter == 'user' ? 'selected' : '' ?>>User</option>
    </select>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
        <?php while ($user = $result->fetch_assoc()): ?>
            <tr data-id="<?= $user['id'] ?>">
                <td><input type="text" class="edit-field edit-id" value="<?= $user['id'] ?>" disabled></td>
                <td><input type="text" class="edit-field edit-name" value="<?= $user['name'] ?>" placeholder="Enter name"></td>
                <td><input type="email" class="edit-field edit-email" value="<?= $user['email'] ?>" placeholder="Enter email"></td>
                <td>
                    <select class="edit-role">
                        <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>User</option>
                    </select>
                </td>
                <td class="actions">
                    <button class="btn save-btn">Save</button>
                    <button class="btn delete-btn">Delete</button>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</main>

<!-- Add User Modal -->
<div id="addUserModal">
    <div class="modal-content">
        <h2>Add New User</h2>
        <form id="addUserForm">
            <div class="form-group">
                <label for="new_name">Full Name:</label>
                <input type="text" id="new_name" name="new_name" required placeholder="Enter Name">
            </div>
            <div class="form-group">
                <label for="new_email">Email Address:</label>
                <input type="email" id="new_email" name="new_email" required placeholder="Enter Email">
            </div>
            <div class="form-group">
                <label for="new_password">Password:</label>
                <input type="password" id="new_password" name="new_password" required placeholder="••••••••">
            </div>
            <div class="form-group">
                <label for="new_role">User Role:</label>
                <select id="new_role" name="new_role">
                    <option value="user"> User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn delete-btn" onclick="hideAddUserModal()">Cancel</button>
                <button type="submit" class="btn save-btn">Add User</button>
            </div>
        </form>
    </div>
</div>

<script>
    function filterUsers() {
        let role = document.getElementById('role').value;
        window.location.href = `users.php?role=${role}`;
    }

    function showAddUserModal() {
        document.getElementById('addUserModal').style.display = 'flex';
        document.getElementById('new_name').focus();
    }

    function hideAddUserModal() {
        document.getElementById('addUserModal').style.display = 'none';
        document.getElementById('addUserForm').reset();
    }

    $(document).ready(function() {
        // Save User
        $(".save-btn").not('#addUserForm .save-btn').click(function() {
            let row = $(this).closest("tr");
            let id = row.data("id");
            let name = row.find(".edit-name").val().trim();
            let email = row.find(".edit-email").val().trim();
            let role = row.find(".edit-role").val();

            $.post("users.php", {
                update_id: id,
                name: name,
                email: email,
                role: role
            }, function(response) {
                alert(response);
            });
        });

        // Delete User
        $(".delete-btn").not('.modal-actions .delete-btn').click(function() {
            if (confirm("Are you sure you want to delete this user?")) {
                let row = $(this).closest("tr");
                let id = row.data("id");

                $.post("users.php", { delete_id: id }, function(response) {
                    alert(response);
                    row.remove();
                });
            }
        });

        // Add New User
        $("#addUserForm").submit(function(e) {
            e.preventDefault();
            
            let formData = $(this).serialize() + "&add_user=1";
            
            $.post("users.php", formData, function(response) {
                alert(response);
                if (response === "User added successfully.") {
                    hideAddUserModal();
                    location.reload();
                }
            });
        });
    });
</script>
</body>
</html>