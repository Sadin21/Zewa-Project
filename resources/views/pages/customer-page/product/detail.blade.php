@extends('layouts.landing-app')

@section('content')
<section class="" style="margin-top: 0rem;">
    <div class="d-flex justify-content-between">
        <div>
            <h3 class="poppins-semibold dark-green">Detail Produk</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Zewa</a></li>
                    <li class="breadcrumb-item" aria-current="page">Daftar Produk</li>
                    <li class="breadcrumb-item active" aria-current="page">Daftar Produk</li>
                </ol>
            </nav>
        </div>
        <div>
            {{-- <a href="#" class="btn poppins-medium text-white fs-14" style="background-color: #184A4B;">Lihat Detail</a> --}}
        </div>
    </div>
    <div class="row gap-4">
        <div class="col-4">
            <img src="{{ url('/assets/imgs/product/' . $product->foto) }}" class="card-img-top" style="max-height: 500px" alt="...">
            <div class="border p-2 w-100 mt-4 d-flex gap-4">
                <p class="mb-0 poppins-medium fs-14">Tanya seputar produk</p>
                <a href="">
                    <i class="fa-brands fa-whatsapp fs-18"></i>
                </a>
            </div>
        </div>
        <div class="col ms-4 ps-4">
            <div style="width: 80%" class="pb-4 border-bottom">
                <h5 class="poppins-semibold dark-green mt-4">{{ $product->nama }}</h5>
                <h6 class="poppins-regular fs-14">{{ $product->deskripsi }}</h6>
            </div>
            <div style="width: 80%" class="pb-4 border-bottom row">
                <div class="col">
                    <h5 class="poppins-medium dark-green mt-4">Rp {{number_format($product->harga,0,',','.')}}/hari</h5>
                    <h6 class="poppins-regular fs-14">Harga bisa berubah sewaktu waktu</h6>
                </div>
                <div class="col-4">
                    <h5 class="poppins-medium dark-green mt-4">{{ $product->stok }}</h5>
                    <h6 class="poppins-regular fs-14">Stok barang tersedia</h6>
                </div>
            </div>
            <div style="width: 80%" class="pb-4 border-bottom row">
                <div class="col">
                    <h5 class="poppins-medium dark-green mt-4">Syarat & Ketentuan</h5>
                    <ul>
                        <li class="poppins-regular fs-14">Menyimpan kartu KTP saat melakukan penyewaan</li>
                        <li class="poppins-regular fs-14">DP minimal 50% dari harga sewa</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
