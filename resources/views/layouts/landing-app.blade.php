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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>

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
                    <a href="{{ route('home.index') }}" class="fs-14 poppins-medium dark-green header-list">Beranda</a>
                    <a href="{{ route('product.getAllData') }}" class="fs-14 poppins-medium dark-green header-list">Produk</a>
                    <a href="" class="fs-14 poppins-medium dark-green header-list">Keranjang</a>
                    <a href="" class="fs-14 poppins-medium dark-green header-list">Tentang Kami</a>
                </ul>
            </div>
            @if (Auth::user())
            {{-- <div class="col-md-3 d-flex justify-content-end">
                <h6 class="fs-18 poppins-semibold dark-green">Halo, {{ Auth::user()->nama }}</h6>
            </div> --}}
            <div class="dropdown col-md-3 d-flex justify-content-end">
                <div class="p-2 user-info d-flex align-items-center gap-2 cursor-pointer rounded dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    {{-- <img src="" alt="Profile" width="20px" height="20px" class="rounded-circle p-1"> --}}
                    <div class="text-truncate f14 user-select-none">{{ Auth::user()->nama }}</div>
                </div>

                <div class="dropdown-menu dropdown-menu-end p-2 border shadow bg-white" id="user-menu" style="width:100px">
                    <div class="d-flex w-100 align-items-center gap-4 px-2 pb-2 mb-2 border-bottom">
                        <div class="flex-grow-1">
                            <div class="text-truncate user-select-none fw-medium f20">{{ Auth::user()->nama }}</div>
                            {{-- <div class="d-flex gap-2 align-items-center mt-1">
                                @if ($user->email_verified_at)
                                    <ion-icon name="checkmark-circle" class="text-success"></ion-icon>
                                    <div class="text-success fw-medium f12">Verified</div>
                                @else
                                    <ion-icon name="close-circle" class="text-danger"></ion-icon>
                                    <div class="text-danger fw-medium f12">Unverified</div>
                                @endif
                            </div> --}}
                        </div>
                        {{-- <img src="" alt="Profile" width="50px" height="50px" class="rounded-circle p-1 flex-shrink-0"> --}}
                    </div>

                    @if (Auth::user()->role_id !== 3)
                    <a class="w-100 dropdown-item d-flex align-items-center gap-2 p-2 mb-1 rounded cursor-pointer" href="">
                        {{-- <ion-icon name="settings" class="f20 flex-shrink-0"></ion-icon> --}}
                        <a href="{{ route('dashboard.manage-product.index') }}" class="user-select-none fw-medium flex-grow-1">Dashboard</a>
                    </a>
                    @endif

                    <a class="w-100 dropdown-item d-flex align-items-center gap-2 p-2 mb-1 rounded cursor-pointer" href="">
                        {{-- <ion-icon name="settings" class="f20 flex-shrink-0"></ion-icon> --}}
                        <a href="{{ route('profile.update') }}" class="user-select-none fw-medium flex-grow-1">Profil</a>
                    </a>

                    <form action="{{ route('auth.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-100 dropdown-item d-flex align-items-center gap-2 p-2 rounded cursor-pointer" style="border: none; background: none;">
                            <div class="user-select-none fw-medium flex-grow-1 text-success">Keluar</div>
                        </button>
                    </form>
                </div>
            </div>
            @else
            <div class="col-md-3 d-flex justify-content-end">
                <a href="{{ route('auth.login') }}" type="button" class="btn bg-medium-green poppins-medium text-white fs-14 px-3" style="background-color: #00A3A8;">Login</a>
            </div>
            @endif
        </div>
        <div class="mt-2">
            @yield('content')
        </div>
    </div>

    @include('partials.toast')

    <script>
        document.getElementsByClassName('dropdown')[0].addEventListener('mouseenter', ({ target }) => target.children[0].click());
        document.getElementsByClassName('dropdown')[0].addEventListener('mouseleave', ({ target }) => target.children[0].click());
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    @yield('script')
  </body>
</html>
