<table>
  <thead>
    <tr>
      <th colspan="4">Dinas Perpustakaan dan Arsip Daerah Kota Wakanda</th>
    </tr>
    <tr>
      <th colspan="4">{{ $setting->alamat }} Telp. {{ $setting->telpon }}, Fax. {{ $setting->telpon }}</th>
    </tr>
    <tr>
      <th colspan="4">website : www.simpusda.wakandakota.go.id, Email : {{ $setting->email }}</th>
    </tr>
    <tr>
      <th colspan="4">{{ $type }}</th>
    </tr>
    <tr>
      <th colspan="4">Per Pendaftaran Periode {{ $tgl_awal }} s/d {{ $tgl_akhir }}</th>
    </tr>
  </thead>
</table>

<table>
  <thead>
    <tr>
      <th><b>No</b></th>
      <th><b>Kategori</b></th>
      <th><b>Jumlah Judul</b></th>
      <th><b>Jumlah Eksemplar</b></th>
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
        <td>{{ $value->category }}</td>
        <td>{{ $value->total_judul }}</td>
        <td>{{ $value->total_exemplar }}</td>
      </tr>
      @php
        $total_judul += $value->total_judul;
        $total_exemplar += $value->total_exemplar;
      @endphp
    @endforeach
    <tr>
      <td colspan="2"><b>Total</b></td>
      <td><b>{{ $total_judul }}</b></td>
      <td><b>{{ $total_exemplar }}</b></td>
    </tr>
  </tbody>
</table>

<table>
  <tbody>
    <tr>
      <td align="right" colspan="4"><b>Banjarmasin, {{ $tgl_sekarang }}</b></td>
    </tr>
    <tr>
      <td align="right" colspan="4"><b>Penanggung Jawab</b></td>
    </tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr>
      <td align="right" colspan="4"><b>{{ $setting->pemangku }}</b></td>
    </tr>
    <tr>
      <td align="right" colspan="4"><b>NIP. {{ $setting->nip_pemangku }}</b></td>
    </tr>
  </tbody>
</table>