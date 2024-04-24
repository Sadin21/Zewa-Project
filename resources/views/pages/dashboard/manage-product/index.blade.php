@extends('layouts.dashboard-app')

@section('content')
<section>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Kelola Produk</li>
        </ol>
    </nav>

    <div class="card border-0 flex-grow-1 d-flex flex-column" id="table">
        {{-- <div class="row">
            <div class="col-md-2 btn-menu" id="btn-menu" style="display: none" name="state">
                <div class="position-relative select2-box">
                    <select class="search-menu form-control" name="search-menu">
                        <option @readonly(true)>Pilih</option>
                        <option value="search-nomor-reference">Nomor Reference</option>
                        <option value="search-nomor-polisi">Plat Nomor Armada</option>
                        <option value="search-date">Waktu Muat</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3" id="search-date" style="display: none;">
                <div class="input-group">
                    <input type="date" class="search-start-date form-control" id="start-date" name="search-start-date"></input>
                    <input type="date" class="search-end-date form-control" id="end-date" name="search-end-date"></input>
                </div>
            </div>
            <div class="col-md-3" id="search-nomor-reference" style="display: none">
                <div class="position-relative search-box">
                    <select class="search-nomor-reference form-control search-medium" name="search-nomor-reference"></select>
                </div>
            </div>
            <div class="col-md-3" id="search-nomor-polisi" style="display: none">
                <div class="position-relative search-box">
                    <select class="search-nomor-polisi form-control" name="search-nomor-polisi"></select>
                </div>
            </div>
            <div class="col" id="col-search" style="display: none">
                <div class="d-flex">
                    <div class="" id="btn-search" style="display: none">
                        <button class="btn fw-14">
                            <ion-icon name="search-outline"></ion-icon>
                        </button>
                    </div>
                    <div class="ms-2 " id="btn-cancel" style="display: none">
                        <button class="btn fw-14">
                            <ion-icon name="close-outline"></ion-icon>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col d-flex justify-content-between" id="col-filter">
                <div>
                    <div class="" id="btn-filter" style="display: block">
                        <button class="btn fw-14">Filter</button>
                    </div>
                </div>
                <div class="" id="btn-download" onclick="downloadExcel()">
                    <button id="download-pdf" class="btn">XLSX</button>
                </div>
            </div>
        </div> --}}

        <div>
            <a class="btn btn btn-success" href="{{ route('dashboard.manage-product.create') }}">Tambah</a>
        </div>

        <div class="p-1 flex-grow-1 mt-4 menu-table">
            <table class="table w-100" id="product-table" style="border-radius: 10px">
                <thead>
                    <tr style="background-color: #F8F8F8">
                        <th>Kode</th>
                        <th>Pemilik</th>
                        <th>Kategori</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Tersewakan</th>
                        <th>Stok</th>
                        <th>Deskripsi</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
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

    function showData() {
        $.ajax({
            url: "{{ route('dashboard.product.getAllData') }}?logedUserId=" + logedUser,
            type: "GET",
            dataType: "JSON",
            success: function (res) {
                originalData = res.data;
                // console.log(originalData);

                var rotationTable = $('#product-table').DataTable({
                    data: originalData,
                    columns: [
                        {data: 'kode', name: 'kode'},
                        {data: 'pemilik', name: 'pemilik'},
                        {data: 'category', name: 'category'},
                        {
                            data: 'foto',
                            name: 'foto',
                            render: function (data) {
                                if (data == null)
                                    return `
                                        -
                                    `;
                                else
                                    return `
                                        <img src="/assets/imgs/product/${data}" class="img-fluid border border-2 border-primary rounded w-40 h-50" alt="">
                                    `;
                            }
                        },
                        {data: 'nama', name: 'nama'},
                        {data: 'harga', name: 'harga'},
                        {data: 'tersewakan', name: 'tersewakan'},
                        {data: 'stok', name: 'stok'},
                        {data: 'deskripsi', name: 'deskripsi'},
                        {data: 'created_at', name: 'created_at'},
                        {
                            data: null,
                            render: function (data, type, row) {
                                return `
                                    <a class="btn btn-sm btn-light border border-1" onclick="editRow(${row.id})">Ubah</a>
                                    <a class="btn btn-sm btn-danger" href="#" onclick="hapusRow(${row.id})">Hapus</a>
                                `;
                            }
                        },
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

    function editRow(id) {
        window.location.href = `{{ route('dashboard.manage-product.update', 'id') }}`.replace('id', id);
    }

    function hapusRow(id) {
        Swal.fire({
            title: 'Hapus Data?',
            text: 'Anda yakin ingin menghapus data ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'DELETE',
                    url: `{{ route('dashboard.product.delete', ['id' => 'id']) }}`.replace('id', id),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        Swal.fire('Berhasil!', data.message, 'success');
                        location.reload(true);
                    },
                    error: function (error) {
                        Swal.fire('Gagal', error.responseJSON.message, 'error');
                    }
                });
            }
        });
    }

    showData();
</script>
@endsection
