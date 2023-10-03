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
        <li class="breadcrumb-item active" aria-current="page">Ubah</li>
      </ol>
    </nav>
    <form action="/user/barang/{{ $good->id }}" method="post">
      @csrf
      @method('put')
      <div class="row">
        <div class="col-md-6 col-sm-12">
          <div class="form-group mb-3">
            <label for="name" class="required">Nama Barang</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ $good->name }}">
            @error('name')
            <div id="validationServer04Feedback" class="invalid-feedback">
              {{$message}}
            </div>
            @enderror
          </div>
          <div class="form-group mb-2">
            <label for="category">Kategori</label>
            <select name="category_id" id="category" class="form-control">
              <option value="{{ $good->category_id }}">{{ $good->category->name ?? '~ Pilih kategori' }}</option>
              @foreach($categories as $ct)
              @if($ct->id != $good->category_id)
              <option value="{{ $ct->id }}">{{ $ct->name  }}</option>
              @endif
              @endforeach
            </select>
            <a href="/user/category/create">Tambah Kategori</a>
          </div>
          <div class="form-group">
            <label for="photo">Foto barang</label>
            <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" id="photo">
            @error('photo')
            <div id="validationServer04Feedback" class="invalid-feedback">
              {{$message}}
            </div>
            @enderror
          </div>
          <div id="reader"></div>
        </div>
        <div class="col-md-6 col-sm-12">
          <div class="form-group">
            <label for="selling_price" class="required">Harga jual</label>
            <input type="number" name="selling_price" class="form-control @error('selling_price') is-invalid @enderror" id="selling_price" value="{{ $good->selling_price }}">
            @error('selling_price')
            <div id="validationServer04Feedback" class="invalid-feedback">
              {{$message}}
            </div>
            @enderror
          </div>
          <div class="form-group">
            <label for="capital_price">Harga modal</label>
            <input type="number" name="capital_price" class="form-control" id="capital_price" value="{{ $good->capital_price }}">
          </div>
          <div class="form-group">
            <label for="stock">Stok</label>
            <input type="number" name="stock" class="form-control" id="stock" value="{{ $good->stock }}">
          </div>
          <div class="form-group">
            <label for="qr">Barcode</label>
            <input type="number" name="qr" class="form-control" id="qr" value="{{ $good->qr }}">
          </div>
        </div>
        <div class="col-12">
          <div class="form-floating my-4">
            <label for="floatingTextarea">Deskripsi</label>
            <textarea class="form-control" name="description" id="floatingTextarea">{{ $good->description }}</textarea>
          </div>
        </div>
        <div class="d-flex justify-content-end w-100">
          <a href="/user/barang" class="btn btn-secondary mr-2">Kembali</a>
          <button class="btn btn-primary mr-3">Simpan</button>
        </div>
      </div>
      <div id="result"></div>
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