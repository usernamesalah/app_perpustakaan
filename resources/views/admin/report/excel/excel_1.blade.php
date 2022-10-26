<table>
  <thead>
    <tr>
      <th colspan="3">Dinas Perpustakaan dan Arsip Daerah Kota Wakanda</th>
    </tr>
    <tr>
      <th colspan="3">{{ $setting->alamat }} Telp. {{ $setting->telpon }}, Fax. {{ $setting->telpon }}</th>
    </tr>
    <tr>
      <th colspan="3">website : www.simpusda.wakandakota.go.id, Email : {{ $setting->email }}</th>
    </tr>
    <tr>
      <th colspan="3">{{ $type }}</th>
    </tr>
    <tr>
      <th colspan="3">Per Pendaftaran Periode {{ $tgl_awal }} s/d {{ $tgl_akhir }}</th>
    </tr>
  </thead>
</table>

<table>
  <thead>
    <tr>
      <th><b>No</b></th>
      <th><b>Jenis Keanggotaan</b></th>
      <th><b>Total</b></th>
    </tr>
  </thead>
  <tbody>
    @php
      $total = 0;
    @endphp
    @foreach ($members as $key => $value)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $value->type }}</td>
        <td>{{ $value->total }}</td>
      </tr>
      @php
        $total += $value->total;
      @endphp
    @endforeach
    <tr>
      <td colspan="2"><b>Total</b></td>
      <td><b>{{ $total }}</b></td>
    </tr>
  </tbody>
</table>

<table>
  <tbody>
    <tr>
      <td align="right" colspan="3"><b>Banjarmasin, {{ $tgl_sekarang }}</b></td>
    </tr>
    <tr>
      <td align="right" colspan="3"><b>Penanggung Jawab</b></td>
    </tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr>
      <td align="right" colspan="3"><b>{{ $setting->pemangku }}</b></td>
    </tr>
    <tr>
      <td align="right" colspan="3"><b>NIP. {{ $setting->nip_pemangku }}</b></td>
    </tr>
  </tbody>
</table>