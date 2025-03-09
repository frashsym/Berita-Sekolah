@extends('layouts.index.app')

@section('title', 'Kategori Berita NeperTimes')

@section('content')

    <!-- Kategori Berita -->
    <div class="class">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage text_align_center">
                        <h2>Kategori Berita</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($kategoris as $kategori)
                    <div class="col-md-4 margi_bottom">
                        <a href="{{ route('berita.kategori', $kategori->id) }}" class="text-decoration-none">
                            <div class="class_box text_align_center">
                                <h3>{{ $kategori->kategori }}</h3>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- End Kategori Berita -->

@endsection
