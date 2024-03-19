@extends('layouts.landing-app')

@section('content')
<section>
    <div class="position-relative">
        <img src="{{ url('/assets/imgs/bg2.png') }}" alt="" style="height: 600px; background-size: auto; border-radius: 10px;" class="w-100">
        <div class="position-absolute top-50 start-50 translate-middle text-center">
            <h1 class="poppins-semibold text-white">Find A Product</h1>
            <h1 class="poppins-semibold text-white">You'll Love To Live</h1>
            <div class="bg-white mt-4 p-2 d-flex gap-3" style="width: 600px; border-radius: 4px;">
                <select class="form-select" aria-label="Default select example">
                    <option selected>Cari kategori produk</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
                <button type="button" class="btn poppins-medium text-white fs-14 py-2" style="background-color: #00A3A8;">Cari</button>
            </div>
        </div>
    </div>
</section>

<section class="" style="margin-top: 5rem;">
    <div class="d-flex justify-content-between">
        <div>
            <h3 class="poppins-semibold dark-green">Produk Terbaru</h3>
            <h6 class="poppins-medium fs-14">This week splecial products from Partners</h6>
        </div>
        <div>
            <a href="{{ route('product.getAllData') }}" class="btn poppins-medium text-white fs-14" style="background-color: #184A4B;">Lihat Produk</a>
        </div>
    </div>
    <div class="row mt-4">
        @foreach ($newProduct as $p)
            <div class="col-3">
                <div class="card">
                    <img src="{{ url('/assets/imgs/product/' . $p->foto) }}" class="card-img-top" style="max-height: 200px" alt="...">
                    <div class="card-body">
                        <h5 class="card-title poppins-medium fs-18">{{ $p->nama }}</h5>
                        <div class="my-3">
                            <p class="mb-0 poppins-regular fs-12">Harga sewa mulai dari</p>
                            <p class="mb-0 poppins-medium fs-14">Rp {{number_format($p->harga,0,',','.')}}</p>
                        </div>
                        <a href="#" class="btn poppins-medium text-white fs-14" style="background-color: #184A4B;">Lihat Detail</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

<section class="" style="margin-top: 5rem;">
    <div class="d-flex justify-content-between">
        <div>
            <h3 class="poppins-semibold dark-green">Produk Kategori</h3>
            <h6 class="poppins-medium fs-14">This week splecial products from Partners</h6>
        </div>
        <div>
            {{-- <a href="#" class="btn poppins-medium text-white fs-14" style="background-color: #184A4B;">Lihat Detail</a> --}}
        </div>
    </div>
    <div class="row mt-4">
        @foreach ($totalCategoryProduct as $cp)
            <div class="col-3">
                <div class="card">
                    {{-- <img src="{{ url('/assets/imgs/laptop.jpg') }}" class="card-img-top" alt="..."> --}}
                    <div class="card-body">
                        <h5 class="card-title poppins-medium fs-18">{{ $cp->category }}</h5>
                        <div class="my-3">
                            <p class="mb-0 poppins-regular fs-12">Total barang tersedia saat ini</p>
                            <p class="mb-0 poppins-medium fs-14">{{ $cp->total }} unit</p>
                        </div>
                        <a href="#" class="btn poppins-medium text-white fs-14" style="background-color: #184A4B;">Lihat Produk</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

<section class="" style="margin-top: 5rem;">
    <div class="d-flex justify-content-center">
        <div class="w-50">
            <div class="text-center">
                {{-- <h3 class="poppins-semibold dark-green">Tentang Kami</h3> --}}
                <h5 class="poppins-regular mt-4"><span class="poppins-semibold dark-green">Zewa</span> merupakan platform atau wadah digital yang mempertemukan mitra sewa yang ingin menyewakan barangnya dengan penyewa barang yang membutuhkan suatu barang untuk disewa dengan Lebih Mudah, Lebih Aman, dan Lebih Terpercaya</h5>
            </div>
        </div>
    </div>
    <img src="{{ url('/assets/imgs/company.jpg') }}" alt="" style="height: 600px; background-size: auto; border-radius: 10px;" class="w-100">
    <div class="row mt-4">
        <div class="col">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title poppins-medium fs-18">Visi</h5>
                    <p class="card-text poppins-light fs-14">Menjadi platform yang aman dan terpercaya dalam sewa menyewa barang</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title poppins-medium fs-18">Visi</h5>
                    <ul>
                        <li class="poppins-light fs-14">Memberikan pelayanan terbaik kepada mitra & pelanggan.</li>
                        <li class="poppins-light fs-14">Memberikan kemudahan dalam sewa menyewa barang.</li>
                        <li class="poppins-light fs-14">Memberikan harga yang terjangkau dan batas waktu penyewaan yang telah disepakati.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="text-center" style="margin-top: 8rem;">
    <h6 class="poppins-medium fs-14">Zewa@2024</h6>
</section>
@endsection
