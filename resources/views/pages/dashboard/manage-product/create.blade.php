@extends('layouts.dashboard-app')

@section('content')
<section>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('dashboard.manage-product.index') }}">Kelola Produk</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah</li>
        </ol>
    </nav>

    <div class="card border-0 row">
        <div class="col-6 mt-4">
            <h5 class="poppins-semibold">Tambah Produk</h5>
            <form  action="{{ route('dashboard.manage-product.'. $mode, $mode === 'update'? [ 'id' => $product->id ] : null) }}" method="POST" enctype="multipart/form-data" class="" style="margin-top: 3rem;">
                @csrf
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label fs-14 poppins-medium dark-green">Kategori</label>
                            <select class="form-select" name="category_id">
                                @foreach ($categories as $c)
                                    <option value="{{ $c->id }}" {{ $c->nama }} {{ isset($product) && $product->category_id === $c->id ? 'selected' : '' }}>
                                        {{ $c->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fs-14 poppins-medium dark-green">Kode</label>
                            <div class="d-flex gap-2">
                                <input name="kode" type="text" required class="form-control" id="kode" aria-describedby="emailHelp" value="{{ isset($product) ? $product->kode : '' }}"  placeholder="Tulis kode barang">
                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="generateCode()">
                                    <i class="fa-solid fa-play"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label fs-14 poppins-medium dark-green">Pemilik</label>
                            <input type="text" readonly class="form-control" aria-describedby="emailHelp" value="{{ Auth::user()->nama }}">
                            <input name="pemilik_id" type="hidden" class="form-control" aria-describedby="emailHelp" value="{{ Auth::user()->id }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fs-14 poppins-medium dark-green">Harga</label>
                            <input name="harga" type="number" class="form-control" required value="{{ isset($product) ? $product->harga : '' }}"   placeholder="Tulis harga barang">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fs-14 poppins-medium dark-green">Nama</label>
                        <input name="nama" type="text" class="form-control" aria-describedby="emailHelp" required value="{{ isset($product) ? $product->nama : '' }}"   placeholder="Tulis nama barang">
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label fs-14 poppins-medium dark-green">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" placeholder="Tuliskan deskripsi">{{ isset($product) ? $product->deskripsi : '' }}</textarea>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label fs-14 poppins-medium dark-green">Stok</label>
                            <input name="stok" type="number" class="form-control" aria-describedby="emailHelp" required value="{{ isset($product) ? $product->stok : '0' }}"   placeholder="">
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
                                    <img src="/assets/imgs/{{ isset($product) ? $product->foto : '' }}" class="img-fluid border border-2 border-primary rounded" alt="">
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
