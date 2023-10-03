@extends('users.template.main')
@section('content')
<style>
  label.required::after {
    content: ' *';
    color: red;
  }
</style>

<div class="card shadow-sm">
  <div class="card-body p-3">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/user/barang">Barang</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detail</li>
      </ol>
    </nav>
    <div class="row py-3">
      <div class="col-sm-12 col-md-3">
        <img src="{{ $good->photo ? asset('storage/' . $good->photo) : '/assets/img/example-image.jpg' }}" style="height: 300px; width: 100%; object-fit:cover;">
      </div>
      <div class="col-sm-12 col-md-9">
        <div class="table-responsive table-invoice">
          <table class="table">
            <tr>
              <th style="width: 20%;">Nama barang</th>
              <td style="width: 30px;">:</td>
              <td>{{ $good->name }}</td>
            </tr>
            <tr>
              <th>Kategori barang</th>
              <td>:</td>
              <td>{{ $good->category->name ?? 'Tidak ada  ' }}</td>
            </tr>
            <tr>
              <th>Harga jual</th>
              <td>:</td>
              <td>Rp. {{ number_format($good->selling_price, 0, ".", ".") }}</td>
            </tr>
            <tr>
              <th>Harga modal</th>
              <td>:</td>
              <td>Rp. {{ number_format($good->capital_price, 0, ".", ".") }}</td>
            </tr>
            <tr>
              <th>Stok</th>
              <td>:</td>
              <td>{{ $good->stock ?? 0 }}</td>
            </tr>
            <tr>
              <th>Deskripsi</th>
              <td>:</td>
              <td>{{ $good->description }}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <div class="d-flex justify-content-end">
      <a href="/user/barang" class="btn btn-secondary m-2">Kembali</a>
    </div>
  </div>
</div>


<script>
  function onScanSuccess(decodedText, decodedResult) {
    // handle the scanned code as you like, for example:
    $('#barcode').val(decodedText)
    console.log(`Code matched = ${decodedText}`, decodedResult);
  }

  let config = {
    fps: 10,
    qrbox: {
      width: 250,
      height: 250
    },
    rememberLastUsedCamera: true,
    // Only support camera scan type.
    supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA]
  };

  let html5QrcodeScanner = new Html5QrcodeScanner(
    "reader", config, /* verbose= */ false);
  html5QrcodeScanner.render(onScanSuccess);
</script>
@endsection