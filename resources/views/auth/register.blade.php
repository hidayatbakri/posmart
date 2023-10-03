<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Halaman Masuk - POSmart</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;600;700;800;900&display=swap');

    * {
      font-family: 'Poppins', sans-serif;
      color: #264653;
    }

    button {
      width: 150px;
      padding: 10px 0 !important;
    }

    .right {
      background-color: #e76f51;
    }
  </style>
  <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
</head>

<body>
  <div class="">
    <div class="row me-1" style="height: 100vh;">
      <div class="col-md-6 col-sm-12 d-flex align-items-center">
        <form action="/auth" method="post" enctype="multipart/form-data">
          @csrf
          <div class="container ms-3">
            <h1 class="fs-3 fw-bold">Halaman Daftar</h1>
            <h1 class="fs-5 text-secondary mb-5">Point of sale Market</h1>
            <div class="row mb-4  ">
              <div class="col-md-6 col-sm-12">
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" name="name" id="floatingInput">
                  <label for="floatingInput">Nama</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="email" class="form-control" name="email" id="floatingInput">
                  <label for="floatingInput">Alamat email</label>
                </div>
                <div class="form-floating mb-4">
                  <input type="password" class="form-control" name="password" id="floatingPassword">
                  <label for="floatingPassword">Password</label>
                </div>
              </div>
              <div class="col-md-6 col-sm-12">
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" name="shop_name" id="floatingInput">
                  <label for="floatingInput">Nama toko</label>
                </div>
                <div class="form-floating mb-4">
                  <input type="number" class="form-control" name="phone_number" id="floatingInput">
                  <label for="floatingInput">Nomor hp</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="file" class="form-control" name="photo" id="floatingInput">
                  <label for="floatingInput">Foto profil</label>
                </div>
              </div>
              <div class="col-12">
                <div class="form-floating">
                  <textarea class="form-control" name="address" id="floatingTextarea"></textarea>
                  <label for="floatingTextarea">Alamat</label>
                </div>
              </div>
            </div>
            <a href="" class="text-decoration-none">Sudah punya akun?</a>
            <div class="d-flex justify-content-center mt-5">
              <button class="btn btn-primary btn-block w-100 me-3">Daftar</button>
            </div>
          </div>
        </form>
      </div>
      <div class="col-md-6 col-sm-12 right d-flex align-items-center justify-content-center">

        <img src="/assets/img/register.png" alt="login-image" style="width: 80%;">
      </div>

    </div>
  </div>
  <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/jQuery.min.js') }}"></script>
  <script>
    setInterval(() => {
      if ($(window).width() <= 768) {
        $(".right").hide(500);
        $(".right").removeClass("col-md-6 col-sm-12 d-flex align-items-center justify-content-center");
      } else {
        $(".right").show(500);
        $(".right").addClass("col-md-6 col-sm-12 d-flex align-items-center justify-content-center");
      }
    }, 500);
  </script>
</body>

</html>