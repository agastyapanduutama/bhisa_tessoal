<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h5 class="mb-1">Sales Overview</h5>
                </div>
                <div class="d-flex align-items-center card-subtitle">
                    <div class="me-2">Ringkasan Data Penjualan dan Transaksi</div>
                </div>
            </div>
            <div class="card-body d-flex justify-content-between flex-wrap gap-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar">
                        <div class="avatar-initial bg-label-primary rounded p-2">
                            <i class="fas fa-boxes fa-lg"></i>
                        </div>
                    </div>
                    <div class="card-info">
                        <h5 class="mb-0"><?= number_format($total_barang, 0, ',', '.') ?></h5>
                        <p class="mb-0 text-muted">Total Barang Aktif</p>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar">
                        <div class="avatar-initial bg-label-warning rounded p-2">
                            <i class="fas fa-money-bill-wave fa-lg"></i>
                        </div>
                    </div>
                    <div class="card-info">
                        <h5 class="mb-0"><?= $this->req->rupiah($total_nominal) ?></h5>
                        <p class="mb-0 text-muted">Nominal Penjualan</p>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar">
                        <div class="avatar-initial bg-label-info rounded p-2">
                            <i class="fas fa-shopping-cart fa-lg"></i>
                        </div>
                    </div>
                    <div class="card-info">
                        <h5 class="mb-0"><?= number_format($total_transaksi, 0, ',', '.') ?></h5>
                        <p class="mb-0 text-muted">Total Transaksi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Chart Jumlah Transaksi -->
    <div class="col-lg-6 col-12 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">Statistik Transaksi <?= date('Y') ?></h5>
            </div>
            <div class="card-body">
                <div id="transaksiChart"></div>
            </div>
        </div>
    </div>
    
    <!-- Chart Nominal Penjualan -->
    <div class="col-lg-6 col-12 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">Statistik Pendapatan <?= date('Y') ?></h5>
            </div>
            <div class="card-body">
                <div id="nominalChart"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var optionsTransaksi = {
            series: [{
                name: 'Jumlah Transaksi',
                data: <?= $chart_data ?>
            }],
            chart: {
                type: 'bar',
                height: 350,
                toolbar: { show: false }
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: false,
                    columnWidth: '40%',
                }
            },
            dataLabels: { enabled: false },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            },
            yaxis: {
                title: { text: 'Jumlah Transaksi' },
                labels: {
                    formatter: function (val) {
                        return Math.floor(val);
                    }
                }
            },
            fill: {
                opacity: 1,
                colors: ['#28c76f'] // Success green
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + " Transaksi"
                    }
                }
            }
        };

        var chartTransaksi = new ApexCharts(document.querySelector("#transaksiChart"), optionsTransaksi);
        chartTransaksi.render();

        var optionsNominal = {
            series: [{
                name: 'Pendapatan (Rp)',
                data: <?= $chart_nominal ?>
            }],
            chart: {
                type: 'bar',
                height: 350,
                toolbar: { show: false }
            },
            dataLabels: { enabled: false },
            stroke: {
                curve: 'smooth',
                width: 3,
                colors: ['#ff9f43']
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            },
            yaxis: {
                title: { text: 'Pendapatan (Rp)' },
                labels: {
                    formatter: function (val) {
                        return "Rp " + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.1,
                    stops: [0, 90, 100],
                    colorStops: [
                        [
                            { offset: 0, color: '#ff9f43', opacity: 0.5 },
                            { offset: 100, color: '#ff9f43', opacity: 0.1 }
                        ]
                    ]
                }
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return "Rp " + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    }
                }
            }
        };

        var chartNominal = new ApexCharts(document.querySelector("#nominalChart"), optionsNominal);
        chartNominal.render();
    });
</script>