<div id="chart" class="chart-container"></div>

<style>
    /* Styling untuk container chart */
    .chart-container {
        width: 100%;
        max-width: 95%; /* Batas lebar maksimal */
        height: 400px;
        margin: 20px auto; /* Mengatur agar chart berada di tengah */
        padding: 5px; /* Memberikan ruang dalam */
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var options = {
            chart: {
                type: 'line',
                height: 350,
                toolbar: { show: false } // Menghilangkan toolbar
            },
            series: [{
                name: 'Sales',
                data: [2, 4, 1, 5, 3, 8, 7] // Data antara 1 hingga 10
            }],
            xaxis: {
                categories: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'], // Nama hari
                title: { text: 'Hari' } // Judul untuk x-axis
            },
            yaxis: {
                title: { text: 'Sales' }, // Judul untuk y-axis
                min: 1, // Batas bawah y-axis
                max: 10, // Batas atas y-axis
                tickAmount: 10 // Jumlah tick pada y-axis
            },
            grid: {
                borderColor: '#e0e0e0', // Warna garis grid
                strokeDashArray: 5 // Gaya garis putus-putus
            },
            dataLabels: {
                enabled: false // Menonaktifkan label data di atas titik
            },
            markers: {
                size: 5,
                colors: ["#FFA41B"], // Warna titik
                strokeColors: "#fff",
                strokeWidth: 2,
                hover: {
                    size: 7
                }
            },
            tooltip: {
                theme: 'light'
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    });
</script>
