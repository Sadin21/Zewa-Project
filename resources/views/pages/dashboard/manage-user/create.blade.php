@extends('layouts.dashboard-app')

@section('content')
<section>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('dashboard.manage-product.index') }}">Kelola Akun</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah</li>
        </ol>
    </nav>

    <div class="card border-0 row">
        <div class="col-6 mt-4">
            <h5 class="poppins-semibold">Tambah Akun</h5>
            <form  action="{{ route('dashboard.manage-user.'. $mode, $mode === 'update'? [ 'id' => $user->id ] : null) }}" method="POST" enctype="multipart/form-data" class="" style="margin-top: 3rem;">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label fs-14 poppins-medium dark-green">Role</label>
                            <select class="form-select" name="role_id">
                                @foreach ($roles as $r)
                                    <option value="{{ $r->id }}" {{ $r->name }} {{ isset($user) && $user->role_id === $r->id ? 'selected' : '' }}>
                                        {{ $r->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fs-14 poppins-medium dark-green">Nama</label>
                            <div class="d-flex gap-2">
                                <input name="nama" type="text" required class="form-control" id="nama" aria-describedby="emailHelp" value="{{ isset($user) ? $user->nama : '' }}"  placeholder="Tulis Nama">
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label fs-14 poppins-medium dark-green">Email</label>
                            <div class="d-flex gap-2">
                                <input name="email" type="email" required class="form-control" id="email" aria-describedby="emailHelp" value="{{ isset($user) ? $user->email : '' }}"  placeholder="Tulis Email">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fs-14 poppins-medium dark-green">Password</label>
                            <div class="d-flex gap-2">
                                <input name="password" type="text" required class="form-control" id="password" aria-describedby="emailHelp" value="{{ isset($user) ? $user->password : '' }}"  placeholder="Tulis Password">
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label fs-14 poppins-medium dark-green">Nomor KTP</label>
                            <div class="d-flex gap-2">
                                <input name="no_ktp" type="number" class="form-control" id="no_ktp" aria-describedby="emailHelp" value="{{ isset($user) ? $user->no_ktp : '' }}"  placeholder="Tulis Nomor KTP">
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label fs-14 poppins-medium dark-green">Nomor HP</label>
                            <div class="d-flex gap-2">
                                <input name="no_hp" type="number" class="form-control" id="no_hp" aria-describedby="emailHelp" value="{{ isset($user) ? $user->no_hp : '' }}"  placeholder="Tulis Nomor HP">
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label fs-14 poppins-medium dark-green">Alamat</label>
                            <textarea class="form-control" name="alamat" placeholder="Tuliskan Alamat">{{ isset($user) ? $user->alamat : '' }}</textarea>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fs-14 poppins-medium dark-green">Foto</label>
                        <div>
                            <input type="file" name="foto" id="foto" class="d-none" />
                            <div class="d-flex">
                                <label for="foto" class="img-selector pc-logo me-4">
                                    <i class="fa-solid fa-plus"></i>
                                </label>
                                <div id="img-preview" style="width: 135px; height: 60px">
                                    <img src="/assets/imgs/user/{{ isset($user) ? $user->foto : '' }}" class="img-fluid border border-2 border-primary rounded" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-end my-4">
                    <button type="submit" class="btn bg-medium-green poppins-medium text-white fs-14 py-2" style="background-color: #00A3A8;">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
    var logedUserRole = {!! json_encode(Auth::user()->role_id ?? null) !!};
    if (logedUserRole !== 1) {
        window.location.href = `{{ route('home.index') }}`;
    }

    const chooseFile = document.getElementById("foto");
    const imgPreview = document.getElementById("img-preview");

    chooseFile.addEventListener("change", function () {
        getImgData();
    });

    function getImgData() {
        const files = chooseFile.files[0];
        if (files) {
            const fileReader = new FileReader();
            fileReader.readAsDataURL(files);
            fileReader.addEventListener("load", function () {
                let imgElement = document.createElement("img");
                imgElement.setAttribute("src", this.result);
                imgElement.setAttribute("class", "img-fluid border border-2 border-primary rounded");
                imgPreview.innerHTML = "";
                imgPreview.appendChild(imgElement);
            });
        }
    }

    function generateCode() {
        const codeInput = document.getElementById("kode");
        const length = 6;

        const randomCode = Array.from({ length }, () => {
            const charset = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            const randomIndex = Math.floor(Math.random() * charset.length);
            return charset[randomIndex];
        }).join("");

        codeInput.value = randomCode;
    }

</script>
@endsection
