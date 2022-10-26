<table>
  <thead>
    <tr>
      <th colspan="16">Dinas Perpustakaan dan Arsip Daerah Kota Wakanda</th>
    </tr>
    <tr>
      <th colspan="16">{{ $setting->alamat }} Telp. {{ $setting->telpon }}, Fax. {{ $setting->telpon }}</th>
    </tr>
    <tr>
      <th colspan="16">website : www.simpusda.wakandakota.go.id, Email : {{ $setting->email }}</th>
    </tr>
    <tr>
      <th colspan="16">{{ $type }}</th>
    </tr>
    <tr>
      <th colspan="16">Per Pendaftaran Periode {{ $tgl_awal }} s/d {{ $tgl_akhir }}</th>
    </tr>
  </thead>
</table>

<table>
  <thead>
    <tr>
      <th><b>No</b></th>
      <th><b>Barcode</b></th>
      <th><b>Judul</b></th>
      <th><b>Pengarang</b></th>
      <th><b>Penerbit</b></th>
      <th><b>Tahun</b></th>
      <th><b>ISBN</b></th>
      <th><b>Posisi Rak / No. Punggung</b></th>
      <th><b>Kategori</b></th>
      <th><b>Lokasi</b></th>
      <th><b>Halaman</b></th>
      <th><b>Panjang</b></th>
      <th><b>Lebar</b></th>
      <th><b>Berat</b></th>
      <th><b>Status</b></th>
      <th><b>Harga</b></th>
    </tr>
  </thead>
  <tbody>
    @php
      $total_judul = 0;
      $total_exemplar = 0;
    @endphp
    @foreach ($books as $key => $value)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $value->code }}</td>
        <td>{{ $value->book->title }}</td>
        <td>{{ $value->book->author_name }}</td>
        <td>{{ $value->book->publisher_name }}</td>
        <td>{{ $value->book->year_publication }}</td>
        <td>{{ $value->book->isbn }}</td>
        <td>{{ $value->position }}</td>
        <td>{{ $value->book->category->kode }}</td>
        <td>{{ $value->location_name }}</td>
        <td>{{ $value->book->jumlah_halaman }}</td>
        <td>{{ $value->book->panjang }}</td>
        <td>{{ $value->book->lebar }}</td>
        <td>{{ $value->book->berat }}</td>
        <td>{{ $value->source_name }}</td>
        <td>{{ str_replace(",", ".", str_replace(".", "", $value->price)) }}</td>
      </tr>
    @endforeach
  </tbody>
</table>

<table>
  <tbody>
    <tr>
      <td align="right" colspan="16"><b>Banjarmasin, {{ $tgl_sekarang }}</b></td>
    </tr>
    <tr>
      <td align="right" colspan="16"><b>Penanggung Jawab</b></td>
    </tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr>
      <td align="right" colspan="16"><b>{{ $setting->pemangku }}</b></td>
    </tr>
    <tr>
      <td align="right" colspan="16"><b>NIP. {{ $setting->nip_pemangku }}</b></td>
    </tr>
  </tbody>
</table>