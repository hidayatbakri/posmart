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
        <li class="breadcrumb-item"><a href="/user/category">Barang</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tambah</li>
      </ol>
    </nav>
    <form action="/user/category" method="post" enctype="multipart/form-data">
      @csrf

      <div class="form-group mb-3">
        <label for="name" class="required">Nama Kategori</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ @old('name') }}">
        @error('name')
        <div id="validationServer04Feedback" class="invalid-feedback">
          {{$message}}
        </div>
        @enderror
      </div>

      <div class="d-flex justify-content-end w-100">
        <a href="/user/category" class="btn btn-secondary mr-2">Kembali</a>
        <button class="btn btn-primary mr-3">Simpan</button>
      </div>
    </form>
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