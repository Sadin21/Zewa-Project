@extends('layouts.dashboard-app')

@section('content')
<section>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Kelola Akun</li>
        </ol>
    </nav>

    <div class="card border-0 flex-grow-1 d-flex flex-column" id="table">
        <div>
            <a class="btn btn btn-success" href="{{ route('dashboard.manage-user.create') }}">Tambah</a>
        </div>

        <div class="p-1 flex-grow-1 mt-4 menu-table">
            <table class="table w-100" id="user-table" style="border-radius: 10px">
                <thead>
                    <tr style="background-color: #F8F8F8">
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Role</th>
                        <th>Email</th>
                        <th>No KTP</th>
                        <th>No HP</th>
                        <th>Alamat</th>
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
    var logedUserRole = {!! json_encode(Auth::user()->role_id ?? null) !!};
    if (logedUserRole !== 1) {
        window.location.href = `{{ route('home.index') }}`;
    }

    function showData() {
        $.ajax({
            url: "{{ route('dashboard.manage-user.getAllData') }}",
            type: "GET",
            dataType: "JSON",
            success: function (res) {
                originalData = res.data;

                var rotationTable = $('#user-table').DataTable({
                    data: originalData,
                    columns: [
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
                                        <img src="/assets/imgs/user/${data}" class="img-fluid border border-2 border-primary rounded w-40 h-50" alt="">
                                    `;
                            }
                        },
                        {data: 'nama', name: 'nama'},
                        {data: 'role', name: 'role'},
                        {data: 'email', name: 'email'},
                        {
                            data: 'no_ktp',
                            name: 'no_ktp',
                            render: function (data) {
                                if (data == null)
                                    return '-';
                                else
                                    return data;
                            }
                        },
                        {
                            data: 'no_hp',
                            name: 'no_hp',
                            render: function (data) {
                                if (data == null)
                                    return '-';
                                else
                                    return data;
                            }
                        },
                        {data: 'alamat', name: 'alamat'},
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
        window.location.href = `{{ route('dashboard.manage-user.update', 'id') }}`.replace('id', id);
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
                    url: `{{ route('dashboard.manage-user.delete', ['id' => 'id']) }}`.replace('id', id),
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
