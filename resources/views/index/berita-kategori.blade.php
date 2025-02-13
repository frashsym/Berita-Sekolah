@extends('layouts.index.app')

@section('title', 'Kategori: ' . $kategori->kategori)

@section('content')

    <!-- Berita Berdasarkan Kategori -->
    <div class="class">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage text_align_center">
                        <h2>Berita Kategori: {{ $kategori->kategori }}</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @if ($berita->isEmpty())
                    <div class="col-md-12 text_align_center">
                        <p>Tidak ada berita dalam kategori ini.</p>
                    </div>
                @else
                    @foreach ($berita as $item)
                        <div class="col-md-4 margi_bottom">
                            <div class="class_box text_align_center">
                                <img class="img-fluid" src="{{ asset('images/berita/' . $item->gambar_utama) }}"
                                    alt="{{ $item->judul }}">
                                <h3>{{ $item->judul }}</h3>
                                <p>{{ Str::limit($item->isi_berita, 100) }}</p>
                            </div>
                            <a class="read_more" href="{{ url('/readmore/' . $item->id) }}">Read More</a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <!-- End Berita Berdasarkan Kategori -->

@endsection
