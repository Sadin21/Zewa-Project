<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Register | Zeewa</title>

        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <div class="py-3">
                <h3 class="poppins-medium medium-green">Zewa.</h3>
            </div>
            <div class="row mt-4">
                <div class="col-8">
                    <div class="mt-3">
                        <h3 class="poppins-semibold dark-green">Unlock Your</h3>
                        <h3 class="poppins-semibold medium-green">Team Performance</h3>
                    </div>
                    <img src="{{ url('/assets/imgs/people2.png') }}" alt="" style="width: 500px;">
                </div>
                <div class="col pt-4 mt-4">
                    <h3 class="poppins-semibold dark-green">Welcome to Zewa</h3>
                    <h6 class="poppins-medium medium-green fs-14">Buat akun barumu</h6>
                    <form  action="{{ route('auth.signup') }}" method="POST" enctype="multipart/form-data" class="" style="margin-top: 4rem;">
                        @csrf
                        <div class="mb-3">
                            <label for="inputEmail" class="form-label fs-14 poppins-medium dark-green">Nama</label>
                            <input name="nama" type="text" class="form-control" id="inputEmail" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="inputEmail" class="form-label fs-14 poppins-medium dark-green">Email address</label>
                            <input name="email" type="email" class="form-control" id="inputEmail" aria-describedby="emailHelp">
                        </div>
                        <div class="" style="margin-bottom: 5rem;">
                            <label for="inputPassword" class="form-label fs-14 poppins-medium dark-green">Password</label>
                            <input name="password" type="password" class="form-control" id="inputPassword" aria-describedby="emailHelp">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn bg-medium-green poppins-medium text-white fs-14 w-100 py-2" style="background-color: #00A3A8;">Login</button>
                            <h6 class="poppins-medium dark-green fs-14 mt-3">Sudah memiliki akun? <span><a href="{{ route('auth.login') }}" class="medium-green" style="text-decoration: none">Login</a></span> </h6>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        @include('partials.toast')
    </body>
</html>
