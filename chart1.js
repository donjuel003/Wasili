const ctx = document.getElementById('barChart');

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Deliveries', 'Orders', 'In Transit', 'Deleted'],
      datasets: [{
        label: 'Pageview by Performance',
        data: [12, 19, 3, 5],
        backgroundColor: [
          '#044444',
          '#044444',
          '#044444',
          '#044444'
        ],
        borderColor: '#058283',
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });