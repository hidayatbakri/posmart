<div>
  <div class="row">
    <div class="col-md-8">
      <div class="card shadow-sm">
        <div class="card-body p-3">
          <a href="/user/transaksi" class="btn btn-primary mb-5">
            <i class="fas fa-chevron-left"></i> Kembali
          </a>
          <div class="table-responsive table-invoice">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Nama Barang</th>
                  <th scope="col">Harga</th>
                  <th scope="col" class="text-center">Jumlah Barang</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($carts as $row)
                <tr>
                  <th scope="row">{{ $loop->iteration }}</th>
                  <td>{{ $row->good->name }}</td>
                  <td>Rp. {{ number_format($row->good->selling_price, 0, ".", ".") }}</td>
                  <td>
                    <div class="d-flex justify-content-center">
                      <button type="button" class="btn btn-secondary" onclick="decrementQuantity(`{{ $row->id }}`)"><i class="fas fa-minus"></i></button>
                      <input type="number" name="" value="1" id="quantity_{{ $row->id }}" class="w-25 quantity form-control text-center">
                      <button type="button" class="btn btn-success" onclick="incrementQuantity(`{{ $row->id }}`)"><i class="fas fa-plus"></i></button>
                    </div>
                  </td>
                  <td>
                    <form action="/user/keranjang/{{ $row->id }}" method="post">
                      @csrf
                      @method('delete')
                      <button class="btn btn-danger" onclick="return confirm('Apakah anda yakin?')"><i class="fas fa-trash-alt"></i></button>
                    </form>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-body p-3">
          <div class="table-responsive table-invoice">
            <ul class="list-group list-group-flush">
              <li class="list-group-item">Total harga : <span class="float-right">Rp. <span id="total-harga"></span></span></li>
              <li class="list-group-item">Total bayar : <input type="number" id="totalbayar" class="border-0 bg-transparent w-50 float-right text-right" placeholder="Total bayar"></li>
              <li class="list-group-item">Diskon : <div class="float-right w-50 d-flex justify-content-end"><input type="number" value="0" id="totaldiskon" class="border-0 bg-transparent w-50 text-right" placeholder="Diskon">%</div>
              </li>
              <li class="list-group-item">Total akhir : <span class="float-right">Rp. <span id="totalakhir"></span></span></li>
              <li class="list-group-item">Kembalian : <span class="float-right">Rp. <span id="totalkembalian"></span></span></li>
            </ul>
            <button class="btn btn-success btn-block mt-4" onclick="submit()"><i class="fas fa-shopping-bag pe-3"></i> Bayar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@push('js')
<script>
  let harga = 0;
  let totalharga = 0;
  const inputs = document.querySelectorAll('.quantity');

  function incrementQuantity(cartId) {
    let quantityInput = document.getElementById('quantity_' + cartId);
    quantityInput.value = parseInt(quantityInput.value) + 1;
    setTotal()
  }

  function decrementQuantity(cartId) {
    let quantityInput = document.getElementById('quantity_' + cartId);
    let currentValue = parseInt(quantityInput.value);
    if (currentValue > 1) {
      quantityInput.value = currentValue - 1;
      setTotal()
    }
  }


  inputs.forEach(function(input) {
    input.addEventListener('input', function() {
      let value = this.value;
      value < 1 ? this.value = 1 : '';
      setTotal()
    });
  });

  setTimeout(() => {
    setTotal()
  }, 100)

  function setTotal() {
    @foreach($carts as $r)
    if ($('#quantity_{{ $r->id }}').val() > '{{$r->good->stock}}') {
      $('#quantity_{{ $r->id }}').val(1)
    }
    // harga += parseInt($('#quantity_{{ $r->id }}').val()) * parseInt('{{$r->good->selling_price}}')
    harga += parseInt($('#quantity_{{ $r->id }}').val()) * parseInt('{{$r->good->selling_price}}')
    $('#total-harga').html(harga.toLocaleString('id-ID', {
      style: 'decimal',
      minimumFractionDigits: 0
    }))
    @endforeach
    totalharga = harga
    harga = 0;
  }

  setInterval(() => {
    hargadiskon = (totalharga * $('#totaldiskon').val()) / 100
    totalakhir = totalharga - hargadiskon
    kembalian = $('#totalbayar').val() - totalakhir
    $('#totalakhir').html(totalakhir.toLocaleString('id-ID', {
      style: 'decimal',
      minimumFractionDigits: 0
    }))
    $('#totalkembalian').html(kembalian.toLocaleString('id-ID', {
      style: 'decimal',
      minimumFractionDigits: 0
    }))
  }, 500)

  function submit() {
    let randomNum = Math.floor(Math.random() * 9999999999);
    // Membuat daftar karakter huruf yang mungkin
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'; // Anda dapat menambahkan huruf kecil jika perlu

    // Menghasilkan tiga huruf acak
    let randomLetters = '';
    for (let i = 0; i < 3; i++) {
      let randomIndex = Math.floor(Math.random() * chars.length);
      randomLetters += chars.charAt(randomIndex);
    }

    const code = randomLetters + randomNum;
    @foreach($carts as $r)
    // harga += parseInt($('#quantity_{{ $r->id }}').val()) * parseInt('{{$r->good->selling_price}}')
    Livewire.dispatch('submitData', [code, '{{$r->good->id}}', parseInt($('#quantity_{{ $r->id }}').val()), parseInt($('#totalbayar').val()), totalakhir, parseFloat($('#totaldiskon').val() / 100)])

    @endforeach
  }
</script>
@endpush