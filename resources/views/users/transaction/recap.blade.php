@extends('users.template.main')
@section('content')

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4>Transaksi</h4>
        <div class="card-header-action">
        </div>
      </div>
      <div class="card-body p-3">
        <div class="table-responsive table-invoice">
          <table class="table table-striped" id="dataTable">
            <thead>
              <tr>
                <th>Kode Transaksi</th>
                <th>Status</th>
                <th>Dibayar</th>
                <th>Diskon</th>
                <th>Total harga</th>
                <th>Tanggal</th>
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
                <td>Rp. {{ number_format($tr->gross_amount, 0, ".", ".") }}</td>
                <td>{{ $tr->discon * 100 }}%</td>
                <td>{{ number_format($tr->final_price, 0, ".", ".") }}</td>
                <td>{{ $tr->created_at }}</td>
                <td>
                  <a href="/user/rekap/{{ $tr->transaction_code }}" class="btn btn-primary">Detail</a>
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

@endsection