@foreach ($beritaLainnya as $berita)
    <div class="col-md-4 margi_bottom">
        <a class="read_more" href="{{ route('readmore', $berita->id) }}">
            <div class="class_box text_align_center">
                <i><img src="{{ asset('images/berita/' . $berita->gambar_utama) }}" alt="{{ $berita->judul }}" /></i>
                <h3>{{ $berita->judul }}</h3>
                <p>{{ Str::limit($berita->isi_berita, 100) }}</p>
            </div>
        </a>
    </div>
@endforeach
