<div>
  <div class="row">
    <div class="col-lg-9 col-md-12">
      <div class="card shadow-sm">
        <div class="card-body p-3">
          <a href="/user/transaksi" class="btn btn-primary mb-5">
            <i class="fas fa-eye"></i> Tampilan biasa
          </a>
          <!-- <a href="/user/keranjang" class="btn btn-info ms-3 mb-5"><i class="fas fa-shopping-cart"></i> Keranjang</a> -->
          <input type="text" class="form-control mb-3" autocomplete="off" id="search" autofocus placeholder="Cari data">
          <div class="results">
            <div class="row">
              <div class="col">
                <div class="card border">
                  <div class="card-body">
                    <div class="list-group">
                      @foreach($goods as $row)
                      @if(!$cart->contains('good_id', $row->id))
                      <button type="button" onclick="btnItem('{{ $row->id }}')" id="btn-item" class="list-group-item list-group-item-action {{ $row->stock > 0 ? '' : 'text-danger' }}" {{ $row->stock > 0 ? '' : 'disabled' }}>{{ $row->name }} | [Stok : {{ $row->stock > 0 ? $row->stock : 'Habis' }}]</button>
                      @else
                      <button type="button" class="list-group-item list-group-item-action bg-secondary" disabled>{{ $row->name }} [telah masuk keranjang]</button>
                      @endif
                      @endforeach
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Harga Jual</th>
                <th>Harga Modal</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($cart as $cr)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="font-weight-600">{{$cr->good->name}}</td>
                <td>Rp. {{ number_format($cr->good->selling_price, 0, ".", ".") }}</td>
                <td>
                  <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-secondary" onclick="decrementQuantity(`{{ $cr->id }}`)"><i class="fas fa-minus"></i></button>
                    <input type="number" name="" value="1" id="quantity_{{ $cr->id }}" class="w-25 quantity form-control text-center">
                    <button type="button" class="btn btn-success" onclick="incrementQuantity(`{{ $cr->id }}`)"><i class="fas fa-plus"></i></button>
                  </div>
                </td>
                <td>
                  <form action="/user/keranjang/{{ $cr->good->id }}" method="post">
                    @csrf
                    @method('delete')
                    <button class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-12">
      <div class="card shadow-sm">
        <div class="card-body p-3">
          <div class="table-responsive table-invoice">
            <ul class="list-group list-group-flush">
              <li class="list-group-item">Total harga : <span class="float-end">Rp. <span id="total-harga"></span></span></li>
              <li class="list-group-item">Total bayar : <input type="number" id="totalbayar" class="border-0 bg-transparent w-50 float-end text-right" placeholder="Total bayar"></li>
              <li class="list-group-item">Diskon : <div class="float-end w-50 d-flex justify-content-end"><input type="number" value="0" id="totaldiskon" class="border-0 bg-transparent w-50 text-right" placeholder="Diskon">%</div>
              </li>
              <li class="list-group-item">Total akhir : <span class="float-end">Rp. <span id="totalakhir"></span></span></li>
              <li class="list-group-item">Kembalian : <span class="float-end">Rp. <span id="totalkembalian"></span></span></li>
            </ul>
            <button class="btn btn-success btn-block w-100 mt-4" onclick="submit()"><i class="fas fa-shopping-bag pe-3"></i> Bayar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@push('js')
<script src="{{ asset('js/jQuery.min.js') }}"></script>
<script>
  // $('form').preventDefault()
  let harga = 0;
  let totalharga = 0;
  const inputs = document.querySelectorAll('.quantity');

  function incrementQuantity(cartId) {
    let quantityInput = document.getElementById('quantity_' + cartId);
    quantityInput.value = parseInt(quantityInput.value) + 1;
    Livewire.dispatch('setTotalCart')
  }

  function decrementQuantity(cartId) {
    let quantityInput = document.getElementById('quantity_' + cartId);
    let currentValue = parseInt(quantityInput.value);
    if (currentValue > 1) {
      quantityInput.value = currentValue - 1;
      Livewire.dispatch('setTotalCart')
    }
  }


  inputs.forEach(function(input) {
    input.addEventListener('input', function() {
      let value = this.value;
      value < 1 ? this.value = 1 : '';
      Livewire.dispatch('setTotalCart')
    });
  });

  setTimeout(() => {

    Livewire.dispatch('setTotalCart')
  }, 200)

  setInterval(() => {
    if ($('#totaldiskon').val() < 0) {
      $('#totaldiskon').val(0)
    }

  }, 500)

  let jsonData;

  Livewire.on('setTotal', carts => {
    setTimeout(() => {
      jsonData = JSON.parse(carts[0].carts);
      jsonData.forEach((cartItem) => {
        if ($(`#quantity_${cartItem.id}`).val() > cartItem.good.stock) {
          $(`#quantity_${cartItem.id}`).val(1)
          console.log('a')
        }
        harga += parseInt($(`#quantity_${cartItem.id}`).val()) * cartItem.good.selling_price;
      });
      totalharga = harga
      harga = 0;
    }, 500)
  })

  setInterval(() => {
    $('#total-harga').html(totalharga.toLocaleString('id-ID', {
      style: 'decimal',
      minimumFractionDigits: 0
    }))
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
    jsonData.forEach((cartItem) => {
      Livewire.dispatch('submitData', [code, cartItem.good.id, parseInt($(`#quantity_${cartItem.id}`).val()), parseInt($('#totalbayar').val()), totalakhir, parseFloat($('#totaldiskon').val() / 100)])
    });
  }

  function btnItem(id) {
    Livewire.dispatch('cartData', [id])
    $('#search').val("")

  }


  $('#search').keyup(function(e) {
    Livewire.dispatch('searchData', [$('#search').val()]);

    if (e.which == 13) {
      Livewire.dispatch('cartDataByBarcode', [$('#search').val()])
      Livewire.dispatch('setTotalCart')
      $('#search').val("")
      Livewire.dispatch('searchData', [null])
    }

  });
</script>
@endpush
</div>