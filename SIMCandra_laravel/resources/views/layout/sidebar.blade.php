<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand px-4 py-3 m-0" href="{{ route('dashboard') }}">
        {{-- Ganti dengan logo atau teks SIM Candra --}}
        <img src="{{ asset('template/logo.png') }}" class="navbar-brand-img" width="26" height="26" alt="main_logo">
        <span class="ms-1 text-sm text-dark">Sungai Budi</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        {{-- Item Menu Dashboard --}}
        @if(Auth::check() && in_array(Auth::user()->role, ['HRD', 'Kepala Unit', 'Karyawan']))
        <li class="nav-item">
          <a class="nav-link text-dark {{ Request::routeIs('dashboard') ? 'active bg-gradient-dark text-white' : '' }}" href="{{ route('dashboard') }}">
            <i class="material-symbols-rounded opacity-5">dashboard</i>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        @endif

        {{-- Item Menu Data Pegawai (Akses: HRD, Kepala Unit) --}}
        @if(Auth::check() && in_array(Auth::user()->role, ['HRD', 'Kepala Unit']))
        <li class="nav-item">
          <a class="nav-link text-dark {{ Request::routeIs('pegawai.index') ? 'active bg-gradient-dark text-white' : '' }}" href="{{ route('pegawai.index') }}">
            <i class="material-symbols-rounded opacity-5">group</i>
            <span class="nav-link-text ms-1">Data Pegawai</span>
          </a>
        </li>
        @endif
        {{-- Item Menu Absensi (Akses: HRD, Kepala Unit, Karyawan) --}}
        @if(Auth::check() && in_array(Auth::user()->role, ['HRD', 'Kepala Unit', 'Karyawan']))
        <li class="nav-item">
          <a class="nav-link text-dark {{ Request::routeIs('absensi.index') || Request::routeIs('absensi.create') || Request::routeIs('absensi.show') || Request::routeIs('absensi.edit') ? 'active bg-gradient-dark text-white' : '' }}" href="{{ route('absensi.index') }}">
              <i class="material-symbols-rounded opacity-5">event_note</i>
              <span class="nav-link-text ms-1">Presensi</span>
          </a>
        </li>
        @endif

        {{-- Item Menu Cuti/Izin (Akses: HRD, Kepala Unit, Karyawan) --}}
        @if(Auth::check() && in_array(Auth::user()->role, ['HRD', 'Kepala Unit', 'Karyawan']))
        <li class="nav-item">
          <a class="nav-link text-dark {{ Request::routeIs('cuti.index') ? 'active bg-gradient-dark text-white' : '' }}" href="{{ route('cuti.index') }}">
              <i class="material-symbols-rounded opacity-5">calendar_month</i>
              <span class="nav-link-text ms-1">Cuti/Izin</span>
          </a>
        </li>
        @endif
          {{-- Item Menu Lowongan untuk Calon Karyawan --}}
          @if(Auth::check() && Auth::user()->role === 'Calon Karyawan')
          <li class="nav-item">
             <a class="nav-link text-dark {{ Request::routeIs('rekrutmen.index') ? 'active bg-gradient-dark text-white' : '' }}" href="{{ route('rekrutmen.index') }}">
                 <i class="material-symbols-rounded opacity-5">work</i>
                 <span class="nav-link-text ms-1">Lowongan</span>
             </a>
         </li>
         <li class="nav-item">
             <a class="nav-link text-dark {{ Request::routeIs('lamaran.index') ? 'active bg-gradient-dark text-white' : '' }}" href="{{ route('lamaran.index') }}">
                 <i class="material-symbols-rounded opacity-5">description</i>
                 <span class="nav-link-text ms-1">Lamaran</span>
             </a>
         </li>
           @endif

          {{-- Item Menu Lowongan/Rekrutmen (Akses: HRD, Kepala Unit) --}}
          @if(Auth::check() && in_array(Auth::user()->role, ['HRD', 'Kepala Unit']))
         <li class="nav-item">
              <a class="nav-link text-dark {{ Request::routeIs('rekrutmen.index') ? 'active bg-gradient-dark text-white' : '' }}" href="{{ route('rekrutmen.index') }}">
                  <i class="material-symbols-rounded opacity-5">person_add</i>
                  <span class="nav-link-text ms-1">Rekrutmen</span>
              </a>
        </li>
          @endif

          {{-- Item Menu Lamaran (Akses: HRD, Kepala Unit) --}}
          @if(Auth::check() && in_array(Auth::user()->role, ['HRD', 'Kepala Unit']))
          <li class="nav-item">
              <a class="nav-link text-dark {{ Request::routeIs('lamaran.index') ? 'active bg-gradient-dark text-white' : '' }}" href="{{ route('lamaran.index') }}">
                  <i class="material-symbols-rounded opacity-5">description</i>
                  <span class="nav-link-text ms-1">Lamaran</span>
              </a>
          </li>
          @endif

         {{-- Item Menu Mutasi (Akses: HRD, Kepala Unit, Karyawan) --}}
        @if(Auth::check() && in_array(Auth::user()->role, ['HRD', 'Kepala Unit', 'Karyawan']))
        <li class="nav-item">
            <a class="nav-link text-dark {{ Request::routeIs('mutasi.index') ? 'active bg-gradient-dark text-white' : '' }}" href="{{ route('mutasi.index') }}">
                <i class="material-symbols-rounded opacity-5">sync_alt</i>
                <span class="nav-link-text ms-1">Promosi/Demosi</span>
            </a>
        </li>
        @endif

         {{-- Item Menu Pengguna (Akses: HRD, Kepala Unit) --}}
        @if(Auth::check() && in_array(Auth::user()->role, ['HRD', 'Kepala Unit']))
        <li class="nav-item">
            <a class="nav-link text-dark {{ Request::routeIs('user.index') ? 'active bg-gradient-dark text-white' : '' }}" href="{{ route('user.index') }}">
                <i class="material-symbols-rounded opacity-5">manage_accounts</i>
                <span class="nav-link-text ms-1">Pengguna</span>
            </a>
        </li>
        @endif

         {{-- Item Menu Promosi (Akses: HRD, Kepala Unit, Karyawan) --}}
        @if(Auth::check() && in_array(Auth::user()->role, ['HRD', 'Kepala Unit', 'Karyawan']))
         {{-- <li class="nav-item">
            <a class="nav-link text-dark {{ Request::routeIs('promosi.index') ? 'active bg-gradient-dark text-white' : '' }}" href="{{ route('promosi.index') }}">
                <i class="material-symbols-rounded opacity-5">trending_up</i>
                <span class="nav-link-text ms-1">Promosi</span>
            </a>
        </li> --}}
        @endif

         {{-- Item Menu PHK (Akses: HRD, Kepala Unit, Karyawan) --}}
        @if(Auth::check() && in_array(Auth::user()->role, ['HRD', 'Kepala Unit', 'Karyawan']))
        <li class="nav-item">
            <a class="nav-link text-dark {{ Request::routeIs('phk.index') || Request::routeIs('phk.create') || Request::routeIs('phk.edit') || Request::routeIs('phk.show') ? 'active bg-gradient-dark text-white' : '' }}" href="{{ route('phk.index') }}">
                <i class="material-symbols-rounded opacity-5">person_remove</i>
                <span class="nav-link-text ms-1">PHK</span>
            </a>
        </li>
        @endif

        {{-- Item Menu Departemen (Akses: HRD) --}}
        @if(Auth::check() && in_array(Auth::user()->role, ['HRD', 'Kepala Unit']))
        <li class="nav-item">
            <a class="nav-link text-dark {{ Request::routeIs('departemen.index') ? 'active bg-gradient-dark text-white' : '' }}" href="{{ route('departemen.index') }}">
                <i class="material-symbols-rounded opacity-5">apartment</i>
                <span class="nav-link-text ms-1">Departemen</span>
            </a>
        </li>
        @endif

        {{-- Item Menu Reward & Punishment (Akses: HRD, Kepala Unit, Karyawan) --}}
        @if(Auth::check() && in_array(Auth::user()->role, ['HRD', 'Kepala Unit', 'Karyawan']))
        <li class="nav-item">
            <a class="nav-link text-dark {{ Request::routeIs('rewardpunishment.index') ? 'active bg-gradient-dark text-white' : '' }}" href="{{ route('rewardpunishment.index') }}">
                <i class="material-symbols-rounded opacity-5">emoji_events</i>
                <span class="nav-link-text ms-1">Reward & Punishment</span>
            </a>
        </li>
        @endif

        {{-- Item Menu Resign (Akses: HRD, Kepala Unit, Karyawan) --}}
        @if(Auth::check() && in_array(Auth::user()->role, ['HRD', 'Kepala Unit', 'Karyawan']))
        <li class="nav-item">
            <a class="nav-link text-dark {{ Request::routeIs('resign.index') || Request::routeIs('resign.create') || Request::routeIs('resign.edit') || Request::routeIs('resign.show') ? 'active bg-gradient-dark text-white' : '' }}" href="{{ route('resign.index') }}">
                <i class="material-symbols-rounded opacity-5">logout</i>
                <span class="nav-link-text ms-1">Resign</span>
            </a>
        </li>
        @endif
      </ul>
    </div>
</aside> 