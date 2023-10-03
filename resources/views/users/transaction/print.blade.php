<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Halaman Cetak 58mm</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css')}}">
  <style>
    /* CSS untuk halaman cetak 58mm */
    @page {
      size: 58mm 210mm;
      /* Ukuran kertas: lebar x tinggi */
      margin: 0;

    }

    body {
      margin: 0;
      padding: 10mm;
      /* Padding untuk konten Anda */
    }

    /* Gantilah dengan gaya CSS sesuai kebutuhan Anda */
    .content {
      /* border: 1px solid gray; */
      width: 58mm;
      font-family: Arial, sans-serif;
      font-size: .6rem;
    }
  </style>
</head>

<body>
  <div class="content">
    <p style="font-weight: 600; font-size: 13px;" class="text-center pt-3">{{ Auth::user()->shop_name }}</p>
    <p style="margin-top: -15px; font-size: .7em;" class="text-center">{{ Auth::user()->address }}</p>
    <table class="table table-borderless">
      <thead>
        <tr>
          <th>Nama</th>
          <th>Harga</th>
          <th>Jumlah</th>
        </tr>
      </thead>
      <tbody>
        @foreach($transactions as $row)
        <tr>
          <td>{{ $row->good->name }}</td>
          <td>{{ number_format($row->good->selling_price, 0, ".", ".") }}</td>
          <td>{{ $row->quantity }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <ul class="list-group list-group-flush">
      <li class="list-group-item">Total harga : <span class="float-right">Rp. {{ number_format($transaction->final_price / floatval(1 - $transaction->discon), 0, ".", ".") }}</span></li>
      <li class="list-group-item">Total bayar : <span class="float-right">Rp. {{ number_format($transaction->gross_amount, 0, ".", ".") }}</span></li>
      <li class="list-group-item">Diskon : <div class="float-right w-50 d-flex justify-content-end">{{ $transaction->discon * 100 }}%</div>
      </li>
      <li class="list-group-item">Total akhir : <span class="float-right">Rp. {{ number_format($transaction->final_price, 0, ".", ".") }}</span></li>
      <li class="list-group-item">Kembalian : <span class="float-right">Rp. {{ number_format(($transaction->gross_amount - $transaction->final_price), 0, ".", ".") }}</span></li>
      <li class="list-group-item text-center text-secondary" style="font-size: 8px;">{{ $transaction->created_at }}</li>
    </ul>
  </div>
  <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js')}}"></script>
</body>
<script>
  window.print()
</script>

</html>