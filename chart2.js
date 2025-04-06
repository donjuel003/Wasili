const ctx2 = document.getElementById('doughnut');

new Chart(ctx2, {
  type: 'doughnut',
  data: {
    labels: ['Deliveries', 'Orders', 'In Transit', 'Deleted'],
    datasets: [{
      label: '# of Votes',
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
