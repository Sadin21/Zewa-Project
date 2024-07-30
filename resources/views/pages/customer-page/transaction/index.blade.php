@extends('layouts.landing-app')

@section('content')
<section>
    <div class="d-flex justify-content-between">
        <div>
            <h3 class="poppins-semibold dark-green">Transaksi Aktif</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Zewa</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Transaksi Aktif</li>
                </ol>
            </nav>
        </div>
    </div>

    @if ($data != null && count($data) > 0)

    <div>
        <table class="table">
            <thead>
              <tr>
                <th scope="col">Produk</th>
                <th scope="col">No Transaksi</th>
                <th scope="col">Waktu Sewa</th>
                <th scope="col">Waktu Pengembalian</th>
                <th scope="col">Subtotal</th>
                <th scope="col">Invoice</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($data as $d)
                <tr class="border border-2">
                    <td>
                        <div class="d-flex gap-3">
                            <img src="{{ url('/assets/imgs/product/' . $d->foto) }}" alt="" style="max-height: 70px; max-width: 70px; background-size: auto; border-radius: 0px;" class="">
                            <div class="my-auto">
                                <h5 class="card-title poppins-medium fs-18 productName" id="productName-{{ $d->nama }}">{{ $d->nama }}</h5>
                                <p class="mb-0 poppins-regular fs-12">{{ $d->kode }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="align-middle card-title poppins-medium fs-18 noTransaksi" id="noTransaksi-{{ $d->no_transaksi }}">{{ $d->no_transaksi }}</td>
                    <td class="align-middle card-title poppins-medium fs-18 waktuSewa" id="waktuSewa-{{ $d->waktu_sewa }}">{{ $d->waktu_sewa }}</td>
                    <td class="align-middle card-title poppins-medium fs-18 waktuPengembalian" id="waktuPengembalian-{{ $d->waktu_pengembalian }}">{{ $d->waktu_pengembalian }}</td>
                    <td class="align-middle card-title poppins-medium fs-18 subTotal" id="subtotal-{{ $d->sub_total }}">{{ $d->sub_total }}</td>
                    <td class="align-middle card-title poppins-medium fs-18 subTotal" id="subtotal-{{ $d->id }}">
                        <a href="{{ route('invoice.downloadInvoice', ['id' => $d->hdr_id]) }}"><i class="fa-solid fa-download"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <h5>tidak ada data</h5>
    @endif

</section>
@endsection

@section('script')
    <script>

    </script>
@endsection
