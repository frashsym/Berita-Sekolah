@extends('layouts.index.app')

@section('title', 'NeperTimes')

@section('content')

    <!-- top -->
    <div class="full_bg">
        <div class="slider_main">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- carousel code -->
                        <div id="carouselExampleIndicators" class="carousel slide">
                            <ol class="carousel-indicators">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner">
                                @foreach ($beritaTerbaru as $key => $berita)
                                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                        <div class="carousel-caption relative">
                                            <div class="row d_flex">
                                                <div class="col-md-5">
                                                    <div class="board">
                                                        <!-- Tampilkan judul berita -->
                                                        <h3 class="">{{ $berita->judul }}</h3>

                                                        <!-- Tambahkan informasi waktu pembuatan -->
                                                        <p class="text-muted">
                                                            {{ \Carbon\Carbon::parse($berita->created_at)->setTimezone('Asia/Jakarta')->locale('id')->diffForHumans() }}
                                                        </p>
                                                        <br>
                                                        <div class="link_btn">
                                                            <a class="read_more"
                                                                href="{{ route('readmore', $berita->id) }}">
                                                                Lihat lebih<span></span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-7 d-flex flex-column">
                                                    <div class="banner_img">
                                                        <figure class="d-flex flex-column align-items-end mr-5">
                                                            <br><br>
                                                            <img class="img_responsive"
                                                                style="max-width: 60%; height: 60%; object-fit: cover;"
                                                                src="{{ asset('images/berita/' . $berita->gambar_utama) }}"
                                                                alt="{{ $berita->judul }}">
                                                        </figure>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <br>
                            <!-- controls -->
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                                data-slide="prev">
                                <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                                data-slide="next">
                                <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end banner -->
    
    <!-- Berita Lainnya -->
    <div class="class">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage text_align_center">
                        <h2>Berita Lainnya</h2>
                        <p>NeperTimes kini hadir dengan menyajikan berita terbaru.</p>
                    </div>
                </div>
            </div>

            <div class="row" id="beritaContainer">
                @foreach ($beritaLainnya as $berita)
                    <div class="col-md-4 margi_bottom">
                        <a class="read_more" href="{{ route('readmore', $berita->id) }}">
                            <div class="class_box text_align_center">
                                <i><img src="{{ asset('images/berita/' . $berita->gambar_utama) }}"
                                        alt="{{ $berita->judul }}" /></i>
                                <h3>{{ $berita->judul }}</h3>
                                <p>{{ Str::limit($berita->isi_berita, 100) }}</p>
                                <br>
                                <p class="mt-2" style="color: #f0f0f0; font-size: 14px; font-style: italic;">
                                    {{ \Carbon\Carbon::parse($berita->created_at)->setTimezone('Asia/Jakarta')->locale('id')->diffForHumans() }}
                                </p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="link_btn">
                <a class="read_more" id="loadMoreBtn" data-page="1">
                    Lihat lebih<span></span>
                </a>
            </div>
        </div>
    </div>
    <!-- End Berita Lainnya -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#loadMoreBtn').on('click', function(e) {
                e.preventDefault();

                let button = $(this);
                let page = button.data('page');

                $.ajax({
                    url: "{{ route('berita.more') }}",
                    type: "GET",
                    data: {
                        page: page
                    },
                    beforeSend: function() {
                        button.text('Memuat...');
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#beritaContainer').append(response.data);

                            if (response.nextPage) {
                                button.data('page', response.nextPage);
                                button.text('Lihat lebih');
                            } else {
                                button
                                    .remove(); // Hapus tombol jika sudah tidak ada berita lagi
                            }
                        } else {
                            alert('Gagal memuat berita');
                        }
                    },
                    error: function() {
                        alert('Terjadi kesalahan, coba lagi.');
                    }
                });
            });
        });
    </script>

@endsection
