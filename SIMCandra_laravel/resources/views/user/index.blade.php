@extends('layout.index')
@section('title', 'Daftar Pengguna')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-primary border-radius-lg pt-3 pb-2 d-flex justify-content-between align-items-center">
                    <h6 class="text-white text-capitalize ps-3">Data Pengguna</h6>
                    @if(Auth::user()->role === 'HRD')
                        <a href="{{ route('user.create') }}" class="btn btn-success text-white me-3">
                            <i class="material-symbols-rounded align-middle me-1">add</i> Tambah User
                        </a>
                    @endif
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0" id="userTable">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Username</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Role</th>
                                @if(Auth::user()->role === 'HRD')
                                <th class="text-secondary opacity-7">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $loop->iteration }}</p>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $user->name }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $user->username }}</p>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $user->role }}</p>
                                </td>
                                @if(Auth::user()->role === 'HRD')
                                <td class="align-middle">
                                    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-link text-dark text-gradient px-2 py-1 mb-0" data-toggle="tooltip" data-original-title="Edit user">
                                        <i class="material-symbols-rounded" style="font-size: 18px;">edit</i>
                                    </a>
                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger text-gradient px-2 py-1 mb-0" onclick="return confirm('Yakin ingin menghapus user ini?')" data-toggle="tooltip" data-original-title="Hapus user">
                                            <i class="material-symbols-rounded" style="font-size: 18px;">delete</i>
                                        </button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent
@endsection 