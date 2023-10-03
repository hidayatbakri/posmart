@extends('users.template.main')
@section('content')

<div class="row">
  <div class="col-8">
    <div class="card">
      <div class="card-header">
        <h4>Rekap transaksi</h4>
        <div class="card-header-action">
          <a href="/user/rekap" class="btn btn-danger"><i class="fas fa-chevron-left"></i> Kembali</a>
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
          <button type="button" id="btnModal" class="btn btn-secondary btn-block w-100 mt-3" data-toggle="modal" data-target="#exampleModal">
            Ubah pembayaran
          </button>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/user/transaksi/{{ $transaction->id }}" method="post">
        <div class="modal-body">
          @csrf
          @method('put')
          <input type="text" class="form-control" value="{{ $transaction->final_price }}" name="gross_amount" placeholder="Nominal uang">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  $('#btnModal').on('click', () => {
    setInterval(() => $('.modal-backdrop').removeClass('modal-backdrop'), 500)

  })
</script>
@endsection