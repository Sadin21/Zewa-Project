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
            <div class="border border-2 p-2 w-100 mt-4 d-flex gap-4">
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
            <div style="width: 80%" class="pb-4 row">
                <div class="col">
                    <h5 class="poppins-medium dark-green mt-4">Syarat & Ketentuan</h5>
                    <ul>
                        <li class="poppins-regular fs-14">Menyimpan kartu KTP saat melakukan penyewaan</li>
                        <li class="poppins-regular fs-14">DP minimal 50% dari harga sewa</li>
                    </ul>
                </div>
            </div>
            <div style="width: 80%" class="pb-4 row gap-3">
                <div class="col border border-2 rounded-0 py-4">
                    <h5 class="poppins-medium dark-green mb-3">Pilih Paket</h5>
                    {{-- <select class="form-select" aria-label="Default select example" id="duration-select">
                        <option selected>Pilih paket</option>
                        <option value="1">1 Hari - Rp <span id="product-price">{{number_format($product->harga,0,',','.')}}</span></option>
                        <option value="2">2 Hari - Rp. 40.000</option>
                        <option value="3">3 Hari - Rp. 60.000</option>
                    </select> --}}
                    <div class="input-group">
                        <select class="form-select" aria-label="Default select example" id="package-sewa">
                            <option selected>Pilih hari</option>
                            <option value="1">1</option>
                            <option value="3">3</option>
                            <option value="5">5</option>
                            <option value="7">7</option>
                        </select>
                        <input type="text" aria-label="price" class="form-control" id="price-sewa">
                    </div>
                </div>
                <div class="col border border-2 rounded-0 py-4">
                    <h5 class="poppins-medium dark-green mb-3">Tanggal Waktu Sewa</h5>
                    <div class="input-group">
                        <input type="date" aria-label="date" class="form-control" id="date-sewa">
                        <input type="time" aria-label="time" class="form-control" id="time-sewa">
                    </div>
                </div>
            </div>
            <div style="width: 80%" class="pb-4 row gap-3">
                <div class="col border border-2 rounded-0 py-4">
                    <h5 class="poppins-medium dark-green mb-3">Pilih Tipe Sewa</h5>
                    <div class="input-group">
                        <select class="form-select" aria-label="Default select example" id="status-sewa">
                            <option value="ambil">Ambil Sendiri</option>
                            <option value="antar">Di antarkan</option>
                        </select>
                    </div>
                </div>
                <div class="col border border-2 rounded-0 py-4">
                    <h5 class="poppins-medium dark-green mb-3">Alamat</h5>
                    <div class="form-floating">
                        <textarea class="form-control" id="address-sewa" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 150px"></textarea>
                    </div>
                </div>
            </div>
            <div style="width: 80%" class="row gap-3">
                <div class="col p-0">
                    <a href="" type="button" class="btn bg-medium-green poppins-medium text-white fs-14 w-100 rounded-0" style="background-color: #00A3A8;" id="storeToCart">Masukkan Keranjang</a>
                </div>
                <div class="col p-0">
                    <a href="" type="button" class="btn bg-medium-green poppins-medium text-white fs-14 w-100 rounded-0" style="background-color: #00A3A8;" id="directPayment">Lanjut Pembayaran</a>
                </div>
            </div>
        </div>
    </div>
</section>

<br>
<br>
@endsection

@section('script')
    <script>
        var totalPrice = 0;

        document.getElementById('package-sewa').addEventListener('change', function() {
            var duration = parseInt(this.value);
            var productPrice = {{ $product->harga }}
            totalPrice = duration * productPrice;

            var displayPrice = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(totalPrice);

            document.getElementById('price-sewa').value = displayPrice;

        })

        $(document).ready(function() {
            function getSelectedValue() {
                const selectedPackage = document.getElementById('package-sewa').value;
                const selectedPrice = document.getElementById('price-sewa').value;
                const selectedDate = document.getElementById('date-sewa').value;
                const selectedTime = document.getElementById('time-sewa').value;
                const selectedStatus = document.getElementById('status-sewa').value;
                const selectedAddress = document.getElementById('address-sewa').value;

                const productId = {{ $product->id }};
                const userId = {{ auth()->user()? auth()->user()->id : 0 }};
                const datetimeString = selectedDate + ' ' + selectedTime;
                // const datetimeString = selectedDate + 'T' + selectedTime + ':00';
                // const datetime = new Date(datetimeString);

                return {
                    productId: productId,
                    userId: userId,
                    selectedDatetime: datetimeString,
                    selectedPackage: selectedPackage,
                    selectedStatus: selectedStatus,
                    selectedPrice: totalPrice,
                    selectedAddress: selectedAddress
                };
            }

            $('#storeToCart').click(function(e) {
                e.preventDefault();

                const selectedValue = getSelectedValue();
                console.log(selectedValue);

                $.ajax({
                    url: "{{ route('cart.store') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        product_id: selectedValue.productId,
                        user_id: selectedValue.userId,
                        waktu_sewa: selectedValue.selectedDatetime,
                        paket_sewa: selectedValue.selectedPackage,
                        status_ambil: selectedValue.selectedStatus,
                        sub_total: selectedValue.selectedPrice,
                        alamat: selectedValue.selectedAddress
                    },
                    success: function(res) {
                        window.location.href = "{{ route('cart.index') }}";
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("Error:", textStatus, errorThrown);
                    }
                });
            })
        })
    </script>
@endsection
