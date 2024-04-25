@extends('layouts.dashboard-app')

@section('content')
<section>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Transaksi Aktif</li>
        </ol>
    </nav>

    <div class="card border-0 flex-grow-1 d-flex flex-column" id="table">
        {{-- <div>
            <a class="btn btn btn-success" href="{{ route('dashboard.manage-product.create') }}">Tambah</a>
        </div> --}}

        <div class="p-1 flex-grow-1 mt-4 menu-table">
            <table class="table w-100" id="transaction-table" style="border-radius: 10px">
                <thead>
                    <tr style="background-color: #F8F8F8">
                        <th>Kode</th>
                        <th>Produk</th>
                        <th>Penyewa</th>
                        <th>Alamat</th>
                        <th>Tanggal Sewa</th>
                        <th>Tanggal kembali</th>
                        <th>Paket</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>

    var logedUser = {!! json_encode(Auth::user()->id ?? null) !!};
    var logedUserRole = {!! json_encode(Auth::user()->role_id ?? null) !!};

    function showData() {
        $.ajax({
            url: "{{ route('dashboard.manage-transaction.getAllData') }}?logedUserId=" + logedUser + "&logedUserRole=" + logedUserRole,
            type: "GET",
            dataType: "JSON",
            success: function (res) {
                originalData = res.data;

                var rotationTable = $('#transaction-table').DataTable({
                    data: originalData,
                    columns: [
                        {data: 'kode', name: 'kode'},
                        {data: 'nama', name: 'nama'},
                        {data: 'penyewa', name: 'penyewa'},
                        {
                            data: 'alamat',
                            name: 'alamat',
                            render: function (data) {
                                if (data == null)
                                    return `
                                        -
                                    `;
                                else
                                    return `
                                        ${data}
                                    `;
                            }
                        },
                        {data: 'waktu_sewa', name: 'waktu_sewa'},
                        {data: 'waktu_pengembalian', name: 'waktu_pengembalian'},
                        {data: 'sub_total', name: 'sub_total'},
                        {data: 'paket_sewa', name: 'paket_sewa'},
                    ],
                    'searching': false,
                    'responsive': (screen.width > 960) ? true : false,
                });
            },
            error: function (jqXHR, textStatus, errorThrown) {
                throw new Error(errorThrown);
            }
        });
    }

    showData();
</script>
@endsection
