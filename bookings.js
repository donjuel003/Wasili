const sideMenu = document.querySelector('aside');
const menuBtn = document.getElementById('menu-btn');
const closeBtn = document.getElementById('close-btn');

const darkMode = document.querySelector('.dark-mode');

menuBtn.addEventListener('click', () => {
    sideMenu.style.display = 'block';
});

closeBtn.addEventListener('click', () => {
    sideMenu.style.display = 'none';
});

darkMode.addEventListener('click', () => {
    document.body.classList.toggle('dark-mode-variables');
    darkMode.querySelector('span:nth-child(1)').classList.toggle('active');
    darkMode.querySelector('span:nth-child(2)').classList.toggle('active');
})


Bookings.forEach(booking => {
    const tr = document.createElement('tr');
    const trContent = `
        <td>${booking.productDate}</td>
        <td>${booking.productDestination}</td>
        <td>${booking.productSource}</td>
        <td>${booking.productInformation}</td>
        <td>${booking.productNumber}</td>
        <td class="${booking.status === 'Declined' ? 'danger' : booking.status === 'Pending' ? 'warning' : 'primary'}">${booking.status}</td>
        <td class="primary">Details</td>
    `;
    tr.innerHTML = trContent;
    document.querySelector('table tbody').appendChild(tr);
});



// Select all navigation links
const navLinks = document.querySelectorAll('.nav-link');

// Add click event listener to each link
navLinks.forEach(link => {
    link.addEventListener('click', function () {
        // Remove the 'active' class from all links
        navLinks.forEach(link => link.classList.remove('active'));

        // Add the 'active' class to the clicked link
        this.classList.add('active');
    });
});



// Enable dark mode by default
document.body.classList.add('dark-mode-variables');