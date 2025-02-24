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
                                                        <h3 class="">{{ $berita->judul }}</h3> <!-- Tampilkan judul berita -->
                                                        <div class="link_btn">
                                                            <a class="read_more" href="{{ route('readmore', $berita->id) }}">
                                                                Read More<span></span></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-7 d-flex flex-column">
                                                    <div class="banner_img">
                                                        <figure class="d-flex flex-column align-items-end mr-5">
                                                            <img class="img_responsive" style="width: 500px; height: 600px;"
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
            <div class="row">
                @foreach ($beritaLainnya as $berita)
                    <div class="col-md-4 margi_bottom">
                        <div class="class_box text_align_center">
                            <i><img src="{{ asset('images/berita/' . $berita->gambar_utama) }}"
                                    alt="{{ $berita->judul }}" /></i>
                            <h3>{{ $berita->judul }}</h3>
                            <p>{{ Str::limit($berita->isi_berita, 100) }}</p>
                        </div>
                        <a class="read_more" href="{{ route('readmore', $berita->id) }}">Read More</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- End Berita Lainnya -->
@endsection
