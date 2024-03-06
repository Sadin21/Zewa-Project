<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')Beranda | Zewa</title>

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  </head>
  <body>

    <section class="container">
        <!-- Header -->
        <div class="header d-flex py-3">
            <div class="col-md-3">
                <h6 class="fs-18 poppins-semibold dark-green">Zewa</h6>
            </div>
            <div class="col-md-6 d-flex justify-content-center align-items-center">
                <ul class="d-flex header" style="gap: 2rem;">
                    <li class="fs-14 poppins-medium dark-green header-list">Beranda</li>
                    <li class="fs-14 poppins-medium dark-green header-list">Produk</li>
                    <li class="fs-14 poppins-medium dark-green header-list">Keranjang</li>
                    <li class="fs-14 poppins-medium dark-green header-list">Tentang Kami</li>
                </ul>
            </div>
            <div class="col-md-3 d-flex justify-content-end">
                <a href="/auth/signin" type="button" class="btn bg-medium-green poppins-medium text-white fs-14 px-3" style="background-color: #00A3A8;">Login</a>
            </div>
        </div>
        <div class="mt-2">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
