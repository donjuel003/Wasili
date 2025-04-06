<!-- Right Section -->
<div class="right-section">
    <div class="nav">
        <button id="menu-btn">
            <span class="material-icons-sharp">
                menu
            </span>
        </button>
        <div class="dark-mode">
            <span class="material-icons-sharp ">
                light_mode
            </span>
            <span class="material-icons-sharp active">
                dark_mode
            </span>
        </div>

        <div class="profile">
            <div class="info">
                <p>Hello, <b>Welcome</b></p>
                <small class="text-muted">Admin</small>
            </div>
            <div class="profile-photo">
                <img src="images/profile-1.jpg">
            </div>
        </div>
    </div>

    <!-- Status Section -->
    <div class="status-section">
        <div class="status-buttons">
            <button id="ordered-btn" class="status-btn active">Ordered</button>
            <button id="transit-btn" class="status-btn">In Transit</button>
            <button id="delivered-btn" class="status-btn">Delivered</button>
        </div>
        <div class="status-line">
            <div class="status-indicator"></div>
        </div>
        <div id="status-message" class="status-message">
            Status: Your shipment has been ordered.
        </div>
    </div>
</div>

<style>
    .status-section {
        text-align: center;
        padding: 20px;
        background-color: #202528;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        margin-top: 20px;
    }

    .status-buttons {
        display: flex;
        justify-content: space-between;
        position: relative;
        margin-bottom: 20px;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .status-btn {
        background-color: #202528;
        color: #ccc;
        border: none;
        padding: 10px 20px;
        border-radius: 50px;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .status-btn:hover {
        background-color: #058283;
        color: #fff;
    }

    .status-btn.active {
        background-color: #058283;
        color: #fff;
    }

    .status-line {
        position: relative;
        height: 4px;
        background-color: #ccc;
        width: 100%;
        max-width: 600px;
        margin: auto;
        border-radius: 2px;
        margin-bottom: 20px;
        overflow: hidden;
    }

    .status-indicator {
        position: absolute;
        top: -4px;
        height: 12px;
        width: 12px;
        background-color: #058283;
        border-radius: 50%;
        transition: left 0.3s ease;
    }

    .status-message {
        font-size: 16px;
        color: #ccc;
    }
</style>

<script>
    const orderedBtn = document.getElementById("ordered-btn");
    const transitBtn = document.getElementById("transit-btn");
    const deliveredBtn = document.getElementById("delivered-btn");
    const statusMessage = document.getElementById("status-message");
    const statusIndicator = document.querySelector(".status-indicator");
    const statusButtons = document.querySelectorAll(".status-btn");

    const updateStatus = (btn, message, position) => {
        // Reset all buttons
        statusButtons.forEach(button => button.classList.remove("active"));
        // Activate the clicked button
        btn.classList.add("active");
        // Update the status message
        statusMessage.textContent = `Status: ${message}`;
        // Move the status indicator
        statusIndicator.style.left = position + "%";
    };

    orderedBtn.addEventListener("click", () => {
        updateStatus(orderedBtn, "Your shipment has been ordered.", 0);
    });

    transitBtn.addEventListener("click", () => {
        updateStatus(transitBtn, "Your shipment is in transit.", 50);
    });

    deliveredBtn.addEventListener("click", () => {
        updateStatus(deliveredBtn, "Your shipment has been delivered.", 100);
    });
</script>
