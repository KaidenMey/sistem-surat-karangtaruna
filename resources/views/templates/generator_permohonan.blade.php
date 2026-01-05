<!DOCTYPE html>
<html>
<head>
    <title>Surat Permohonan Pembinaan Sanggar</title>
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
            margin: 0 auto;
        }
        .clear {
            clear: both;
        }
        
        /* KOP SURAT */
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

        /* DATA SURAT (NOMOR, PERIHAL) */
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

        /* PENERIMA (KEPADA) */
        .yth-section {
            margin-bottom: 10px;
        }
        .kepada table {
            margin-left: 5px;
        }
        .kepada table td {
            padding: 0;
        }
        .kepada table td:first-child {
            width: 25px;
        }

        /* ISI SURAT */
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

        /* TANDA TANGAN */
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
        .spacer {
            height: 50px;
        }
        .ttd-placeholder-text {
            display: inline-block;
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
        $sekretarisNama = $penandatangan[1]['nama'] ?? ($formData['sekretaris_nama'] ?? 'Ferawati Putri Iskatriana');
        
        // For permohonan, use tanggal_surat_text if available
        $tanggalSurat = $surat['tanggal_surat'] ?? 'Bantul, 28 Februari 2022';
        if (isset($formData['tanggal_surat_text'])) {
            $tanggalSurat = $formData['tanggal_surat_text'];
        }
    @endphp

    <div class="document-container">
        <table class="kop-surat-table">
            <tr>
                <td class="logo-cell">
                    <div style="width: 80px; height: 80px; text-align: left; line-height: 80px; font-size: 8pt;">
                        [Logo Satrio Budoyo Mudo]
                    </div>
                </td>
                <td class="teks-kop-cell">
                    <h2>MUDA-MUDI MOROSENE MAYUNGAN</h2>
                    <h1>SATRIO BUDOYO MUDO MAYUNGAN</h1>
                    <p>Mayungan, Murtigading, Sanden, Bantul 55763 Telp. 085867270347</p>
                </td>
                <td style="width: 15%;"></td>
            </tr>
        </table>
        <div class="header-line"></div>
        <div class="clear"></div>

        <div class="data-surat">
            <table>
                <tr>
                    <td>Nomor</td><td>:</td><td>{{ $surat['nomor_surat'] ?? '10/SBMM/II/2022' }}</td>
                    <td class="tanggal-surat-cell" rowspan="4">{{ $tanggalSurat }}</td>
                </tr>
                <tr>
                    <td>Lamp</td><td>:</td><td>{{ $surat['lampiran'] ?? '5 Lembar' }}</td>
                </tr>
                <tr>
                    <td>Hal</td><td>:</td><td><b><u>{{ $surat['hal'] ?? 'Permohonan Pembinaan Sanggar' }}</u></b></td>
                </tr>
                <tr>
                    <td>Kepada</td><td>:</td><td></td>
                </tr>
            </table>
        </div>
        <div class="clear"></div>

        <div class="yth-section">
            <div class="kepada">
                <table>
                    <tr><td></td><td>{{ $formData['kepada_utama'] ?? 'Bapak Gubernur DIY' }}</td></tr>
                    <tr><td></td><td>{{ $formData['cq_kedua'] ?? 'c.q Kepala Dinas Kebudayaan (Kundha Kabudayan) DIY' }}</td></tr>
                    <tr><td></td><td>di Yogyakarta</td></tr>
                </table>
            </div>
        </div>

        <div class="isi-surat">
            <p style="text-indent: 0;">Assalamu'alaikum wr.wb</p>
            <p>{{ $formData['paragraf_pembuka'] ?? 'Dengan hormat, sehubungan dengan adanya program pembinaan sanggar oleh Dinas Kebudayaan DIY, bersama ini kami Kelompok Seni "Satrio Budoyo Mudo Mayungan" yang bergerak di bidang kesenian reog wayang bermaksud untuk mengajukan bantuan pembinaan sanggar guna mengembangkan kelompok seni kami.' }}</p>
            <p>{{ $formData['paragraf_permohonan'] ?? 'Berkenaan dengan adanya keterbatasan dana pada kelompok seni kami, maka dengan ini kami sampaikan permohonan kepada Bapak Gubernur Daerah Istimewa Yogyakarta melalui Dinas Kebudayaan DIY agar berkenan memberi bantuan pembinaan sanggar.' }}</p>
            <p>{{ $formData['paragraf_penutup'] ?? 'Besar harapan kami agar Bapak/Ibu berkenan mengabulkan permohonan ini. Atas bantuan dan kerja sama yang Bapak/Ibu berikan kami ucapkan terima kasih.' }}</p>
            <p style="text-indent: 0;">Wassalamu'alaikum wr.wb</p>
        </div>

        <div class="signature-container">
            <div style="text-align: right; margin-bottom: 10px;">Hormat kami</div>

            <table class="ttd-row-table">
                <tr>
                    <td style="text-align: left; padding-left: 20px;">
                        Ketua Paguyuban Satrio Budoyo Mudo<br>Mayungan
                    </td>
                    <td style="text-align: right; padding-right: 20px;">
                        Sekretaris Satrio Budoyo Mudo<br>Mayungan
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
            
            @if(!empty($formData['mengetahui_1_jabatan']) || !empty($formData['mengetahui_2_jabatan']))
            <div style="text-align: center; font-weight: normal; margin-top: 15px; margin-bottom: 5px;">Mengetahui:</div>
            
            <table class="ttd-row-table" style="width: 70%; margin-left: 15%;">
                <tr>
                    @if(!empty($formData['mengetahui_1_jabatan']))
                    <td style="width: 50%;">
                        {{ $formData['mengetahui_1_jabatan'] }}
                        <div class="spacer" style="height: 35px;"></div>
                        <span class="ttd-placeholder-text">({{ !empty($formData['mengetahui_1_nama']) ? $formData['mengetahui_1_nama'] : '.......................................' }})</span>
                    </td>
                    @endif
                    @if(!empty($formData['mengetahui_2_jabatan']))
                    <td style="width: 50%;">
                        {{ $formData['mengetahui_2_jabatan'] }}
                        <div class="spacer" style="height: 35px;"></div>
                        <span class="ttd-placeholder-text">({{ !empty($formData['mengetahui_2_nama']) ? $formData['mengetahui_2_nama'] : '.......................................' }})</span>
                    </td>
                    @endif
                </tr>
            </table>
            @endif

            @if(!empty($formData['tembusan_jabatan']))
            <div style="text-align: center; margin-top: 15px;">
                {{ $formData['tembusan_jabatan'] }}
                <div class="spacer" style="height: 50px;"></div>
                <span class="ttd-placeholder-text">({{ !empty($formData['tembusan_nama']) ? $formData['tembusan_nama'] : '.......................................' }})</span>
            </div>
            @endif
        </div>
    </div>
</body>
</html>

