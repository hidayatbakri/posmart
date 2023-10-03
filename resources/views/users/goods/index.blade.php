@extends('users.template.main')
@section('content')

<div class="card shadow-sm">
  <div class="card-body p-3">
    <a href="/user/barang/create" class="btn btn-primary mb-5">
      Tambah Barang
    </a>
    <div class="table-responsive table-invoice">
      <table class="table table-striped" id="dataTable">
        <thead>
          <tr>
            <th>No</th>
            <th>Foto Barang</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Harga Jual</th>
            <th>Harga Modal</th>
            <th>Stok</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($goods as $row)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td><img src="{{ $row->photo ? asset('storage/' . $row->photo) : '/assets/img/example-image.jpg' }}" style="width: 70px; height: 70px;object-fit:cover;"></td>
            <td class="font-weight-600">{{$row->name}}</td>
            <td>
              <div class="badge {{ $row->category_id ? 'badge-success': 'badge-secondary' }}">{{$row->category->name ?? 'Tidak ada'}}</div> <span style="display: none; opacity:0 ;">{{ $row->qr }}</span>
            </td>
            <td>Rp. {{ number_format($row->selling_price, 0, ".", ".") }}</td>
            <td>Rp. {{ number_format($row->capital_price, 0, ".", ".") }}</td>
            <td>{{$row->stock ?? 0}}</td>
            <td>
              <form action="/user/barang/{{ $row->id }}" method="post">
                @csrf
                @method('delete')
                <button class="btn btn-danger btn-sm m-1" onclick="return confirm('Apakah anda yakin?')">Hapus</button>
                <a href="/user/barang/{{ $row->id }}" class="btn btn-success btn-sm m-1">Detail</a>
                <a href="/user/barang/{{ $row->id }}/edit" class="btn btn-warning btn-sm m-1">Ubah</a>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@if (@session('success'))
<script>
  Swal.fire(
    'Good job!',
    `{{ @session('success') }}`,
    'success'
  )
</script>
@endif
@if (@session('error'))
<script>
  Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: `{{ @session('error') }}`,
  })
</script>
@endif
@endsection