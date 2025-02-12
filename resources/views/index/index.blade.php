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
                                                        <h3>{{ $berita->judul }}</h3> <!-- Tampilkan judul berita -->
                                                        <div class="link_btn">
                                                            <a class="read_more" href="">Read
                                                                More<span></span></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="banner_img">
                                                        <figure>
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
    <!-- about -->
    <br><br><br>
    <div class="about">
        <div class="container-fluid">
            <div class="row d_flex">
                <div class="col-md-6">
                    <div class="titlepage text_align_left">
                        <h2>About <br>NeperTimes</h2>
                        <p>
                            NeperTimes adalah sebuah platform berita digital yang lahir dari kreativitas dan dedikasi
                            sekelompok siswa jurusan Rekayasa Perangkat Lunak (RPL). Website ini dikembangkan sebagai bagian
                            dari tugas yang diberikan oleh guru jurusan, dengan tujuan tidak hanya memenuhi persyaratan
                            akademik, tetapi juga memberikan manfaat nyata bagi komunitas sekolah dan masyarakat luas.
                        </p>
                        <div class="link_btn">
                            <a class="read_more" href="{{ url('/about') }}">Read More</a>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end about -->
@endsection
