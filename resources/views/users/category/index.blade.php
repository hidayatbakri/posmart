@extends('users.template.main')
@section('content')

<div class="card shadow-sm">
  <div class="card-body p-3">
    <a href="/user/category/create" class="btn btn-primary mb-5">
      Tambah Kategori
    </a>
    <div class="table-responsive table-invoice">
      <table class="table table-striped" id="dataTable">
        <thead>
          <tr>
            <th>No</th>
            <th>Kategori Barang</th>
            <th>Jumlah Barang</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($categories as $row)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td class="font-weight-600">{{$row->name}}</td>
            <td>{{count($row->goods)}}</td>
            <td>
              <form action="/user/category/{{ $row->id }}" method="post">
                @csrf
                @method('delete')
                <button class="btn btn-danger btn-sm m-1">Hapus</button>
                <a href="/user/category/{{ $row->id }}/edit" class="btn btn-warning btn-sm m-1">Ubah</a>
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