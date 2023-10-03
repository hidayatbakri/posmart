<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Halaman Masuk - POSmart</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
  </style>
  <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
</head>

<body>
  <div class="">
    <div class="row me-1" style="height: 100vh;">
      <div class="col-md-5 col-sm-12 d-flex align-items-center">
        <div class="container ms-3">
          <form action="/login" method="post">
            @csrf
            <h1 class="fs-3 fw-bold">Halaman Masuk</h1>
            <h1 class="fs-5 text-secondary mb-5">Point of sale Market</h1>
            <div class="form-floating mb-3">
              <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="floatingInput" placeholder="name@example.com" value="{{ @old('email') }}">
              <label for="floatingInput">Email address</label>
              @error('email')
              <div id="validationServer04Feedback" class="invalid-feedback">
                {{$message}}
              </div>
              @enderror
            </div>
            <div class="form-floating mb-4">
              <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="floatingPassword" placeholder="Password">
              <label for="floatingPassword">Password</label>
              @error('password')
              <div id="validationServer04Feedback" class="invalid-feedback">
                {{$message}}
              </div>
              @enderror
            </div>
            <a href="" class="text-decoration-none">Lupa password?</a>
            <div class="d-flex justify-content-center mt-5">
              <button type="submit" class="btn btn-primary me-3">Masuk</button>
              <a href="/register">
                <button type="button" class="btn btn-outline-secondary">Daftar</button>
              </a>
            </div>
          </form>
        </div>
      </div>
      <div class="col-md-7 col-sm-12 d-flex align-items-center justify-content-center bg-primary">
        <img src="/assets/img/login-img.png" alt="login-image" style="width: 80%;">
      </div>

    </div>
  </div>
  <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/jQuery.min.js') }}"></script>
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

  <script src="{{ asset('/sw.js') }}"></script>

</body>

</html>