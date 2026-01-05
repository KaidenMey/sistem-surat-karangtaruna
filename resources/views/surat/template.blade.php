<!DOCTYPE html>
<html>
<head>
    <title>Surat Resmi</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @page {
            margin: 1cm;
        }
        body {
            font-family: 'Times New Roman', serif;
            font-size: 11pt;
            line-height: 1.5;
            color: #000000;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px double #000; 
            padding-bottom: 10px;
        }
        .kop-surat h1, .kop-surat h2, .kop-surat p {
            margin: 0;
            line-height: 1.2;
        }
        .kop-surat h1 {
            font-size: 16pt;
            font-weight: bold;
        }
        .kop-surat h2 {
            font-size: 14pt;
            font-weight: bold;
        }
        .kop-surat p {
            font-size: 10pt;
        }
        .meta-surat {
            width: 100%;
            display: table; 
            margin-top: 20px;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .meta-surat .left-col, .meta-surat .right-col {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        .meta-surat .right-col {
            text-align: right;
        }
        .meta-surat table {
            width: 100%;
            border-collapse: collapse;
        }
        .meta-surat td {
            padding: 2px 0;
        }
        .meta-surat td:first-child {
            width: 80px; 
            white-space: nowrap;
        }
        .meta-surat td:nth-child(2) {
            width: 10px; 
        }
        .yth-section {
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .yth-section ol {
            list-style-type: decimal;
            padding-left: 20px;
            margin: 0;
        }
        .yth-section ol li {
            margin-bottom: 5px;
        }
        .isi-surat {
            text-align: justify;
            margin-bottom: 30px;
        }
        .isi-surat p {
            text-indent: 0.5in; 
            margin-bottom: 10px;
        }
        .isi-surat ol {
            list-style-type: decimal;
            padding-left: 20px;
            margin: 0;
        }
        .isi-surat ol li {
            margin-bottom: 5px;
        }
        .isi-surat strong {
            font-weight: bold;
        }
        .blok-ttd {
            width: 50%; 
            float: right;
            text-align: left;
            margin-top: 30px;
            margin-bottom: 50px; 
            margin-right: 0; 
            margin-left: auto;
        }
        .blok-ttd p {
            margin: 0;
        }
        .blok-ttd .signature-space {
            height: 70px; 
            width: 100%;
        }
        .blok-ttd .nama-ttd {
            text-decoration: underline;
            font-weight: bold;
        }
        .tanda-tangan-wrapper {
            display: flex;
            justify-content: flex-end;
            gap: 40px;
            margin-top: 30px;
            margin-bottom: 50px;
            clear: both;
        }
        .tanda-tangan-item {
            text-align: left;
            min-width: 200px;
        }
        .tanda-tangan-item p {
            margin: 0;
        }
        .tanda-tangan-item .signature-space {
            height: 70px;
            width: 100%;
        }
        .tanda-tangan-item .nama-ttd {
            text-decoration: underline;
            font-weight: bold;
        }
        .tembusan-section {
            clear: both; 
            margin-top: 20px;
        }
        .tembusan-section ol {
            list-style-type: decimal;
            padding-left: 20px;
            margin: 0;
        }
        .tembusan-section ol li {
            margin-bottom: 3px;
        }
        .tembusan-section p {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="kop-surat">
            <h1>PEMERINTAH KABUPATEN BANTUL</h1>
            <h2>KARANG TARUNA MOROSENE</h2>
            <p>Sekretariat: Jl. [Alamat Lengkap], [Kelurahan], [Kecamatan], Bantul</p>
            <p>E-mail: kt.morosene@example.com | HP: 08xxxxxxxxxx</p>
        </div>

        <div class="meta-surat">
            <div class="left-col">
                <table>
                    <tr>
                        <td>Nomor</td>
                        <td>:</td>
                        <td>{{ $surat->nomor_surat }}</td>
                    </tr>
                    <tr>
                        <td>Lampiran</td>
                        <td>:</td>
                        <td>{{ $surat->lampiran }}</td>
                    </tr>
                    <tr>
                        <td>Hal</td>
                        <td>:</td>
                        <td>{{ $surat->hal }}</td>
                    </tr>
                </table>
            </div>
            <div class="right-col">
                {{ \Carbon\Carbon::parse($surat->tanggal_surat)->isoFormat('D MMMM YYYY') }}
            </div>
        </div>

        <div class="yth-section">
            <p>Yth.</p>
            <ol>
                @if($surat->penerima && is_array($surat->penerima))
                    @foreach($surat->penerima as $penerima)
                        <li>{{ $penerima }}</li>
                    @endforeach
                @endif
            </ol>
        </div>

        <div class="isi-surat">
            {!! nl2br(e($surat->isi_surat)) !!}
        </div>

        <div class="tanda-tangan-wrapper">
            @if($surat->tanda_tangan && is_array($surat->tanda_tangan) && count($surat->tanda_tangan) > 0)
                @foreach($surat->tanda_tangan as $ttd)
                    <div class="tanda-tangan-item">
                        <p>{{ $surat->kota_penetapan }}, {{ \Carbon\Carbon::parse($surat->tanggal_penetapan)->isoFormat('D MMMM YYYY') }}</p>
                        <p>{{ $ttd['jabatan'] ?? '' }}</p>
                        <div class="signature-space"></div> 
                        <p class="nama-ttd">{{ $ttd['nama'] ?? '' }}</p>
                        <p>NIP {{ $ttd['nip'] ?? '' }}</p>
                    </div>
                @endforeach
            @else
                <div class="tanda-tangan-item">
                    <p>{{ $surat->kota_penetapan }}, {{ \Carbon\Carbon::parse($surat->tanggal_penetapan)->isoFormat('D MMMM YYYY') }}</p>
                    <p>{{ $surat->jabatan_penanda_tangan }}</p>
                    <div class="signature-space"></div> 
                    <p class="nama-ttd">{{ $surat->nama_penanda_tangan }}</p>
                    <p>NIP {{ $surat->nip_penanda_tangan }}</p>
                </div>
            @endif
        </div>

        @if($surat->tembusan && is_array($surat->tembusan) && count($surat->tembusan) > 0)
        <div class="tembusan-section">
            <p>Tembusan:</p>
            <ol>
                @foreach($surat->tembusan as $tembusan)
                    <li>{{ $tembusan }}</li>
                @endforeach
            </ol>
        </div>
        @endif
    </div>
</body>
</html>

