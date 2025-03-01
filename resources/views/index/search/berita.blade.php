@extends('layouts.index.app')

@section('title', 'Hasil Pencarian: ' . $query)

@section('content')

    <div class="class">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage text_align_center">
                        <h2>Hasil Pencarian untuk: "{{ $query }}"</h2>
                    </div>
                </div>
            </div>
            <div class="row" id="beritaContainer">
                @if ($berita->isEmpty())
                    <div class="col-md-12 text_align_center">
                        <p>Tidak ada hasil yang ditemukan.</p>
                    </div>
                @else
                    @foreach ($berita as $item)
                        <div class="col-md-4 margi_bottom">
                            <a class="read_more" href="{{ route('readmore', $item->id) }}">
                                <div class="class_box text_align_center">
                                    <i><img src="{{ asset('images/berita/' . $item->gambar_utama) }}"
                                            alt="{{ $item->judul }}" /></i>
                                    <h3>{{ $item->judul }}</h3>
                                    <p>{{ Str::limit($item->isi_berita, 100) }}</p>
                                    <p class="mt-2" style="color: #f0f0f0; font-size: 14px; font-style: italic;">
                                        {{ \Carbon\Carbon::parse($item->created_at)->setTimezone('Asia/Jakarta')->locale('id')->diffForHumans() }}
                                    </p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

@endsection
