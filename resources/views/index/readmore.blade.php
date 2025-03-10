@extends('layouts.index.app')

@section('title', 'Baca - ' . $berita->judul)

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
                        style="width: auto; height: 450px;" alt="{{ $berita->judul }}" />
                    <p class="mt-3 text-center">{{ $berita->isi_berita }}</p> <!-- Pastikan teks juga rata tengah -->
                    <br><br>
                    <p>
                        <strong>{{ $berita->penulis }}</strong><br>
                        <br>
                        <br>
                        <span>Dilihat: {{ $berita->views }}</span><br>
                        <span>{{ $berita->tanggal_publikasi }}</span>
                        <span>{{ $berita->jam_publikasi }}</span>
                    <div class="average-rating">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= round($berita->rating))
                                <span class="star-rating">&#9733;</span> <!-- Filled star -->
                            @else
                                <span class="star-rating">&#9734;</span> <!-- Empty star -->
                            @endif
                        @endfor
                        ({{ number_format($berita->rating) }} / 5)
                    </div>
                    </p>
                </div>
                <form id="commentForm" class="form_subscri" action="{{ route('komentar') }}" method="POST">
                    <br><br>
                    @csrf
                    <input type="hidden" name="berita_id" value="{{ $berita->id }}">

                    <h1><strong>Berikan ulasan Anda</strong></h1>
                    
                    <div class="row justify-content-center text-center">
                        <div class="col-md-12">
                            <br><br><br>
                            <input class="newsl" placeholder="Nama Anda" type="text" name="nama" required>
                            <input class="newsl" placeholder="Berikan ulasan Anda" type="text" name="isi_komentar">
                        </div>
                        <div class="col-md-12 rating-container">
                            <label for="rating">Rating:</label>
                            <div class="rating">
                                <input type="radio" id="star5" name="rating" value="5"><label
                                    for="star5">&#9733;</label>
                                <input type="radio" id="star4" name="rating" value="4"><label
                                    for="star4">&#9733;</label>
                                <input type="radio" id="star3" name="rating" value="3"><label
                                    for="star3">&#9733;</label>
                                <input type="radio" id="star2" name="rating" value="2"><label
                                    for="star2">&#9733;</label>
                                <input type="radio" id="star1" name="rating" value="1"><label
                                    for="star1">&#9733;</label>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <button class="subsci_btn" type="submit">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage">
                        <br>
                        <h2>Ulasan</h2>
                    </div>
                </div>
            </div>
            <div id="commentList">
                @if ($berita->comments->isEmpty())
                    <p class="text-center text-muted">Belum ada ulasan. Jadilah yang pertama!</p>
                @else
                    @foreach ($berita->comments as $comment)
                        <div class="comment-box">
                            <strong>{{ $comment->nama }}</strong>
                            <span>({{ $comment->tanggal_komentar }} - {{ $comment->jam_komentar }})</span>
                            @if ($comment->isi_komentar)
                                <p>{{ $comment->isi_komentar }}</p>
                            @endif
                            <div class="star-rating">
                                @if ($comment->rating)
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $comment->rating)
                                            &#9733; <!-- Filled star -->
                                        @else
                                            &#9734; <!-- Empty star -->
                                        @endif
                                    @endfor
                                @else
                                    <p>Tidak ada rating</p>
                                @endif
                            </div>
                            <hr>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <!-- End Berita Detail -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#commentForm').on('submit', function(e) {
                e.preventDefault(); // Mencegah reload halaman
                let rating = $('input[name="rating"]:checked').val() || '';
                let formData = $(this).serialize() + '&rating=' + rating;

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {

                            // Kosongkan form setelah berhasil
                            $('input[name="nama"]').val('');
                            $('input[name="isi_komentar"]').val('');
                            $('input[name="rating"]').prop('checked', false);

                            // Hapus pesan "Belum ada ulasan" jika ada komentar baru
                            $('#commentList p.text-muted').remove();

                            // Kosongkan form setelah berhasil
                            $('#commentForm')[0].reset();

                            // Buat elemen rating bintang
                            let starRating = '';
                            if (response.data.rating) {
                                for (let i = 1; i <= 5; i++) {
                                    if (i <= response.data.rating) {
                                        starRating += '&#9733; '; // Filled star
                                    } else {
                                        starRating += '&#9734; '; // Empty star
                                    }
                                }
                            } else {
                                starRating = '<p>Tidak ada rating</p>';
                            }

                            // Tambahkan komentar baru ke daftar komentar tanpa reload
                            $('#commentList').prepend(`
                                <div class="comment-box">
                                    <div class="comment-header" style="display: flex; align-items: center; gap: 10px;">
                                        <strong>${response.data.nama}</strong> 
                                        <span>(${response.data.tanggal_komentar} - ${response.data.jam_komentar})</span>
                                    <div class="star-rating">${starRating}</div>
                                    </div>
                                <p>${response.data.isi_komentar ? response.data.isi_komentar : ''}</p>
                                <hr>
                                </div>
                        `);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Terjadi kesalahan, coba lagi.'
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Wajib memberikan rating.'
                        });
                    }
                });
            });
        });
    </script>

@endsection
