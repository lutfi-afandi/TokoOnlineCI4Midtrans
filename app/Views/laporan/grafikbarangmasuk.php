<link rel="stylesheet" href="<?= base_url(); ?>/plugins/chart.js/Chart.min.css">
<script src="<?= base_url(); ?>/plugins/chart.js/Chart.bundle.min.js"></script>

<canvas id="myChart" style="height: 50vh; width: 80vh;"></canvas>

<?php
$tanggal = "";
$total = "";

foreach ($grafik as $row) {
    $tgl = $row->tgl;
    $tanggal .= "'$tgl'" . ",";

    $totalHarga = $row->totalharga;
    $total .= "'$totalHarga'" . ",";
}

?>

<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var chartOptions = {
        scales: {
            yAxes: [{
                display: true,
                ticks: {
                    suggestedMin: 0, // minimum will be 0, unless there is a lower value.
                    // OR //
                    // beginAtZero: true // minimum value will be 0.
                }
            }]
        }
    };
    var chart = new Chart(ctx, {
        type: 'bar',
        responsive: true,
        data: {
            labels: [<?= $tanggal ?>],
            datasets: [{
                label: 'Total Harga',
                backgroundColor: ['rgb(255,99,132)', 'rgb(99,99,99)', 'rgb(155,88,100)'],
                borderColor: ['rgb(66,198,171)'],
                data: [<?= $total ?>]
            }]
        },
        duration: 1000,
        options: chartOptions

    })
</script>