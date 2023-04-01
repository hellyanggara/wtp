@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ $title }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ URL::to('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Master</li>
                    <li class="breadcrumb-item active">Edit User</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert"
                        aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i> Success!</h5>
                    {{ Session::get('success') }}
                </div>
            @endif
            @if (Session::has('failed'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert"
                        aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i> Failed!</h5>
                    {{ Session::get('failed') }}
                </div>
            @endif
                <div class="card card-primary">
                    <div class="card-header">
                    <h3 class="card-title">Data</h3>
                        {{-- <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                            </button>
                        </div> --}}
                    </div>
                    <form action="{{ route('masters.users.update', [$user->id]) }}" method="post">
                    @csrf
                    @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Masukkan Nama User" value="{{ old('name',$user->name) }}" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Tanggal Lahir</label>
                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                    <input name="date_of_birth" type="text" class="form-control datetimepicker-input @error('date_of_birth') is-invalid @enderror" data-target="#reservationdate" value="{{ $user->date_of_birth ? old('date_of_birth', date("d-m-Y", strtotime($user->date_of_birth))) : '' }}" placeholder="Pilih tanggal"/>
                                    <div class="input-group-append" data-target="#reservationdate"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    @error('date_of_birth')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="Masukkan Email User" value="{{ old('email', $user->email) }}" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Hak Akses</label>
                                <select class="form-control select2 @error('role_id') is-invalid @enderror"
                                    name="role_id" style="width: 100%">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                            {{ strtoupper($role->name) }}</option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('masters.users.index') }}" class="btn btn-danger"><i class="fas fa-ban"></i> Batal</a>
                            <button type="submit" class="btn btn-primary float-right"><i class="fas fa-save"></i> Simpan</button>
                        </div>
                    </form>
                </div>
            <div class="col-md-6">
            </div>
        </div>
    </div>
</section>
<script>
    $(function() {
        $('.select2').select2();
        $('#reservationdatetime').datetimepicker({
            icons: {
                time: 'far fa-clock'
            },
            format: 'DD-MM-YYYY HH:mm'
        });
    });
</script>
@endsection