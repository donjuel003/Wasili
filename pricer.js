const distances = {
    'central': { 'central': 0, 'northern': 50, 'western': 60, 'eastern': 70, 'southern': 80 },
    'northern': { 'central': 50, 'northern': 0, 'western': 120, 'eastern': 160, 'southern': 150 },
    'western': { 'central': 60, 'northern': 120, 'western': 0, 'eastern': 220, 'southern': 240 },
    'eastern': { 'central': 70, 'northern': 160, 'western': 220, 'eastern': 0, 'southern': 300 },
    'southern': { 'central': 80, 'northern': 150, 'western': 240, 'eastern': 300, 'southern': 0 }
};

// Rates for service type
const serviceTypeRates = {
    'normal': 500,
    'freight': 10000,
    'fragile': 6000,
    'hazardous': 10000
};

// Multiplier for service mode
const serviceModeRates = {
    'normal': 1,
    'express': 1.8 // Express mode is 1.8 times more expensive
};

function calculateDistance() {
    // Get input values
    const origin = document.getElementById('origin').value;
    const destination = document.getElementById('destination').value;
    const serviceMode = document.getElementById('service-mode').value;
    const serviceType = document.getElementById('service-type').value;

    // Mock calculation logic
    const distance = Math.floor(Math.random() * 1000); // Random distance for demo
    const rate = serviceType === 'normal' ? 500 : serviceType === 'freight' ? 10000 : serviceType === 'fragile' ? 6000 : 10000;
    const multiplier = serviceMode === 'express' ? 1.8 : 1;
    const price = distance * rate * multiplier;

    // Display results dynamically in the right section
    const resultsSection = document.getElementById('results');
    resultsSection.innerHTML = `
        <p><span class="material-icons-sharp">place</span> <b>Origin:</b> ${origin}</p>
        <p><span class="material-icons-sharp">flag</span> <b>Destination:</b> ${destination}</p>
        <p><span class="material-icons-sharp">straighten</span> <b>Distance:</b> ${distance} km</p>
        <p><span class="material-icons-sharp">payments</span> <b>Price:</b> ${price.toLocaleString()} Ksh</p>
    `;
}
