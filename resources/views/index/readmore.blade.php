@extends('layouts.index.app')

@section('title', 'Read More - ' . $berita->judul)

@section('content')

    <!-- Berita Detail -->
    <div class="class">
        <div class="container text-center"> <!-- Tambahkan text-center di container -->
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage">
                        <h2>{{ $berita->judul }}</h2>
                        <p><strong>Kategori: </strong>{{ $berita->kategori->kategori }}</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center"> <!-- Tambahkan justify-content-center -->
                <div class="col-md-8">
                    <img class="img-fluid mx-auto d-block" src="{{ asset('images/berita/' . $berita->gambar_utama) }}"
                    style="width: 350px; height: 450px;" alt="{{ $berita->judul }}" />
                    <p class="mt-3 text-center">{{ $berita->isi_berita }}</p> <!-- Pastikan teks juga rata tengah -->
                    <br><br>
                    <p><strong>Penulis: </strong>{{ $berita->penulis }}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- End Berita Detail -->

@endsection
