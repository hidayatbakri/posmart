@extends('users.template.main')
@section('content')

<div class="row">
  <div class="col-8">
    <div class="card">
      <div class="card-header">
        <h4>Detail transaksi</h4>
        <div class="card-header-action">
          <a href="/user/transaksi/kasir" class="btn btn-danger"><i class="fas fa-chevron-left"></i> Kasir</a>
        </div>
      </div>
      <div class="card-body p-3">
        <div class="table-responsive table-invoice">
          <table class="table table-striped" id="dataTable">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama barang</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($transactions as $row)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $row->good->name }}</td>
                <td>{{ number_format($row->good->selling_price, 0, ".", ".") }}</td>
                <td>{{ $row->quantity }}</td>
                <td>
                  <a href="/user/barang/{{ $row->good->id }}" class="btn btn-primary">Detail</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="col-4">
    <div class="card">
      <div class="card-header">
        <h4>Detail pembayaran</h4>
        <div class="card-header-action">
        </div>
      </div>
      <div class="card-body p-3">
        <div class="table-responsive table-invoice">
          <ul class="list-group list-group-flush">
            <li class="list-group-item">Total harga : <span class="float-right">Rp. {{ number_format($transaction->final_price / floatval(1 - $transaction->discon), 0, ".", ".") }}</span></li>
            <li class="list-group-item">Total bayar : <span class="float-right">Rp. {{ number_format($transaction->gross_amount, 0, ".", ".") }}</span></li>
            <li class="list-group-item">Diskon : <div class="float-right w-50 d-flex justify-content-end">{{ $transaction->discon * 100 }}%</div>
            </li>
            <li class="list-group-item">Total akhir : <span class="float-right">Rp. {{ number_format($transaction->final_price, 0, ".", ".") }}</span></li>
            <li class="list-group-item">Kembalian : <span class="float-right">Rp. {{ number_format(($transaction->gross_amount - $transaction->final_price), 0, ".", ".") }}</span></li>
          </ul>
          <a href="/user/rekap/print/{{ $transaction->transaction_code }}" class="btn btn-primary btn-block mt-4"><i class="fas fa-print"></i> Cetak</a>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection