@extends('layouts.app')

@section('content')
@include('components.content-header', ['lvl1' => 'Master', 'lvl2' => $title])
<section class="content">
    <div class="card">
        <div class="card-header">
            <a href="{{ route('masters.users.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> {{ __('Tambah') }}
            </a>
            <a href="{{ request()->has('archive') ? route('masters.users.index') : route('masters.users.index', 'archive') }}" class="btn btn-{{ request()->has('archive') ? 'dark' : 'light' }} btn-sm float-right">
                <i class="fas fa-trash"></i> {{ __('Trash') }}
            </a>
        </div>
        <div class="card-body">
            <table id="example1" class="table table-bordered wrap table-striped projects">
                <thead>
                    <tr>
                        <th class="text-center" width="5%">{{ __('No.') }}</th>
                        <th class="text-center">{{ __('Foto') }}</th>
                        <th class="text-center">{{ __('Nama') }}</th>
                        <th class="text-center">{{ __('Hak Akses') }}</th>
                        <th class="text-center">{{ __('Tenant') }}</th>
                        <th class="text-center">{{ __('No.Telepon') }}</th>
                        <th class="text-center">{{ __('Email') }}</th>
                        <th class="text-center">{{ __('Alamat') }}</th>
                        <th class="text-center" width="15%">{{ __('Aksi') }}</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>
                            <center>
                                @if ($user->image != null)
                                <img alt="Avatar" class="table-avatar" src="{{ asset('storage/'. $user->image) }}">
                                @else
                                <i class="fas fa-user"></i>
                                @endif
                            </center>
                        </td>
                        <td>{{ $user->name }}</td>
                        <td>
                            @foreach ($user->roles as $role)
                            {{ $role->name }}
                            @endforeach
                        </td>
                        <td>{{ $user->tenants->name ?? '' }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->address }}</td>
                        <td class="text-center">
                            @if($user->trashed())
                                <form action="{{ route('masters.users.restore', [$user->id]) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <button type="button" class="btn btn-secondary btn-sm mb-2 restore_confirm" data-user="{{ $user->name }}">
                                        <i class="fas fa-trash-restore"></i> {{ __('Kembalikan') }}
                                    </button>
                                </form>
                                <form action="{{ route('masters.users.delete_forever', [$user->id]) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <button type="button" class="btn btn-danger btn-sm mb-2 delete_forever_confirm" data-user="{{ $user->name }}">
                                        <i class="fas fa-trash-alt"></i> {{ __('Hapus Selamanya') }}
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('masters.resetPassword.update', $user->id) }}" method="post">
                                @csrf
                                @method('PUT')
                                    <button type="button" data-user="{{ $user->name }}" class="btn btn-info btn-sm mb-2 reset_confirm">
                                        <i class="fas fa-key">
                                        </i> {{ __('Reset Password') }}
                                    </button>
                                </form>
                                <a href="{{ route('masters.users.edit',[$user->id]) }}" class="btn btn-warning btn-sm mb-2">
                                    <i class="fas fa-pencil"></i> {{ __('Ubah') }}
                                </a>
                                <form action="{{ route('masters.users.destroy', [$user]) }}" method="post">
                                @csrf
                                {{ method_field('DELETE') }}
                                    <button type="button" data-user="{{ $user->name }}" class="btn btn-danger btn-sm mb-2 delete_confirm">
                                        <i class="fas fa-trash">
                                        </i> {{ __('Hapus') }}
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
@push('script')
    <script>
        $('.delete_confirm').click(function(event) {
            var form = $(this).closest("form");
            var name = $(this).data("user");
            event.preventDefault();
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Anda akan menghapus data "+name+"!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Tidak, batalkan'
                }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }else if (result.isDismissed) {
                    Swal.fire('Penghapusan dibatalkan', '', 'info')
                }
            })
        });
        
        $('.reset_confirm').click(function(event) {
            var form = $(this).closest("form");
            var name = $(this).data("user");
            event.preventDefault();
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Anda akan mereset password "+name+"!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, reset!',
                cancelButtonText: 'Tidak, batalkan'
                }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }else if (result.isDismissed) {
                    Swal.fire('Reset password dibatalkan', '', 'info')
                }
            })
        });

        $('.restore_confirm').click(function(event) {
            var form = $(this).closest("form");
            var name = $(this).data("user");
            event.preventDefault();
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Anda akan mengaktifkan kembali data "+name+"!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, aktifkan kembali!',
                cancelButtonText: 'Tidak, batalkan'
                }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }else if (result.isDismissed) {
                    Swal.fire('Pengaktifan pengguna dibatalkan', '', 'info')
                }
            })
        });
        
        $('.delete_forever_confirm').click(function(event) {
            var form = $(this).closest("form");
            var name = $(this).data("user");
            event.preventDefault();
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Anda akan menghapus data "+name+"!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Tidak, batalkan'
                }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }else if (result.isDismissed) {
                    Swal.fire('Penghapusan pengguna dibatalkan', '', 'info')
                }
            })
        });
    </script>
@endpush
