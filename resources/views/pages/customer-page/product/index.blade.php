@extends('layouts.landing-app')

@section('content')
<section class="" style="margin-top: 0rem;">
    <div class="d-flex justify-content-between">
        <div>
            <h3 class="poppins-semibold dark-green">Produk Tersedia</h3>
            <h6 class="poppins-medium fs-14">This week splecial products from Partners</h6>
        </div>
        <div>
            {{-- <a href="#" class="btn poppins-medium text-white fs-14" style="background-color: #184A4B;">Lihat Detail</a> --}}
        </div>
    </div>
    <div class="row mt-4">
        @foreach ($product as $p)
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
@endsection
