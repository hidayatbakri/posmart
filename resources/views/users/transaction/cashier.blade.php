<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tampilan kasir - POSmart</title>
  <link href="{{asset('bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css')}}">

</head>

<body>
  <div class="container-fluid my-3">
    <livewire:cashier-live />
  </div>

  @livewireScripts
  @stack('js')

  <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js')}}"></script>
</body>

</html>