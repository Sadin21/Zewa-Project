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
                    <th scope="col">Sub Total</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($data as $d)
                    <tr class="border border-2">
                        <td>
                            <input class="form-check-input" type="checkbox" value="" id="check-{{ $d->id }}">
                        </td>
                        <td>
                            <div class="d-flex gap-3">
                                <img src="{{ url('/assets/imgs/product/' . $d->foto) }}" alt="" style="max-height: 70px; max-width: 70px; background-size: auto; border-radius: 0px;" class="">
                                <div class="my-auto">
                                    <h5 class="card-title poppins-medium fs-18">{{ $d->nama }}</h5>
                                    <p class="mb-0 poppins-regular fs-12">{{ $d->kode }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle card-title poppins-medium fs-18">{{ $d->waktu_sewa }}</td>
                        <td class="align-middle card-title poppins-medium fs-18">{{ $d->sub_total }}</td>
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
                        <p class="mb-0 poppins-medium fs-14">Rp 140.000</p>
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <div>
                        <p class="mb-0 poppins-medium fs-14">Produk</p>
                    </div>
                    <div class="text-end">
                        <p class="mb-0 poppins-medium fs-14">Macbook</p>
                        <p class="mb-0 poppins-medium fs-14">Pisau</p>
                    </div>
                </div>
                <a href="#" class="btn poppins-medium text-white fs-14 w-100 mt-4" style="background-color: #184A4B;">Bayar</a>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var checkAllCheckbox = document.getElementById('checkAll');

            var checkboxes = document.querySelectorAll('input[type="checkbox"]:not(#checkAll)');

            // add event listener to each checkbox except "checkAll"
            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    if (!this.checked) {
                        checkAllCheckbox.checked = false;
                    }
                    // Call the getCheckboxValue function whenever a checkbox is changed
                    getCheckboxValue();
                });
            });

            function getCheckboxValue() {
                var checkedValues = [];
                checkboxes.forEach(function(checkbox) {
                    if (checkbox.checked && checkbox !== checkAllCheckbox) {
                        var id = checkbox.id.substring(6);
                        checkedValues.push(id);
                    }
                });
                // console.log('Checked values:', checkedValues);
                return checkedValues;
            };

        });
    </script>
@endsection
