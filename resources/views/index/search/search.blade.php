@extends('layouts.index.app')

@section('title', 'Hasil Pencarian')

@section('content')
    <h2>Hasil Pencarian untuk: "{{ $query }}"</h2>

    @if ($berita->isEmpty())
        <p>Tidak ada hasil yang ditemukan.</p>
    @else
        @foreach ($berita as $item)
            <div class="berita-item">
                <h3><a href="{{ route('berita.show', $item->id) }}">{{ $item->judul }}</a></h3>
                <p><strong>Kategori:</strong> {{ $item->kategori->kategori }}</p>
                <p>{{ Str::limit($item->isi_berita, 150) }}</p> <!-- Tampilkan 150 karakter pertama -->
            </div>
        @endforeach
    @endif
@endsection
