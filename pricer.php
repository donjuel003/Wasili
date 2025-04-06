<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <title>Pricing Calculator</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

        :root {
            --color-primary: #058283;
            --color-danger: #ff0015;
            --color-success: #058283;
            --color-warning: #F7D060;
            --color-white: #202528;
            --color-info-dark: #7d8da1;
            --color-dark: #edeffd;
            --color-light: rgba(0, 0, 0, 0.4);
            --color-dark-variant: #a3bdcc;
            --color-background: #181a1e;

            --card-border-radius: 2rem;
            --border-radius-1: 0.4rem;
            --border-radius-2: 1.2rem;

            --card-padding: 1.8rem;
            --padding-1: 1.2rem;

            --box-shadow: 0 2rem 3rem var(--color-light);
        }

        .dark-mode-variables {
            --color-background: #181a1e;
            --color-white: #202528;
            --color-dark: #edeffd;
            --color-dark-variant: #a3bdcc;
            --color-light: rgba(0, 0, 0, 0.4);
            --box-shadow: 0 2rem 3rem var(--color-light);
        }

        * {
            margin: 0;
            padding: 0;
            outline: 0;
            appearance: 0;
            border: 0;
            text-decoration: none;
            box-sizing: border-box;
        }

        html {
            font-size: 14px;
        }

        body {
            width: 100vw;
            height: fit-content;
            font-family: 'Poppins', sans-serif;
            font-size: 0.88rem;
            user-select: none;
            overflow-x: hidden;
            color: var(--color-dark);
            background-color: var(--color-background);
        }

        a {
            color: var(--color-dark);
        }

        img {
            display: block;
            width: 100%;
            object-fit: cover;
        }

        h1 {
            font-weight: 800;
            font-size: 1.8rem;
        }

        h2 {
            font-weight: 600;
            font-size: 1.4rem;
        }

        h3 {
            font-weight: 500;
            font-size: 0.87rem;
        }

        small {
            font-size: 0.76rem;
        }

        p {
            color: var(--color-dark-variant);
        }

        b {
            color: var(--color-dark);
        }

        .text-muted {
            color: var(--color-info-dark);
        }

        .primary {
            color: var(--color-primary);
        }

        .danger {
            color: var(--color-danger);
        }

        .success {
            color: var(--color-success);
        }

        .warning {
            color: var(--color-warning);
        }

        .container {
            display: flex;
            width: 96%;
            margin: 0 auto;
            gap: 1.8rem;
            height: 100vh;
        }

        aside {
            width: 300px; /* Fixed width for aside */
            height: 100vh;
            position: sticky;
            top: 0;
        }

        aside .toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 1.4rem;
        }

        aside .toggle .logo {
            display: flex;
            gap: 1.5rem;
        }

        aside .toggle .logo img {
            width: 2rem;
            height: 2rem;
        }

        aside .toggle .close {
            padding-right: 1rem;
            display: none;
        }

        aside .sidebar {
            display: flex;
            flex-direction: column;
            background-color: var(--color-white);
            box-shadow: var(--box-shadow);
            border-radius: 15px;
            height: 88vh;
            position: relative;
            top: 1.5rem;
            transition: all 0.3s ease;
        }

        aside .sidebar:hover {
            box-shadow: none;
        }

        aside .sidebar a {
            display: flex;
            align-items: center;
            color: var(--color-info-dark);
            height: 3.7rem;
            gap: 1rem;
            position: relative;
            margin-left: 2rem;
            transition: all 0.3s ease;
        }

        aside .sidebar a span {
            font-size: 1.6rem;
            transition: all 0.3s ease;
        }

        aside .sidebar a:last-child {
            position: absolute;
            bottom: 2rem;
            width: 100%;
        }

        aside .sidebar a.active {
            width: 100%;
            color: var(--color-primary);
            background-color: var(--color-light);
            margin-left: 0;
        }

        aside .sidebar a.active::before {
            content: '';
            width: 6px;
            height: 18px;
            background-color: var(--color-primary);
        }

        aside .sidebar a.active span {
            color: var(--color-primary);
            margin-left: calc(1rem - 3px);
        }

        aside .sidebar a:hover {
            color: var(--color-primary);
        }

        aside .sidebar a:hover span {
            margin-left: 0.6rem;
        }

        aside .sidebar .message-count {
            background-color: var(--color-success);
            padding: 2px 6px;
            color: var(--color-white);
            font-size: 11px;
            border-radius: var(--border-radius-1);
        }

        .main-content {
            flex: 1; /* Take up remaining space */
        }

        form {
            display: grid;
            gap: 1rem;
            width: 100%;
            max-width: 600px;
            background-color: var(--color-white);
            padding: var(--card-padding);
            border-radius: var(--card-border-radius);
            box-shadow: var(--box-shadow);
        }

        form label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            display: block;
        }

        form select, form button {
            width: 100%;
            padding: 0.8rem;
            border-radius: var(--border-radius-1);
            border: none;
            background-color: var(--color-dark);
            font-size: 1rem;
        }

        form button {
            background-color: var(--color-primary);
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form button:hover {
            background-color: var(--color-success);
        }

        .results-container {
            margin-top: 2rem;
            width: 100%;
            max-width: 800px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
            background-color: var(--color-white);
            box-shadow: var(--box-shadow);
            border-radius: var(--card-border-radius);
            overflow: hidden;
        }

        table thead {
            background-color: var(--color-primary);
            color: white;
        }

        table thead th {
            padding: 1rem;
        }

        table tbody tr {
            border-bottom: 1px solid var(--color-light);
        }

        table tbody tr:last-child {
            border-bottom: none;
        }

        table tbody td {
            padding: 0.8rem;
            color: var(--color-dark-variant);
        }

        table tbody tr:hover {
            background-color: var(--color-light);
        }

        .empty-message {
            color: var(--color-info-dark);
            text-align: center;
            padding: 2rem;
        }
    </style>
</head>
<body class="dark-mode-variables">
    <div class="container">
        <!-- Sidebar Section -->
        <aside>
            <div class="toggle">
                <div class="logo">
                    <img src="images/logo.png">
                    <h2>WASILI<span class="danger"></span></h2>
                </div>
                <div class="close" id="close-btn">
                    <span class="material-icons-sharp">
                        close
                    </span>
                </div>
            </div>

            <div class="sidebar">
                <a href="dashboard.php" class="nav-link ">
                    <span class="material-icons-sharp">
                        dashboard
                    </span>
                    <h3>Dashboard</h3>
                </a>

                <a href="Booking-Widget.php" class="nav-link ">
                    <span class="material-icons-sharp">
                        calendar_month
                    </span>
                    <h3>Booking Widget</h3>
                </a>
                
                <a href="view_bookings.php" class="nav-link">
                    <span class="material-icons-sharp">
                        local_shipping
                        </span>
                    <h3>View Bookings</h3>
                </a>

                <a href="pricer.php" class="nav-link active">
                    <span class="material-icons-sharp">
                        credit_card
                        </span>
                    <h3>Pricing Calculator</h3>
                </a>
                
                <a href="approved_shipments.php" class="nav-link">
                    <span class="material-icons-sharp">
                        print
                    </span>
                    <h3>Manage Shipments <br> & Print Invoice</h3>
                </a>
              
                <a href="admin_m.php" class="nav-link">
                    <span class="material-icons-sharp">
                        mail_outline
                    </span>
                    <h3>Messages</h3>
                    <span class="message-count">.</span>
                </a>
                <a href="users.php" class="nav-link">
                    <span class="material-icons-sharp">
                        person_outline
                    </span>
                    <h3>Users</h3>
                </a>

                <a href="reports.php" class="nav-link">
                    <span class="material-icons-sharp">
                        receipt_long
                    </span>
                    <h3>Reports</h3>
                </a>


                <a href="users.php" class="nav-link">
                    <span class="material-icons-sharp">
                        add
                    </span>
                    <h3>New Login</h3>
                </a>
                <a href="logout.php"  class="nav-link">
                    <span class="material-icons-sharp">
                        logout
                    </span>
                    <h3>Logout</h3>
                </a>
            </div>
        </aside>
        <!-- End of Sidebar Section -->

        <div class="main-content">
            <h1>Pricing Calculator</h1><br><br>
            <form id="calculator-form">
                <label for="origin">Origin:</label>
                <select id="origin" name="origin">
                    <option value="central">Central Kenya</option>
                    <option value="northern">Northern Kenya</option>
                    <option value="western">Western Kenya</option>
                    <option value="eastern">Eastern Kenya</option>
                    <option value="southern">Southern Kenya</option>
                </select>

                <label for="destination">Destination:</label>
                <select id="destination" name="destination">
                    <option value="central">Central Kenya</option>
                    <option value="northern">Northern Kenya</option>
                    <option value="western">Western Kenya</option>
                    <option value="eastern">Eastern Kenya</option>
                    <option value="southern">Southern Kenya</option>
                </select>

                <label for="service-mode">Service Mode:</label>
                <select id="service-mode" name="service-mode">
                    <option value="normal">Normal (1x rate)</option>
                    <option value="express">Express (1.8x rate)</option>
                </select>

                <label for="service-type">Service Type:</label>
                <select id="service-type" name="service-type">
                    <option value="normal">Normal Parcel (500 Ksh/km)</option>
                    <option value="freight">Freight (10,000 Ksh/km)</option>
                    <option value="fragile">Fragile (6,000 Ksh/km)</option>
                    <option value="hazardous">Hazardous (10,000 Ksh/km)</option>
                </select>

                <button type="button" onclick="calculateDistance()">Calculate</button>
            </form>

            <div class="results-container">
                <table>
                    <thead>
                        <tr>
                            <th>Origin</th>
                            <th>Destination</th>
                            <th>Distance</th>
                            <th>Service Type</th>
                            <th>Service Mode</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody id="results">
                        <tr>
                            <td colspan="6" class="empty-message">No results yet. Please calculate.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        const distances = {
            central: { northern: 200, western: 300, eastern: 150, southern: 250 },
            northern: { central: 200, western: 400, eastern: 350, southern: 450 },
            western: { central: 300, northern: 400, eastern: 250, southern: 500 },
            eastern: { central: 150, northern: 350, western: 250, southern: 300 },
            southern: { central: 250, northern: 450, western: 500, eastern: 300 }
        };

        const serviceTypeRates = {
            normal: 500,
            freight: 10000,
            fragile: 6000,
            hazardous: 10000
        };

        const serviceModeRates = {
            normal: 1,
            express: 1.8
        };

        function calculateDistance() {
            const origin = document.getElementById('origin').value;
            const destination = document.getElementById('destination').value;
            const serviceMode = document.getElementById('service-mode').value;
            const serviceType = document.getElementById('service-type').value;

            if (origin === destination) {
                document.getElementById('results').innerHTML = `
                    <tr>
                        <td colspan="6" style="color: var(--color-danger); text-align: center;">Origin and destination cannot be the same.</td>
                    </tr>
                `;
                return;
            }

            const distance = distances[origin][destination];
            const baseRate = serviceTypeRates[serviceType];
            const modeMultiplier = serviceModeRates[serviceMode];
            const price = distance * baseRate * modeMultiplier;
            const formattedPrice = `${price.toLocaleString()} Ksh`;

            document.getElementById('results').innerHTML = `
                <tr>
                    <td>${capitalize(origin)}</td>
                    <td>${capitalize(destination)}</td>
                    <td>${distance} km</td>
                    <td>${capitalize(serviceType)}</td>
                    <td>${capitalize(serviceMode)}</td>
                    <td>${formattedPrice}</td>
                </tr>
            `;
        }

        function capitalize(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
    </script>
</body>
</html>