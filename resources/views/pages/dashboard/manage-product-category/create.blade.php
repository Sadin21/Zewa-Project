@extends('layouts.dashboard-app')

@section('content')
<section>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('dashboard.manage-product.index') }}">Kelola Kategori Produk</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah</li>
        </ol>
    </nav>

    <div class="card border-0 row">
        <div class="col-6 mt-4">
            <h5 class="poppins-semibold">Tambah Kategori Produk</h5>
            <form  action="{{ route('dashboard.manage-product-category.'. $mode, $mode === 'update'? [ 'id' => $category->id ] : null) }}" method="POST" enctype="multipart/form-data" class="" style="margin-top: 3rem;">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label fs-14 poppins-medium dark-green">Nama</label>
                            <div class="d-flex gap-2">
                                <input name="nama" type="text" required class="form-control" id="nama" aria-describedby="emailHelp" value="{{ isset($category) ? $category->nama : '' }}"  placeholder="Tulis Nama">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="my-4">
                    <button type="submit" class="btn bg-medium-green poppins-medium text-white fs-14 py-2" style="background-color: #00A3A8;">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
