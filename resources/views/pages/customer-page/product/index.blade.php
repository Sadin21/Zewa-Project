@extends('layouts.landing-app')

@section('content')
<section class="row" style="margin-top: 0rem;">
    <div class="col-3">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Zewa</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Daftar Produk</li>
                </ol>
            </nav>
        </div>
        <div class="mb-4">
            <h3 class="poppins-semibold dark-green" id="displayProductCategory">Produk Tersedia</h3>
            <select class="productName form-select" style="width: 300px !important; height: 300px !important" name="productName"></select>
        </div>
        @foreach ($categoryData as $cp)
        <div class="mb-2 d-flex gap-3">
            <input class="form-check-input radio categoryIdRadio" type="radio" name="category" value="{{ $cp->category }}" id="check-{{ $cp->category }}">
            <p class="mb-0 poppins-medium fs-14">{{ $cp->category }}</p>
        </div>
        @endforeach
        {{-- <div class="row mt-4">
            @foreach ($categoryData as $cp)
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title poppins-medium fs-18" id="categoryId">{{ $cp->category }}</h5>
                            <div class="my-3">
                                <p class="mb-0 poppins-regular fs-12">Total barang tersedia saat ini</p>
                                <p class="mb-0 poppins-medium fs-14">{{ $cp->total }} unit</p>
                            </div>
                            <a href="#" class="btn poppins-medium text-white fs-14" style="background-color: #184A4B;">Lihat Produk</a>
                        </div>
                    </div>
            @endforeach
        </div> --}}
    </div>
    <div class="col row" id="productContainer" style="margin-top: 5rem;">
        {{-- <h3 class="poppins-semibold dark-green">Produk Tersedia</h3> --}}
        <!-- Products will be dynamically added here -->
    </div>
    {{-- <div class="row mt-4">
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
                        <a href="{{ route('product.getDetailData', ['id' => $p->id]) }}" class="btn poppins-medium text-white fs-14" style="background-color: #184A4B;">Lihat Detail</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div> --}}
</section>
@endsection

@section('script')
    <script>
        function fetchAndDisplayProducts(filters) {
            $('#productContainer').empty();

            $.ajax({
                url: 'http://127.0.0.1:8000/api/product',
                type: 'GET',
                data: filters,
                success: function(response) {
                    if (response.message === 'Success get data' && response.totalRecords > 0) {
                        response.data.forEach(function(product) {
                            var productHtml = `
                                <div class="col-4 mb-4">
                                    <div class="card">
                                        <img src="/assets/imgs/product/${product.foto}" class="card-img-top" style="max-height: 200px" alt="...">
                                        <div class="card-body" style="height: 190px">
                                            <div class="d-flex justify-content-between"  style="height: 50px">
                                                <h5 class="card-title poppins-medium fs-18">${product.nama}</h5>
                                                <p class="mb-0 poppins-medium fs-12">${product.category}</p>
                                            </div>
                                            <div class="my-3">
                                                <p class="mb-0 poppins-regular fs-12">Harga sewa mulai dari</p>
                                                <p class="mb-0 poppins-medium fs-14">Rp ${numberFormat(product.harga)}</p>
                                            </div>
                                            <a href="/product/detail/${product.id}" class="btn poppins-medium text-white fs-14" style="background-color: #184A4B;">Lihat Detail</a>
                                        </div>
                                    </div>
                                </div>
                            `;
                            // Append the generated HTML to the product container
                            $('#productContainer').append(productHtml);
                        });
                    } else {
                        var productHtml = `
                            <div class="col-3">
                                <h5 class="card-title poppins-medium fs-18">Data kosong</h5>
                            </div>
                        `;
                        // Append the generated HTML to the product container
                        $('#productContainer').append(productHtml);

                        console.error('Failed to fetch products.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Failed to fetch products:', error);
                }
            });
        }

        function numberFormat(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        fetchAndDisplayProducts({});

        var selectedCategory = 0;
        var $productNameSelect = $('.productName');

        $('.categoryIdRadio').change(function () {
            selectedCategory = $(this).val();

            fetchAndDisplayProducts({ category: selectedCategory });
            document.getElementById('displayProductCategory').innerText = selectedCategory;

        })

        $productNameSelect.select2({
            placeholder: 'Cari Produk',
            ajax: {
                url: function (params) {
                    return 'http://127.0.0.1:8000/api/product?category=' + selectedCategory;
                },
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        nama: params.term,
                    };
                },
                processResults: function (data) {
                    return {
                        results:  $.map(data.data, function (item) {
                            return {
                                text: item.nama,
                                id: item.nama,
                            }
                        })
                    };
                },
                cache: true
            }
        }).on('change', function (e) {
            var selectedProductName = $(this).val();

            fetchAndDisplayProducts({ nama: selectedProductName });
        });
    </script>
@endsection
