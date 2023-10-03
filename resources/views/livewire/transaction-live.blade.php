<div>
  <div class="card shadow-sm">
    <div class="card-body p-3">
      <a href="/user/transaksi/kasir" class="btn btn-primary mb-5">
        <i class="fas fa-eye"></i> Tampilan kasir
      </a>
      <a href="/user/keranjang" class="btn btn-info ms-3 mb-5"><i class="fas fa-shopping-cart"></i> Keranjang</a>
      <div class="table-responsive table-invoice">
        <input type="text" class="form-control mb-3" id="search" autofocus placeholder="Cari data">
        <table class="table table-striped">
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
              <td><img src="{{ $row->photo ? asset('storage/' . $row->photo) : '/assets/img/example-image.jpg' }}" class="my-2" style="width: 70px; height: 70px;object-fit:cover;"></td>
              <td class="font-weight-600">{{$row->name}}</td>
              <td>
                <div class="badge {{ $row->category_id ? 'badge-success': 'badge-secondary' }}">{{$row->category->name ?? 'Tidak ada'}}</div> <span style="display: none; opacity:0 ;">{{ $row->qr }}</span>
              </td>
              <td>Rp. {{ number_format($row->selling_price, 0, ".", ".") }}</td>
              <td>Rp. {{ number_format($row->capital_price, 0, ".", ".") }}</td>
              <td>{{$row->stock ?? 0}}</td>
              <td>
                @if($goodsInCart->contains('good_id', $row->id))
                <form action="/user/keranjang/{{ $row->id }}" method="post">
                  @csrf
                  @method('delete')
                  <button class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                </form>
                <!-- <button onclick="deleteData(`{{$row->id}}`)" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button> -->
                @else
                <input type="checkbox" class="" value="{{ $row }}">
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>


</div>
@push('js')
<script src="{{ asset('js/jQuery.min.js') }}"></script>
<script>
  $('#search').on('keyup', function() {
    Livewire.dispatch('searchData', [$('#search').val()])
  });
  // Fungsi untuk menampilkan data saat checkbox diubah
  function displayData() {
    let data = []; // Menggunakan array untuk menyimpan objek
    $(':checkbox:checked').each(function() {
      let obj = JSON.parse($(this).val());
      data.push(obj);
    });

    data.forEach(function(item) {
      Livewire.dispatch('cartData', [item.id])
    });
  }

  function deleteData(id) {
    Livewire.dispatch('deleteData', [id]);
  }

  $(':checkbox').on('change', displayData);

  setInterval(() => Livewire.dispatch('getData'), 500)
</script>
@endpush