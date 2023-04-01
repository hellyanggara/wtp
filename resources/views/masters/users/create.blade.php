@extends('layouts.app')

@section('content')
    @include('components.content-header', ['lvl1' => 'Master', 'lvl2' => $title])
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Data Pengguna') }}</h3>
                        </div>
                        <form action="{{ route('masters.users.store') }}" method="post" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ __('Nama') }}</label>
                                            <input type="text" name="name"
                                                class="form-control @error('name') is-invalid @enderror"
                                                placeholder="Masukkan nama pengguna" value="{{ old('name') }}" autofocus>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>{{ __('Tanggal Lahir') }}</label>
                                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                                <input name="birth_date" type="text" class="form-control datetimepicker-input @error('birth_date') is-invalid @enderror" data-target="#reservationdate" value="{{ old('birth_date') }}" placeholder="Pilih tanggal lahir"/>
                                                <div class="input-group-append" data-target="#reservationdate"
                                                    data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                                @error('birth_date')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>{{ __('Email') }}</label>
                                            <input type="email" name="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                placeholder="Masukkan email pengguna" value="{{ old('email') }}" autofocus>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>{{ __('No. Telepon') }}</label>
                                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Masukkan No. Telepon" value="{{ old('phone') }}">
                                            @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>{{ __('Alamat') }}</label>
                                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" placeholder="Masukkan alamat">{{ old('address') }}</textarea>
                                            @error('address')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <center>
                                            <div class="form-group">
                                                <label>{{ __('Foto') }}</label>
                                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                                        <div class="fileupload-new thumbnail"  style="width: 200px; height: 200px;">
                                                            <img src="" alt="" />
                                                        </div>
                                                        <div class="fileupload-preview fileupload-exists thumbnail"
                                                            style="max-width: 200px; max-height: 200px; line-height: 20px;"></div>
                                                        <div>
                                                            <span class="btn btn-default btn-file">
                                                                <span class="fileupload-new"><i class="fa fa-camera"></i> {{ __('Tambah Foto') }}</span>
                                                                <span class="fileupload-exists"><i class="fa fa-undo"></i>
                                                                    {{ __('Ubah') }}</span>
                                                                <input type="file" class="default @error('image') is-invalid @enderror" name="image" />
                                                                @error('image')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </span>
                                                            <a href="#" class="btn btn-danger fileupload-exists"
                                                                data-dismiss="fileupload"><i class="fa fa-trash"></i> {{ __('Batalkan') }}</a>
                                                        </div>
                                                    </div>
                                                    @error('price')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                        </center>
                                        <div class="form-group">
                                            <label>{{ __('Hak Akses') }}</label>
                                            <select class="form-control select2 @error('role_name') is-invalid @enderror"
                                                name="role_name" style="width: 100%">
                                                <option value="">--Silahkan Pilih--</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}"
                                                        {{ old('role_name') == $role->id ? 'selected' : '' }}>
                                                        {{ ucfirst($role->name) }}</option>
                                                @endforeach
                                            </select>
                                            @error('role_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('masters.users.index') }}" class="btn btn-danger"><i
                                        class="fas fa-ban"></i> {{ __('Batal') }}</a>
                                <button type="button" class="btn btn-primary float-right save_confirm"><i class="fas fa-save"></i>
                                    {{ __('Simpan') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
    <script>
        $('.save_confirm').click(function(event) {
            var form =  $(this).closest("form");
            event.preventDefault();
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Anda akan menyimpan data ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, simpan!',
                cancelButtonText: 'Tidak, Batalkan!'
                }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }else if (result.isDismissed) {
                    Swal.fire('Penyimpanan dibatalkan', '', 'info')
                }
            })
        });
    </script>
@endpush
