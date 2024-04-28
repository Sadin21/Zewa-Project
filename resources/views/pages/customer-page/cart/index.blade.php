@extends('layouts.landing-app')

@section('content')
<section>
    <div class="d-flex justify-content-between">
        <div>
            <h3 class="poppins-semibold dark-green">Keranjang</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Zewa</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Keranjang</li>
                </ol>
            </nav>
        </div>
    </div>

    @if ($data != null && count($data) > 0)

    <div class="row">
        <div class="col">
            <table class="table">
                <thead>
                  <tr>
                    <th>
                        <input class="form-check-input" type="checkbox" value="" id="checkAll">
                    </th>
                    <th scope="col">Detail Produk</th>
                    <th scope="col">Waktu Sewa</th>
                    <th scope="col">Waktu Kembali</th>
                    <th scope="col">Status Ambil</th>
                    <th scope="col" class="col-3" sstyle="width:20%">Alamat</th>
                    <th scope="col">Sub Total</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($data as $d)
                    <tr class="border border-2">
                        <td>
                            <input class="form-check-input checkbox" type="checkbox" value="" id="check-{{ $d->id }}">
                            <p class="visually-hidden productId">{{ $d->productId }}</p>
                        </td>
                        <td>
                            <div class="d-flex gap-3">
                                <img src="{{ url('/assets/imgs/product/' . $d->foto) }}" alt="" style="max-height: 70px; max-width: 70px; background-size: auto; border-radius: 0px;" class="">
                                <div class="my-auto">
                                    <h5 class="card-title poppins-medium fs-18 productName" id="productName-{{ $d->nama }}">{{ $d->nama }}</h5>
                                    <p class="mb-0 poppins-regular fs-12">{{ $d->kode }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle card-title poppins-medium fs-18 waktuSewa" id="waktuSewa-{{ $d->waktu_sewa }}">{{ $d->waktu_sewa }}</td>
                        <td class="align-middle card-title poppins-medium fs-18 waktuPengembalian" id="waktuPengembalian-{{ $d->waktu_pengembalian }}">{{ $d->waktu_pengembalian }}</td>
                        <td class="align-middle card-title poppins-medium fs-18 statusAmbil" id="statusAmbil-{{ $d->status_ambil }}">{{ $d->status_ambil }}</td>
                        <td class="align-middle card-title poppins-medium fs-18  alamat" id="alamat-{{ $d->status_ambil }}">{{ $d->alamat }}</td>
                        <td class="align-middle card-title poppins-medium fs-18 subTotal" id="subtotal-{{ $d->sub_total }}">{{ $d->sub_total }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-3 mt-4">
            <div class="border border-2 mt-3 px-4 py-3">
                <h5 class="card-title poppins-medium fs-18">Total</h5>
                <div class="d-flex justify-content-between mt-4">
                    <div>
                        <p class="mb-0 poppins-medium fs-14">Total sewa</p>
                    </div>
                    <div>
                        <p class="mb-0 poppins-medium fs-14" id="subtotal-for-pay">Rp 0</p>
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <div>
                        <p class="mb-0 poppins-medium fs-14">Produk</p>
                    </div>
                    <div class="text-end">
                        <p class="mb-0 poppins-medium fs-14" id="product-for-pay">-</p>
                    </div>
                </div>
                <a href="" class="btn poppins-medium text-white fs-14 w-100 mt-4" style="background-color: #184A4B;" id="buttonPay">Bayar</a>
            </div>
        </div>
    </div>
    @else
    <h5>tidak ada data</h5>
    @endif

</section>
@endsection

@section('script')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script>

        $(document).ready(function() {
            // when checkAll checkbox is clicked
            $('#checkAll').click(function() {
                $('.checkbox').prop('checked', $(this).prop('checked'));
                displayTotal();
            })

            $('.checkbox').click(function() {
                displayTotal();
            })

            var grandTotal = 0;
            var selectedProduct = [];
            var cartId = [];
            var totalQty = 0;

            function displayTotal() {

                selectedProduct = [];
                $('.checkbox:checked').each(function() {
                    var row = $(this).closest('tr');
                    var productId = row.find('.productId').text();
                    var cartId = row.find('.checkbox').attr('id').substring(6);
                    var productName = row.find('.productName').text();
                    var waktuSewa = row.find('.waktuSewa').text();
                    var waktuPengembalian = row.find('.waktuPengembalian').text();
                    var statusAmbil = row.find('.statusAmbil').text();
                    var alamat = row.find('.alamat').text();
                    var subTotal = parseFloat(row.find('.subTotal').text());
                    var totalQty = parseFloat(row.find('.checkbox').val());

                    grandTotal += subTotal;
                    selectedProduct.push({
                        cartId: cartId,
                        productId: productId,
                        productName: productName,
                        waktuSewa: waktuSewa,
                        waktuPengembalian: waktuPengembalian,
                        statusAmbil: statusAmbil,
                        alamat: alamat,
                        subTotal: subTotal })
                });

                $('#subtotal-for-pay').text('Rp ' + grandTotal);

                var productContainer = $('#product-for-pay');
                productContainer.empty();

                selectedProduct.forEach(function(product) {
                    var productName = $('<p>', {
                        class: 'mb-0 poppins-medium fs-14',
                        text: product.productName
                    });

                    productContainer.append(productName);
                })

            }

            $('#buttonPay').click(function(e) {
                e.preventDefault();
                var snapToken = null;

                function handleSnapToken(token) {
                    snapToken = token;
                }

                $.ajax({
                    url: "{{ route('transaction.checkout') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        selectedProduct: selectedProduct,
                        grandTotal: grandTotal,
                        totalQty: selectedProduct.length,
                        directPayment: 0
                    },
                    success: function(res) {
                        snap.pay(res.snapToken, {
                            onSuccess: function(result){
                                var successUrl = "{{ route('transaction.success') }}?transactionHdrId=" + res.transactionHdrId;
                                window.location.href = successUrl;
                            },
                            onPending: function(result){
                                /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                            },
                            onError: function(result){
                                /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                            }
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("Error:", textStatus, errorThrown);
                    }
                });
            })

        })
    </script>
@endsection
