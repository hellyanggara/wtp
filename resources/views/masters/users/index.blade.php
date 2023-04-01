@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Daftar {{ $title }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Master</li>
                    <li class="breadcrumb-item active">User</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
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
    <div class="card">
        <div class="card-header">
            <a href="{{ route('masters.users.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah
            </a>
            <a href="{{ request()->has('archive') ? route('masters.users.index') : route('masters.users.index', 'archive') }}" class="btn btn-{{ request()->has('archive') ? 'warning' : 'outline-warning' }} btn-sm float-right">
                <i class="fas fa-trash"></i> Trash
            </a>
        </div>
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-center" width="5%">No.</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Hak Akses</th>
                        <th class="text-center" width="15%">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($users as $key=>$user)
                    <tr>
                        <td class="text-center">{{ $key+1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @foreach ($user->roles as $role)
                                {{ $role->name }}
                            @endforeach
                        </td>
                        <td class="text-center">
                            @if($user->trashed())
                                <button type="button" class="btn btn-secondary btn-sm mb-2" data-toggle="modal" data-target="#modal-restore{{ $user->id }}">
                                    <i class="fas fa-trash-restore"></i> Restore
                                </button>
                                <button type="button" class="btn btn-danger btn-sm mb-2" data-toggle="modal" data-target="#modal-delete-forever{{ $user->id }}">
                                    <i class="fas fa-trash-alt"></i> Delete Forever
                                </button>
                            @else
                                <button type="button" class="btn btn-info btn-sm mb-2" data-toggle="modal" data-target="#modal-reset{{ $user->id }}">
                                    <i class="fas fa-key">
                                    </i> Reset Password
                                </button>
                                <a href="{{ route('masters.users.edit',[$user->id]) }}" class="btn btn-warning btn-sm mb-2">
                                    <i class="fas fa-pencil"></i> Ubah
                                </a>
                                <button type="button" class="btn btn-danger btn-sm mb-2" data-toggle="modal" data-target="#modal-default{{ $user->id }}">
                                    <i class="fas fa-trash">
                                    </i> Hapus
                                </button>
                            @endif
                        </td>
                    </tr>
                    <div class="modal fade" id="modal-reset{{ $user->id }}">
                        <div class="modal-dialog">
                            <form action="{{ route('masters.resetPassword.update', $user->id) }}" method="post">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Konfirmasi Reset Password..!!</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Apakah anda yakin akan mereset password {{ $user->name }}?</p>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Reset</button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                            </form>
                        </div>
                    </div>
                    <div class="modal fade" id="modal-default{{ $user->id }}">
                        <div class="modal-dialog">
                            <form action="{{ route('masters.users.destroy', [$user]) }}" method="post">
                            @csrf
                            {{ method_field('DELETE') }}
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Konfirmasi..!!</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Apakah anda yakin akan menghapus data {{ $user->name }}?</p>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                            </form>
                        </div>
                    </div>
                    <div class="modal fade" id="modal-restore{{ $user->id }}">
                        <div class="modal-dialog">
                            <form action="{{ route('masters.users.restore', [$user->id]) }}" method="post">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Konfirmasi..!!</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Apakah anda yakin akan mengaktifkan data {{ $user->name }}?</p>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                    <button type="submit" class="btn btn-primary">Yes</button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                            </form>
                        </div>
                    </div>
                    <div class="modal fade" id="modal-delete-forever{{ $user->id }}">
                        <div class="modal-dialog">
                            <form action="{{ route('masters.users.delete_forever', [$user->id]) }}" method="post">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Konfirmasi..!!</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Apakah anda yakin akan menghapus selamanya data {{ $user->name }}?</p>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                    <button type="submit" class="btn btn-danger">Yes</button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                            </form>
                        </div>
                    </div>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
