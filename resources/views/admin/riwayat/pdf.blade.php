<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan_Diagnosa_DIAG-{{ str_pad($riwayat->id, 5, '0', STR_PAD_LEFT) }}</title>
    <style>
        @page {
            margin: 25px;
        }

        body {
            font-family: Helvetica, Arial, sans-serif;
            color: #0f172a;
            font-size: 12px;
            line-height: 1.4;
        }

        .header-brand {
            border-bottom: 2px solid #0284c7;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .brand-title {
            float: left;
        }

        .brand-title h2 {
            font-size: 18px;
            margin: 0 0 4px 0;
            color: #0284c7;
        }

        .brand-title p {
            font-size: 10px;
            color: #64748b;
            margin: 0;
        }

        .doc-info {
            float: right;
            text-align: right;
            font-size: 10px;
            color: #475569;
        }

        .clear {
            clear: both;
        }

        .info-table {
            width: 100%;
            background: #f1f5f9;
            border-radius: 6px;
            padding: 10px;
            margin-bottom: 15px;
        }

        .info-table td {
            font-size: 11px;
            padding: 4px;
        }

        .info-label {
            font-size: 9px;
            text-transform: uppercase;
            color: #64748b;
            font-weight: bold;
        }

        .section-title {
            font-size: 13px;
            font-weight: bold;
            color: #0f172a;
            margin-top: 15px;
            margin-bottom: 8px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 4px;
        }

        .symptom-box {
            background: #e0f2fe;
            color: #0369a1;
            border: 1px solid #bae6fd;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            display: inline-block;
            margin-right: 4px;
            margin-bottom: 4px;
        }

        .result-box {
            border: 1px solid #cbd5e1;
            border-left: 4px solid #0284c7;
            border-radius: 6px;
            padding: 10px;
            margin-bottom: 10px;
            background: #fafafa;
        }

        .result-title {
            font-size: 13px;
            font-weight: bold;
            color: #0369a1;
            margin-bottom: 6px;
        }

        .list-section {
            margin-top: 6px;
            font-size: 11px;
            color: #334155;
        }

        .signatures {
            margin-top: 40px;
            width: 100%;
        }

        .signatures td {
            text-align: center;
            font-size: 11px;
            width: 50%;
        }

        .sig-space {
            height: 50px;
        }
    </style>
</head>
<body>

    <div class="header-brand">
        <div class="brand-title">
            <h2>CODEVA TECH — Laptop & Computer Service Center</h2>
            <p>Jl. Serdang Baru III No. 362, Kemayoran, Jakarta Pusat 10650 | Telp/WA: +62 89653436221</p>
        </div>
        <div class="doc-info">
            <strong>LAPORAN HASIL DIAGNOSA</strong><br>
            No: #DIAG-{{ str_pad($riwayat->id, 5, '0', STR_PAD_LEFT) }}<br>
            Tgl: {{ $riwayat->tanggal_diagnosis ? $riwayat->tanggal_diagnosis->format('d M Y, H:i') : '-' }} WIB
        </div>
        <div class="clear"></div>
    </div>

    <table class="info-table">
        <tr>
            <td width="50%">
                <span class="info-label">NAMA PELANGGAN / PEMILIK</span><br>
                <strong>{{ $riwayat->nama_pengguna ?? 'Guest (Anonim)' }}</strong>
                @if($riwayat->user)
                    <br><span style="font-size: 9px; color: #0284c7;">Diagnosa oleh Teknisi: <strong>{{ $riwayat->user->name }}</strong></span>
                @endif
            </td>
            <td width="50%">
                <span class="info-label">SPESIFIKASI LAPTOP</span><br>
                <strong>{{ $riwayat->laptop_display ?? 'Tidak Ditentukan' }}</strong>
            </td>
        </tr>
    </table>

    <div class="section-title">1. GEJALA YANG TERIDENTIFIKASI</div>
    <div style="margin-bottom: 15px;">
        @forelse($riwayat->diagnosisGejala as $dg)
            <span class="symptom-box">
                [{{ $dg->gejala->kode_gejala }}] {{ $dg->gejala->nama_gejala }}
            </span>
        @empty
            <p style="color: #64748b; font-size: 11px;">Tidak ada gejala yang dicatat.</p>
        @endforelse
    </div>

    <div class="section-title">2. HASIL INFERENSI & SOLUSI PERBAIKAN</div>
    @if($riwayat->diagnosisResults->isEmpty())
        <div class="result-box" style="border-left-color: #64748b;">
            <div class="result-title">Tidak Ditemukan Indikasi Kerusakan Spesifik</div>
            <p style="font-size: 11px; color: #475569; margin: 0;">Kombinasi gejala yang dipilih tidak mencocoki rule kerusakan terdaftar. Disarankan untuk pengujian fisik hardware di laboratorium.</p>
        </div>
    @else
        @foreach($riwayat->diagnosisResults as $res)
            @php $k = $res->kerusakan; @endphp
            <div class="result-box">
                <div class="result-title">[{{ $k->kode_kerusakan }}] {{ $k->nama_kerusakan }} ({{ $k->kategori->nama_kategori ?? 'Umum' }})</div>
                
                @if($k->penyebabs->isNotEmpty())
                    <div class="list-section">
                        <strong>Kemungkinan Penyebab:</strong>
                        <ul style="margin: 4px 0 0 16px; padding: 0;">
                            @foreach($k->penyebabs as $p)
                                <li>{{ $p->deskripsi }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($k->solusis->isNotEmpty())
                    <div class="list-section" style="margin-top: 6px;">
                        <strong>Rekomendasi Solusi & Pengerjaan:</strong>
                        <ol style="margin: 4px 0 0 16px; padding: 0;">
                            @foreach($k->solusis as $s)
                                <li>{{ $s->deskripsi }}</li>
                            @endforeach
                        </ol>
                    </div>
                @endif
            </div>
        @endforeach
    @endif

    <table class="signatures">
        <tr>
            <td>
                Pelanggan / Pemilik
                <div class="sig-space"></div>
                ( {{ $riwayat->nama_pengguna ?? 'Pelanggan' }} )
            </td>
            <td>
                Teknisi Pemeriksa
                <div class="sig-space"></div>
                ( {{ $riwayat->user->name ?? auth()->user()->name ?? 'Teknisi CODEVA TECH' }} )
            </td>
        </tr>
    </table>

</body>
</html>
