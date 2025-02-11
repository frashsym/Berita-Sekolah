@extends('layouts.admin.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>

        <!-- Content Row -->
        <div class="row">
            <!-- Approach -->
            <div class="card shadow mb-4 col-12">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Selamat Datang, Admin {{ $loggedInUser->name ?? 'Guest' }}
                    </h6>
                </div>
                <div class="card-body">
                    <p>Kelola sistem dengan mudah dan pantau semua aktivitas di satu tempat. Semoga harimu menyenangkan dan
                        produktif!.</p>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

@endsection
