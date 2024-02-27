document.addEventListener('DOMContentLoaded', function () {
    fetch('fetch_histogram_data.php')
        .then(response => response.json())
        .then(data => {
            const courseLabels = data.map(item => item.course_id);
            const attendedData = data.map(item => item.attended);
            const absentData = data.map(item => item.absent);

            const ctx = document.getElementById('attendanceHistogram').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: courseLabels,
                    datasets: [{
                        label: 'Classes Attended',
                        data: attendedData,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }, {
                        label: 'Classes Absent',
                        data: absentData,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
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
        })
        .catch(error => console.error('Error fetching histogram data:', error));
});
