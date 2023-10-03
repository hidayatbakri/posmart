@extends('users.template.main')
@section('content')
<div class="row">
  <div class="col-lg-6 col-md-6 col-sm-12">
    <div class="card card-statistic-2">
      <div class="card-stats pt-3">
        <div class="card-stats-title">
        </div>
        <div class="card-stats-items">
          <div class="card-stats-item">
            <div class="card-stats-item-count">{{ count($goods) }}</div>
            <div class="card-stats-item-label">Barang</div>
          </div>
          <div class="card-stats-item">
            <div class="card-stats-item-count">{{ count($carts) }}</div>
            <div class="card-stats-item-label">Keranjang</div>
          </div>
          <div class="card-stats-item">
            <div class="card-stats-item-count">{{ count($categories) }}</div>
            <div class="card-stats-item-label">Kategori</div>
          </div>
        </div>
      </div>
      <div class="card-icon shadow-primary bg-primary">
        <i class="fas fa-archive"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>Total Transaksi</h4>
        </div>
        <div class="card-body">
          {{ count($transactions) }}
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-12">
    <div class="card card-statistic-2">
      <div class="card-chart">
        <canvas id="balance-chart" height="80"></canvas>
      </div>
      <div class="card-icon shadow-primary bg-primary">
        <i class="fas fa-coins"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>Pendapatan</h4>
        </div>
        <div class="card-body">
          Rp. {{ number_format($totalSellingPrice, 0, ".", ".") }}
        </div>
      </div>
    </div>
  </div>

</div>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4>5 Transaksi terbaru</h4>
        <div class="card-header-action">
          <a href="/user/rekap" class="btn btn-danger">Lihat lebih <i class="fas fa-chevron-right"></i></a>
        </div>
      </div>
      <div class="card-body p-3">
        <div class="table-responsive table-invoice">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Kode Transaksi</th>
                <th>Status</th>
                <th>Dibayar</th>
                <th>Diskon</th>
                <th>Total harga</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($transactions as $tr)
              <tr>
                <td>{{ $tr->transaction_code }}</td>
                <td>
                  <div class="badge {{ $tr->gross_amount > $tr->final_price ? 'badge-success' : 'badge-warning' }}">{{ $tr->gross_amount > $tr->final_price ? 'Lunas' : 'Tidak Lunas' }}</div>
                </td>
                <td>{{ number_format($tr->gross_amount, 0, ".", ".") }}</td>
                <td>{{ $tr->discon * 100 }}%</td>
                <td>{{ number_format($tr->final_price, 0, ".", ".") }}</td>
                <td>
                  <a href="#" class="btn btn-primary">Detail</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>



<!-- Page Specific JS File -->
<script src="{{ asset('assets/modules/owlcarousel2/dist/owl.carousel.min.js')}}"></script>
<script src="{{ asset('assets/modules/chart.min.js')}}"></script>
<script src="{{ asset('assets/js/page/index1.js')}}"></script>
<script>
  var balance_chart = document.getElementById("balance-chart").getContext("2d");
  var myChart = new Chart(balance_chart, {
    type: "line",
    data: {
      labels: [
        @foreach($transactionsCart as $key)
        '{{$key->month_year}}',
        @endforeach
      ],
      datasets: [{
        label: "Pendapatan",
        data: [
          @foreach($transactionsCart as $key1)
          parseInt('{{$key1->total_price}}'),
          @endforeach
        ],
        backgroundColor: balance_chart_bg_color,
        borderWidth: 3,
        borderColor: "rgba(63,82,227,1)",
        pointBorderWidth: 0,
        pointBorderColor: "transparent",
        pointRadius: 3,
        pointBackgroundColor: "transparent",
        pointHoverBackgroundColor: "rgba(63,82,227,1)",
      }, ],
    },
    options: {
      layout: {
        padding: {
          bottom: -1,
          left: -1,
        },
      },
      legend: {
        display: false,
      },
      scales: {
        yAxes: [{
          gridLines: {
            display: false,
            drawBorder: false,
          },
          ticks: {
            beginAtZero: true,
            display: false,
          },
        }, ],
        xAxes: [{
          gridLines: {
            drawBorder: false,
            display: false,
          },
          ticks: {
            display: false,
          },
        }, ],
      },
    },
  });
</script>

@endsection