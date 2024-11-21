const ctx = document.getElementById('taskStatsChart').getContext('2d');
const taskStatsChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['Number of Days Present', 'Number of Days Absent', 'Not Available'],
        datasets: [{
            label: '# of Tasks',
            data: [500, 5, 10], // Replace with dynamic PHP values as needed
            backgroundColor: ['#6495ED', '#7da7f4','#3370e2'],
            borderColor: ['#fff', '#fff', '#fff'],
            borderWidth: 1
        }]
    },
    
});
