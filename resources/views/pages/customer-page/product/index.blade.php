@extends('layouts.landing-app')

@section('content')
<section class="" style="margin-top: 0rem;">
    <div class="col-6">
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
            <div class="d-flex gap-3">
                <select class="productCategoryName form-select" style="width: 300px !important; height: 300px !important" name="productCategoryName"></select>
                <select class="productName form-select" style="width: 300px !important; height: 300px !important" name="productName"></select>
            </div>
        </div>
    </div>
    <div class="col row" id="productContainer" style="margin-top: 5rem;">
    </div>
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
                                <div class="col-3 mb-4">
                                    <div class="card">
                                        <img src="/assets/imgs/product/${product.foto}" class="card-img-top" style="max-height: 200px" alt="...">
                                        <div class="card-body" style="height: 230px">
                                            <div class="d-flex justify-content-between"  style="height: 50px">
                                                <h5 class="card-title poppins-medium fs-18">${product.nama}</h5>
                                                <p class="mb-0 poppins-medium fs-12">${product.category}</p>
                                            </div>
                                            <div class="mb-3">
                                                <p class="mb-0 poppins-regular fs-12">Harga sewa mulai dari</p>
                                                <p class="mb-0 poppins-medium fs-14">Rp ${numberFormat(product.harga)}</p>
                                            </div>
                                            <div class="mb-3">
                                                <p class="mb-0 poppins-regular fs-12">Tersewakan</p>
                                                <p class="mb-0 poppins-medium fs-14">${product.tersewakan}</p>
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
        var selectedProductName = '';
        var $productCategoryNameSelect = $('.productCategoryName');
        var $productNameSelect = $('.productName');

        // $('.categoryIdRadio').change(function () {
        //     selectedCategory = $(this).val();

        //     fetchAndDisplayProducts({ category: selectedCategory });
        //     document.getElementById('displayProductCategory').innerText = selectedCategory;

        // })

        $productCategoryNameSelect.select2({
            placeholder: 'Cari Kategori Produk',
            ajax: {
                url: function (params) {
                    return 'http://127.0.0.1:8000/api/product-category';
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
            selectedCategory = $(this).val();
            selectedProductName = '';

            fetchAndDisplayProducts({ category: selectedCategory });
        });

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
            selectedProductName = $(this).val();
            selectedCategory = '';

            fetchAndDisplayProducts({ nama: selectedProductName });
        });
    </script>
@endsection
