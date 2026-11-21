<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan_Diagnosa_DIAG-{{ str_pad($riwayat->id, 5, '0', STR_PAD_LEFT) }}_{{ preg_replace('/[^a-zA-Z0-9]/', '_', $riwayat->nama_pengguna ?? 'Guest') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
            padding: 2rem;
            line-height: 1.5;
        }

        .paper {
            max-width: 800px;
            margin: 0 auto;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 2.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .header-brand {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #0284c7;
            padding-bottom: 1.25rem;
            margin-bottom: 1.75rem;
        }

        .brand-title h2 {
            font-size: 1.6rem;
            font-weight: 800;
            color: #0284c7;
        }

        .brand-title p {
            font-size: 0.85rem;
            color: #64748b;
        }

        .doc-info {
            text-align: right;
            font-size: 0.85rem;
            color: #475569;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
            background: #f1f5f9;
            padding: 1.25rem;
            border-radius: 8px;
            margin-bottom: 1.75rem;
            font-size: 0.9rem;
        }

        .info-item span {
            display: block;
            font-size: 0.75rem;
            text-transform: uppercase;
            color: #64748b;
            font-weight: 700;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.75rem;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 0.4rem;
        }

        .symptom-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1.75rem;
        }

        .symptom-badge {
            background: #e0f2fe;
            color: #0369a1;
            border: 1px solid #bae6fd;
            padding: 0.35rem 0.75rem;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .result-box {
            border: 1px solid #cbd5e1;
            border-left: 4px solid #0284c7;
            border-radius: 8px;
            padding: 1.25rem;
            margin-bottom: 1.25rem;
            background: #fafafa;
        }

        .result-box h4 {
            font-size: 1.1rem;
            color: #0369a1;
            margin-bottom: 0.5rem;
        }

        .list-section {
            margin-top: 0.5rem;
            font-size: 0.875rem;
            color: #334155;
        }

        .list-section ul, .list-section ol {
            margin-left: 1.2rem;
        }

        .signatures {
            display: grid;
            grid-template-columns: 1fr 1fr;
            margin-top: 3.5rem;
            text-align: center;
            font-size: 0.85rem;
        }

        .sig-space {
            height: 60px;
        }

        .no-print-bar {
            max-width: 800px;
            margin: 0 auto 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .btn-action-group {
            display: flex;
            gap: 0.75rem;
        }

        .btn-download-pdf {
            background: #10b981;
            color: #ffffff;
            border: none;
            padding: 0.6rem 1.4rem;
            border-radius: 6px;
            font-weight: 700;
            cursor: pointer;
            font-size: 0.9rem;
            transition: background 0.2s;
        }

        .btn-download-pdf:hover {
            background: #059669;
        }

        .btn-print {
            background: #0284c7;
            color: #ffffff;
            border: none;
            padding: 0.6rem 1.4rem;
            border-radius: 6px;
            font-weight: 700;
            cursor: pointer;
            font-size: 0.9rem;
            transition: background 0.2s;
        }

        .btn-print:hover {
            background: #0369a1;
        }

        .btn-back {
            color: #64748b;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
        }

        @media print {
            body {
                background: #ffffff;
                padding: 0;
            }
            .paper {
                box-shadow: none;
                border: none;
                padding: 0;
                max-width: 100%;
            }
            .no-print-bar {
                display: none !important;
            }
        }
    </style>
</head>
<body>

    <div class="no-print-bar">
        <a href="{{ panel_route('riwayat.show', $riwayat) }}" class="btn-back">&larr; Kembali ke Detail</a>
        <div style="font-size: 0.825rem; color: #475569; background: #e2e8f0; padding: 6px 12px; border-radius: 6px;">
            💡 Pilih <strong>Save as PDF / Simpan sebagai PDF</strong> pada browser untuk mendownload file
        </div>
        <div class="btn-action-group">
            <button onclick="window.print()" class="btn-print">🖨️ Simpan PDF / Cetak Laporan</button>
        </div>
    </div>

    <div class="paper" id="reportContent">
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
        </div>

        <div class="info-grid">
            <div class="info-item">
                <span>Nama Pelanggan / User</span>
                <strong>{{ $riwayat->nama_pengguna ?? 'Guest (Anonim)' }}</strong>
            </div>
            <div class="info-item">
                <span>Spesifikasi Laptop</span>
                <strong>{{ $riwayat->laptop_display ?? 'Tidak Ditentukan' }}</strong>
            </div>
        </div>

        <h3 class="section-title">1. Gejala Yang Teridentifikasi</h3>
        <div class="symptom-tags">
            @forelse($riwayat->diagnosisGejala as $dg)
                <div class="symptom-badge">
                    [{{ $dg->gejala->kode_gejala }}] {{ $dg->gejala->nama_gejala }}
                </div>
            @empty
                <p style="color: #64748b; font-size: 0.85rem;">Tidak ada gejala yang dicatat.</p>
            @endforelse
        </div>

        <h3 class="section-title">2. Hasil Inferensi & Solusi Perbaikan</h3>
        @if($riwayat->diagnosisResults->isEmpty())
            <div class="result-box" style="border-left-color: #64748b;">
                <h4>Tidak Ditemukan Indikasi Kerusakan Spesifik</h4>
                <p style="font-size: 0.85rem; color: #475569;">Kombinasi gejala yang dipilih tidak mencocoki rule kerusakan terdaftar. Disarankan untuk pengujian fisik hardware di laboratorium.</p>
            </div>
        @else
            @foreach($riwayat->diagnosisResults as $res)
                @php $k = $res->kerusakan; @endphp
                <div class="result-box">
                    <h4>[{{ $k->kode_kerusakan }}] {{ $k->nama_kerusakan }} ({{ $k->kategori->nama_kategori ?? 'Umum' }})</h4>
                    
                    @if($k->penyebabs->isNotEmpty())
                        <div class="list-section">
                            <strong>Kemungkinan Penyebab:</strong>
                            <ul>
                                @foreach($k->penyebabs as $p)
                                    <li>{{ $p->deskripsi }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if($k->solusis->isNotEmpty())
                        <div class="list-section" style="margin-top: 0.5rem;">
                            <strong>Rekomendasi Solusi & Pengerjaan:</strong>
                            <ol>
                                @foreach($k->solusis as $s)
                                    <li>{{ $s->deskripsi }}</li>
                                @endforeach
                            </ol>
                        </div>
                    @endif
                </div>
            @endforeach
        @endif

        <div class="signatures">
            <div>
                <p>Pelanggan / Pemilik</p>
                <div class="sig-space"></div>
                <p>( {{ $riwayat->nama_pengguna ?? 'Pelanggan' }} )</p>
            </div>
            <div>
                <p>Teknisi Pemeriksa</p>
                <div class="sig-space"></div>
                <p>( {{ auth()->user()->name ?? 'Teknisi CODEVA TECH' }} )</p>
            </div>
        </div>
    </div>

    <script>
        function downloadPDF() {
            window.print();
        }

        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('download') === '1' || urlParams.get('autoprint') === '1') {
                setTimeout(function() {
                    window.print();
                }, 300);
            }
        });
    </script>
</body>
</html>
