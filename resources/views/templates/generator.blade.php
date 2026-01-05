<!DOCTYPE html>
<html>
<head>
    <title>Surat Resmi</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        /* Margin disesuaikan agar muat 1 halaman */
        @page {
            margin: 20mm 20mm 15mm 20mm; 
            size: A4 portrait;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            line-height: 1.4;
            color: #000000;
            margin: 0;
            padding: 0;
            background: #fff;
        }
        .document-container {
            width: 100%;
            min-height: 100%;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background: white;
        }
        .clear {
            clear: both;
        }
        
        /* 1. KOP SURAT - Dibuat stabil menggunakan tabel */
        .kop-surat-table {
            width: 100%;
            border-collapse: collapse;
        }
        .kop-surat-table td {
            vertical-align: top;
            padding: 0 5px;
        }
        .kop-surat-table .logo-cell {
            width: 15%;
            text-align: left;
        }
        .kop-surat-table .teks-kop-cell {
            width: 70%;
            text-align: center;
            line-height: 1.3;
        }
        .kop-surat-table h2, .kop-surat-table h1 {
            margin: 0;
            font-weight: bold;
        }
        .kop-surat-table h2 { font-size: 16pt; }
        .kop-surat-table h1 { font-size: 14pt; }
        .kop-surat-table p {
            margin: 0;
            font-size: 10pt;
        }
        .header-line {
            border-top: 1px solid black;
            border-bottom: 3px solid black;
            margin: 3px 0 10px 0;
            height: 0;
        }

        /* 2. DATA SURAT (NOMOR, PERIHAL) - Dibuat konsisten di kiri */
        .data-surat {
            margin-bottom: 10px;
        }
        .data-surat table {
            width: 100%; /* Dibuat 100% karena tanggal di kanan */
            text-align: left;
            border-collapse: collapse;
            margin-bottom: 5px;
        }
        .data-surat table td {
            padding: 2px 0;
        }
        .data-surat table td:first-child {
            width: 10%; 
        }
        .data-surat table td:nth-child(2) {
            width: 2%; 
        }
        .data-surat .tanggal-surat-cell {
            text-align: right;
            width: 40%;
        }
        .kepada {
            margin-bottom: 10px;
        }
        .kepada table {
            margin-left: 5px; /* Sedikit geser ke kanan */
        }
        .kepada table td {
            padding: 0;
        }
        .kepada table td:first-child {
            width: 25px;
        }

        /* 3. ISI SURAT */
        .isi-surat {
            margin-bottom: 15px;
        }
        .isi-surat p {
            text-indent: 0.5in;
            margin-bottom: 6px;
            text-align: justify;
            line-height: 1.4;
        }
        .isi-surat p:first-of-type, .isi-surat .no-indent {
            text-indent: 0;
        }
        .detail-kegiatan {
            margin-bottom: 8px;
            padding-left: 0.8in;
        }
        .detail-kegiatan table {
            width: 100%;
            border-collapse: collapse;
        }
        .detail-kegiatan table td:first-child {
            width: 120px;
            padding: 3px 5px;
        }

        /* 4. TANDA TANGAN - Dibuat rapi dan presisi */
        .signature-container {
            width: 100%;
            margin-top: 20px;
            text-align: center;
        }
        .signature-container .ttd-row-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            line-height: 1.2;
        }
        .signature-container .ttd-row-table td {
            padding: 0;
            vertical-align: top;
            text-align: center;
            width: 50%;
            font-size: 10pt;
        }
        .signature-container .ttd-mengetahui-table td {
            width: 33.33%; /* Pembagian tiga kolom */
            padding: 0;
            font-size: 10pt;
        }
        .spacer {
            height: 50px;
        }
        .ttd-placeholder-text {
            /* Garis bawah dihilangkan agar sesuai gambar asli */
            display: inline-block;
            margin-top: 5px;
        }

    </style>
</head>
<body>
    @php
        $template = $surat['template'] ?? [];
        $slug = $template['slug'] ?? 'surat';
        $formData = $surat['form_data'] ?? [];
        
        // Get penandatangan
        $penandatangan = $surat['tanda_tangan'] ?? [];
        if (empty($penandatangan) && !empty($surat['nama_penanda_tangan'])) {
            $penandatangan = [[
                'jabatan' => $surat['jabatan_penanda_tangan'] ?? '',
                'nama' => $surat['nama_penanda_tangan'] ?? '',
                'nip' => $surat['nip_penanda_tangan'] ?? '',
            ]];
        }

        // Penyesuaian data jika tidak ada inputan form
        $ketuaNama = $penandatangan[0]['nama'] ?? ($formData['ketua_nama'] ?? 'Imam Arba\'in Dwijaya');
        $sekretarisNama = $penandatangan[1]['nama'] ?? ($formData['sekretaris_nama'] ?? 'Nia Trinadani');
        $kotaPenetapan = $surat['kota_penetapan'] ?? 'Bantul';
        $tanggalSurat = $surat['tanggal_surat'] ?? '11 Februari 2025';
        
    @endphp

    @if ($slug === 'surat_proposal')
    <div class="document-container">
    
        <table class="kop-surat-table">
            <tr>
                <td class="logo-cell">
                    <div style="width: 80px; height: 80px; text-align: left; line-height: 80px; font-size: 8pt;">
                        [Logo Sketsa Wayang]
                    </div>
                </td>
                <td class="teks-kop-cell">
                    <h2>MUDA-MUDI MOROSENE MAYUNGAN</h2>
                    <h1>SATRIO BUDOYO MUDO MAYUNGAN</h1>
                    <p>Mayungan, Murtigading, Sanden, Bantul 55763 Telp. 089538832662</p>
                </td>
                <td style="width: 15%;"></td>
            </tr>
        </table>
        <div class="header-line"></div>
        <div class="clear"></div>

        @if ($slug === 'surat_proposal')
        <div class="data-surat">
            <table>
                <tr><td>Nomor</td><td>:</td><td>{{ $surat['nomor_surat'] ?? '05/SBMM/IX/2025' }}</td></tr>
                <tr><td>Perihal</td><td>:</td><td>Proposal Kegiatan Gelar Wisata Budaya</td></tr>
                <tr><td>Lampiran</td><td>:</td><td>{{ $surat['lampiran'] ?? '3 lembar' }}</td></tr>
            </table>
            <div class="clear"></div>
        </div>

        <div class="yth-section">
            <div class="kepada">
                Kepada
                <table>
                    <tr><td>:</td><td>{{ $formData['kepada'] ?? 'Bapak Gubernur DIY' }}</td></tr>
                    <tr><td>c.q</td><td>{{ $formData['cq'] ?? 'Kepala Dinas Pariwisata DIY' }}</td></tr>
                    <tr><td></td><td>di Yogyakarta</td></tr>
                </table>
            </div>
        </div>

        <div class="isi-surat">
            <p style="text-indent: 0;">Assalamu'alaikum wr. wb</p>
            <p>Dengan memanjatkan Puji syukur atas kehadirat Allah SWT, semoga kita senantiasa dalam keadaan sehat serta selalu berada dalam lindungan-Nya. Sehubungan dengan adanya agenda Morosene dalam rangka meningkatkan wisata dan budaya, bersama ini kami paguyuban reog wayang Satrio Budoyo Mudo Mayungan bermaksud untuk mengadakan pentas reog wayang yang akan diselenggarakan pada:</p>
            
            <div class="detail-kegiatan">
                <table>
                    <tr><td>Hari, Tanggal</td><td>:</td><td>{{ $formData['hari_tanggal_kegiatan'] ?? 'Sabtu, 24 Oktober 2014' }}</td></tr>
                    <tr><td>Tempat</td><td>:</td><td>{{ $formData['tempat_kegiatan'] ?? 'Lapangan Bola Voli Mayungan' }}</td></tr>
                </table>
            </div>

            <p>Sehubungan dengan hal tersebut, kami selaku panitia pelaksana mengharapkan kesediaan Bapak/Ibu untuk berkenan memberikan bantuan dana demi terselenggaranya kegiatan tersebut.</p>
            <p>Demikian surat permohonan ini kami sampaikan. Besar harapan kami kiranya Bapak/Ibu dapat berpartisipasi dalam kegiatan ini. Atas bantuan dan perhatiannya kami ucapkan terima kasih.</p>
            <p style="text-indent: 0;">Wassalamu'alaikum wr.wb</p>
        </div>

        <div class="signature-container">
            <div style="text-align: right; margin-bottom: 10px;">
                {{ $kotaPenetapan }}, {{ $tanggalSurat }}<br>
                Hormat kami
            </div>

            <table class="ttd-row-table">
                <tr>
                    <td style="text-align: left; padding-left: 20px;">
                        Ketua Paguyuban Satrio Budoyo Mudo<br>Mayungan
                    </td>
                    <td style="text-align: right; padding-right: 20px;">
                        Sekertaris Paguyuban Satrio Budoyo Mudo<br>Mayungan
                    </td>
                </tr>
                <tr><td class="spacer"></td><td class="spacer"></td></tr>
                <tr>
                    <td style="text-align: left; padding-left: 20px;">
                        <span class="ttd-placeholder-text">{{ $ketuaNama }}</span>
                    </td>
                    <td style="text-align: right; padding-right: 20px;">
                        <span class="ttd-placeholder-text">{{ $sekretarisNama }}</span>
                    </td>
                </tr>
            </table>
            
            @if(!empty($formData['mengetahui_1_jabatan']) || !empty($formData['mengetahui_2_jabatan']) || !empty($formData['mengetahui_3_jabatan']))
            <div style="text-align: center; font-weight: normal; margin-top: 15px; margin-bottom: 5px;">Mengetahui:</div>
            
            @if(!empty($formData['mengetahui_1_jabatan']) || !empty($formData['mengetahui_2_jabatan']))
            <table class="ttd-row-table ttd-mengetahui-table">
                <tr>
                    @if(!empty($formData['mengetahui_1_jabatan']))
                    <td>
                        {{ $formData['mengetahui_1_jabatan'] }}
                        <div class="spacer" style="height: 35px;"></div>
                        <span class="ttd-placeholder-text">({{ !empty($formData['mengetahui_1_nama']) ? $formData['mengetahui_1_nama'] : '.......................................' }})</span>
                    </td>
                    @endif
                    @if(!empty($formData['mengetahui_2_jabatan']))
                    <td>
                        {{ $formData['mengetahui_2_jabatan'] }}
                        <div class="spacer" style="height: 35px;"></div>
                        <span class="ttd-placeholder-text">({{ !empty($formData['mengetahui_2_nama']) ? $formData['mengetahui_2_nama'] : '.......................................' }})</span>
                    </td>
                    @endif
                </tr>
            </table>
            @endif

            @if(!empty($formData['mengetahui_3_jabatan']))
            <div style="text-align: center; margin-top: 15px;">
                {{ $formData['mengetahui_3_jabatan'] }}
                <div class="spacer" style="height: 50px;"></div>
                <span class="ttd-placeholder-text">({{ !empty($formData['mengetahui_3_nama']) ? $formData['mengetahui_3_nama'] : '.......................................' }})</span>
            </div>
            @endif
            @endif
        </div>
        @endif

    </div>
    @else
    <div class="container">
        </div>
    @endif
</body>
</html>