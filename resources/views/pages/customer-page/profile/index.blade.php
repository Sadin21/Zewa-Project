@extends('layouts.landing-app')

@section('content')
<section>
    <h5 class="poppins-semibold">Edit Data Profil</h5>
    <form action="{{ route('profile.update') }}" method="POST"  enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-2">
                {{-- <div class="flex-grow-1 d-flex gap-3">
                    <div>
                        <input type="file" name="foto" id="foto" class="d-none" />
                        <label for="foto" class="img-selector pc-logo">
                            <ion-icon name="add"></ion-icon>
                        </label>
                    </div>
                    <div id="img-preview" style="width: 135px; height: 60px">
                        <img src="/assets/imgs/{{ isset($user) ? $user->foto : '' }}" class="img-fluid border border-2 border-primary rounded" alt="">
                    </div>
                </div> --}}


                <div>
                    <input type="file" name="foto" id="foto" class="d-none" />
                    <div class="">
                        <label for="foto" style="border: 1px solid grey" class="img-selector pc-logo mb-2">
                            <i class="fa-solid fa-plus"></i>
                        </label>
                        <div id="img-preview" style="width: 135px; height: 60px">
                            <img src="/assets/imgs/user/{{ isset($user) ? $user->foto : '' }}" class="img-fluid border border-2 border-primary rounded" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="mb-3">
                    <label class="form-label fs-14 poppins-medium dark-green">Nama</label>
                    <input name="nama" type="text" class="form-control" aria-describedby="emailHelp" value="{{ isset($user) ? $user->nama : '' }}"   placeholder="">
                </div>
                <div class="mb-3">
                    <label class="form-label fs-14 poppins-medium dark-green">Role</label>
                    <input name="role_id" type="text" class="form-control" readonly aria-describedby="emailHelp" value="{{ isset($user) ? $user->role_id : '' }}"   placeholder="">
                </div>
                <div class="mb-3">
                    <label class="form-label fs-14 poppins-medium dark-green">Alamat</label>
                    <textarea class="form-control" name="alamat" placeholder="Tuliskan alamat">{{ isset($user) ? $user->alamat : '' }}</textarea>
                </div>
            </div>
            <div class="col">
                <div class="mb-3">
                    <label class="form-label fs-14 poppins-medium dark-green">Email</label>
                    <input name="email" type="email" class="form-control" aria-describedby="emailHelp" value="{{ isset($user) ? $user->email : '' }}"   placeholder="">
                </div>
                <div class="mb-3">
                    <label class="form-label fs-14 poppins-medium dark-green">Password</label>
                    <input name="password" type="password" class="form-control" aria-describedby="emailHelp" value=""   placeholder="Tulis Password">
                </div>
            </div>
            <div class="text-end my-4">
                <button type="submit" class="btn bg-medium-green poppins-medium text-white fs-14 py-2" style="background-color: #00A3A8;">Simpan</button>
            </div>
        </div>
    </form>
</section>
@endsection

@section('script')
{{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script> --}}

    <script>
        function generateCode() {
            const codeInput = document.getElementById("kode");
            const length = 6;

            const randomCode = Array.from({ length }, () => {
                const charset = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
                const randomIndex = Math.floor(Math.random() * charset.length);
                return charset[randomIndex];
            }).join("");

            codeInput.value = randomCode;
        }
    </script>
    <script>
        const chooseFile = document.getElementById("foto");
        const imgPreview = document.getElementById("img-preview");

        chooseFile.addEventListener("change", function () {
            getImgData();
        });

        function getImgData() {
            const files = chooseFile.files[0];
            if (files) {
                const fileReader = new FileReader();
                fileReader.readAsDataURL(files);
                fileReader.addEventListener("load", function () {
                    let imgElement = document.createElement("img");
                    imgElement.setAttribute("src", this.result);
                    imgElement.setAttribute("class", "img-fluid border border-2 border-primary rounded");
                    imgPreview.innerHTML = "";
                    imgPreview.appendChild(imgElement);
                });
            }
        }
    </script>
@endsection
