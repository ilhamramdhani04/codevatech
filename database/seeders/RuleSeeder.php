<?php

namespace Database\Seeders;

use App\Models\Gejala;
use App\Models\Kerusakan;
use App\Models\Rule;
use App\Models\RuleGejala;
use Illuminate\Database\Seeder;

class RuleSeeder extends Seeder
{
    public function run(): void
    {
        $rulesData = [
            [
                'kode_rule'    => 'R01',
                'kode_k'       => 'K04',
                'keterangan'   => 'Motherboard short circuit',
                'gejalas'      => [
                    ['kode' => 'G01', 'not' => false],
                    ['kode' => 'G04', 'not' => false],
                ],
            ],
            [
                'kode_rule'    => 'R02',
                'kode_k'       => 'K05',
                'keterangan'   => 'Baterai drop/aus',
                'gejalas'      => [
                    ['kode' => 'G01', 'not' => false],
                    ['kode' => 'G19', 'not' => true],
                    ['kode' => 'G18', 'not' => false],
                ],
            ],
            [
                'kode_rule'    => 'R03',
                'kode_k'       => 'K03',
                'keterangan'   => 'VGA Overheat',
                'gejalas'      => [
                    ['kode' => 'G02', 'not' => false],
                    ['kode' => 'G12', 'not' => false],
                    ['kode' => 'G13', 'not' => false],
                ],
            ],
            [
                'kode_rule'    => 'R04',
                'kode_k'       => 'K03',
                'keterangan'   => 'VGA Flickering / Garis',
                'gejalas'      => [
                    ['kode' => 'G05', 'not' => false],
                    ['kode' => 'G08', 'not' => true],
                ],
            ],
            [
                'kode_rule'    => 'R05',
                'kode_k'       => 'K08',
                'keterangan'   => 'LCD Pecah/Retak',
                'gejalas'      => [
                    ['kode' => 'G07', 'not' => false],
                    ['kode' => 'G08', 'not' => false],
                ],
            ],
            [
                'kode_rule'    => 'R06',
                'kode_k'       => 'K01',
                'keterangan'   => 'RAM Freeze / Shutdown',
                'gejalas'      => [
                    ['kode' => 'G03', 'not' => false],
                    ['kode' => 'G09', 'not' => false],
                    ['kode' => 'G30', 'not' => false],
                ],
            ],
            [
                'kode_rule'    => 'R07',
                'kode_k'       => 'K01',
                'keterangan'   => 'RAM BSOD',
                'gejalas'      => [
                    ['kode' => 'G10', 'not' => false],
                    ['kode' => 'G11', 'not' => false],
                ],
            ],
            [
                'kode_rule'    => 'R08',
                'kode_k'       => 'K02',
                'keterangan'   => 'Hardisk Bad Sector',
                'gejalas'      => [
                    ['kode' => 'G09', 'not' => false],
                    ['kode' => 'G39', 'not' => false],
                    ['kode' => 'G32', 'not' => false],
                ],
            ],
            [
                'kode_rule'    => 'R09',
                'kode_k'       => 'K02',
                'keterangan'   => 'Hardisk OS Not Found',
                'gejalas'      => [
                    ['kode' => 'G31', 'not' => false],
                    ['kode' => 'G32', 'not' => false],
                ],
            ],
            [
                'kode_rule'    => 'R10',
                'kode_k'       => 'K09',
                'keterangan'   => 'Kipas/Thermal Paste Bermasalah',
                'gejalas'      => [
                    ['kode' => 'G12', 'not' => false],
                    ['kode' => 'G13', 'not' => false],
                    ['kode' => 'G14', 'not' => false],
                ],
            ],
            [
                'kode_rule'    => 'R11',
                'kode_k'       => 'K09',
                'keterangan'   => 'Kipas Mati / Heatsink Overheat',
                'gejalas'      => [
                    ['kode' => 'G11', 'not' => false],
                    ['kode' => 'G13', 'not' => false],
                    ['kode' => 'G12', 'not' => true],
                ],
            ],
            [
                'kode_rule'    => 'R12',
                'kode_k'       => 'K05',
                'keterangan'   => 'Baterai Tidak Terdeteksi / Drop',
                'gejalas'      => [
                    ['kode' => 'G15', 'not' => false],
                    ['kode' => 'G17', 'not' => false],
                ],
            ],
            [
                'kode_rule'    => 'R13',
                'kode_k'       => 'K06',
                'keterangan'   => 'Charger Mati Total',
                'gejalas'      => [
                    ['kode' => 'G16', 'not' => false],
                    ['kode' => 'G19', 'not' => false],
                ],
            ],
            [
                'kode_rule'    => 'R14',
                'kode_k'       => 'K06',
                'keterangan'   => 'Charger Overheat / Short Cable',
                'gejalas'      => [
                    ['kode' => 'G16', 'not' => false],
                    ['kode' => 'G20', 'not' => false],
                ],
            ],
            [
                'kode_rule'    => 'R15',
                'kode_k'       => 'K07',
                'keterangan'   => 'Keyboard Sebagian Mati / Typo',
                'gejalas'      => [
                    ['kode' => 'G21', 'not' => false],
                    ['kode' => 'G23', 'not' => false],
                ],
            ],
            [
                'kode_rule'    => 'R16',
                'kode_k'       => 'K07',
                'keterangan'   => 'Keyboard Mati Total',
                'gejalas'      => [
                    ['kode' => 'G22', 'not' => false],
                ],
            ],
            [
                'kode_rule'    => 'R17',
                'kode_k'       => 'K10',
                'keterangan'   => 'Speaker Mati',
                'gejalas'      => [
                    ['kode' => 'G24', 'not' => false],
                    ['kode' => 'G36', 'not' => true],
                ],
            ],
            [
                'kode_rule'    => 'R18',
                'kode_k'       => 'K10',
                'keterangan'   => 'Speaker Pecah',
                'gejalas'      => [
                    ['kode' => 'G25', 'not' => false],
                ],
            ],
            [
                'kode_rule'    => 'R19',
                'kode_k'       => 'K11',
                'keterangan'   => 'Engsel Layar Rusak',
                'gejalas'      => [
                    ['kode' => 'G26', 'not' => false],
                    ['kode' => 'G27', 'not' => false],
                ],
            ],
            [
                'kode_rule'    => 'R20',
                'kode_k'       => 'K12',
                'keterangan'   => 'Port USB Mati Total',
                'gejalas'      => [
                    ['kode' => 'G28', 'not' => false],
                ],
            ],
            [
                'kode_rule'    => 'R21',
                'kode_k'       => 'K12',
                'keterangan'   => 'Port USB Longgar',
                'gejalas'      => [
                    ['kode' => 'G29', 'not' => false],
                ],
            ],
            [
                'kode_rule'    => 'R22',
                'kode_k'       => 'K13',
                'keterangan'   => 'OS Corrupt',
                'gejalas'      => [
                    ['kode' => 'G32', 'not' => false],
                    ['kode' => 'G31', 'not' => true],
                    ['kode' => 'G39', 'not' => true],
                ],
            ],
            [
                'kode_rule'    => 'R23',
                'kode_k'       => 'K14',
                'keterangan'   => 'Infeksi Malware/Virus',
                'gejalas'      => [
                    ['kode' => 'G33', 'not' => false],
                    ['kode' => 'G34', 'not' => false],
                    ['kode' => 'G35', 'not' => false],
                ],
            ],
            [
                'kode_rule'    => 'R24',
                'kode_k'       => 'K14',
                'keterangan'   => 'Infeksi Ransomware',
                'gejalas'      => [
                    ['kode' => 'G34', 'not' => false],
                    ['kode' => 'G35', 'not' => true],
                ],
            ],
            [
                'kode_rule'    => 'R25',
                'kode_k'       => 'K15',
                'keterangan'   => 'Driver Bermasalah',
                'gejalas'      => [
                    ['kode' => 'G36', 'not' => false],
                    ['kode' => 'G37', 'not' => false],
                ],
            ],
            [
                'kode_rule'    => 'R26',
                'kode_k'       => 'K16',
                'keterangan'   => 'RAM Overload Software',
                'gejalas'      => [
                    ['kode' => 'G09', 'not' => false],
                    ['kode' => 'G42', 'not' => false],
                    ['kode' => 'G39', 'not' => true],
                ],
            ],
            [
                'kode_rule'    => 'R27',
                'kode_k'       => 'K17',
                'keterangan'   => 'Storage Full',
                'gejalas'      => [
                    ['kode' => 'G38', 'not' => false],
                    ['kode' => 'G39', 'not' => false],
                ],
            ],
            [
                'kode_rule'    => 'R28',
                'kode_k'       => 'K18',
                'keterangan'   => 'Windows Update Error',
                'gejalas'      => [
                    ['kode' => 'G40', 'not' => false],
                ],
            ],
            [
                'kode_rule'    => 'R29',
                'kode_k'       => 'K19',
                'keterangan'   => 'Aplikasi Crash / Not Responding',
                'gejalas'      => [
                    ['kode' => 'G41', 'not' => false],
                    ['kode' => 'G10', 'not' => true],
                ],
            ],
            [
                'kode_rule'    => 'R30',
                'kode_k'       => 'K20',
                'keterangan'   => 'Registry Corrupt',
                'gejalas'      => [
                    ['kode' => 'G30', 'not' => false],
                    ['kode' => 'G41', 'not' => false],
                    ['kode' => 'G01', 'not' => true],
                ],
            ],
            [
                'kode_rule'    => 'R31',
                'kode_k'       => 'K21',
                'keterangan'   => 'Touchpad Tidak Merespons',
                'gejalas'      => [
                    ['kode' => 'G43', 'not' => false],
                    ['kode' => 'G44', 'not' => true],
                ],
            ],
            [
                'kode_rule'    => 'R32',
                'kode_k'       => 'K21',
                'keterangan'   => 'Touchpad Ghosting / Drift',
                'gejalas'      => [
                    ['kode' => 'G44', 'not' => false],
                ],
            ],
            [
                'kode_rule'    => 'R33',
                'kode_k'       => 'K22',
                'keterangan'   => 'Kerusakan Webcam',
                'gejalas'      => [
                    ['kode' => 'G45', 'not' => false],
                ],
            ],
            [
                'kode_rule'    => 'R34',
                'kode_k'       => 'K23',
                'keterangan'   => 'Kerusakan Fingerprint Sensor',
                'gejalas'      => [
                    ['kode' => 'G46', 'not' => false],
                ],
            ],
            [
                'kode_rule'    => 'R35',
                'kode_k'       => 'K23',
                'keterangan'   => 'Gagal Login Windows Hello Face',
                'gejalas'      => [
                    ['kode' => 'G47', 'not' => false],
                ],
            ],
            [
                'kode_rule'    => 'R36',
                'kode_k'       => 'K24',
                'keterangan'   => 'BIOS/UEFI Firmware Corrupt',
                'gejalas'      => [
                    ['kode' => 'G48', 'not' => false],
                ],
            ],
            [
                'kode_rule'    => 'R37a',
                'kode_k'       => 'K25',
                'keterangan'   => 'Secure Boot Violation',
                'gejalas'      => [
                    ['kode' => 'G49', 'not' => false],
                ],
            ],
            [
                'kode_rule'    => 'R37b',
                'kode_k'       => 'K25',
                'keterangan'   => 'TPM Device Not Detected',
                'gejalas'      => [
                    ['kode' => 'G50', 'not' => false],
                ],
            ],
            [
                'kode_rule'    => 'R38',
                'kode_k'       => 'K25',
                'keterangan'   => 'BitLocker Recovery Loop',
                'gejalas'      => [
                    ['kode' => 'G51', 'not' => false],
                    ['kode' => 'G50', 'not' => true],
                ],
            ],
            [
                'kode_rule'    => 'R39',
                'kode_k'       => 'K26',
                'keterangan'   => 'Port USB-C/Thunderbolt Total Mati',
                'gejalas'      => [
                    ['kode' => 'G52', 'not' => false],
                ],
            ],
            [
                'kode_rule'    => 'R40',
                'kode_k'       => 'K26',
                'keterangan'   => 'Port USB-C PD Charging Gagal',
                'gejalas'      => [
                    ['kode' => 'G53', 'not' => false],
                    ['kode' => 'G52', 'not' => true],
                ],
            ],
            [
                'kode_rule'    => 'R41',
                'kode_k'       => 'K27',
                'keterangan'   => 'Modul WiFi Disconnect / Bermasalah',
                'gejalas'      => [
                    ['kode' => 'G54', 'not' => false],
                ],
            ],
            [
                'kode_rule'    => 'R42',
                'kode_k'       => 'K27',
                'keterangan'   => 'Modul Bluetooth Tidak Terdeteksi',
                'gejalas'      => [
                    ['kode' => 'G55', 'not' => false],
                ],
            ],
            [
                'kode_rule'    => 'R43',
                'kode_k'       => 'K28',
                'keterangan'   => 'Coil Whine VRM Load',
                'gejalas'      => [
                    ['kode' => 'G56', 'not' => false],
                ],
            ],
            [
                'kode_rule'    => 'R44',
                'kode_k'       => 'K29',
                'keterangan'   => 'Burn-in Panel OLED',
                'gejalas'      => [
                    ['kode' => 'G57', 'not' => false],
                ],
            ],
            [
                'kode_rule'    => 'R45',
                'kode_k'       => 'K15',
                'keterangan'   => 'Driver GPU Refresh Rate Drop',
                'gejalas'      => [
                    ['kode' => 'G58', 'not' => false],
                    ['kode' => 'G57', 'not' => true],
                ],
            ],
            [
                'kode_rule'    => 'R46',
                'kode_k'       => 'K30',
                'keterangan'   => 'NPU / AI Chip Driver Error',
                'gejalas'      => [
                    ['kode' => 'G59', 'not' => false],
                ],
            ],
            [
                'kode_rule'    => 'R47',
                'kode_k'       => 'K09',
                'keterangan'   => 'Overheat saat Beban AI/GPU',
                'gejalas'      => [
                    ['kode' => 'G60', 'not' => false],
                    ['kode' => 'G13', 'not' => false],
                    ['kode' => 'G59', 'not' => true],
                ],
            ],
            [
                'kode_rule'    => 'R48a',
                'kode_k'       => 'K31',
                'keterangan'   => 'Bootloop Pasca Update Windows Besar',
                'gejalas'      => [
                    ['kode' => 'G61', 'not' => false],
                ],
            ],
            [
                'kode_rule'    => 'R48b',
                'kode_k'       => 'K31',
                'keterangan'   => 'BSOD Inaccessible Boot Device Update',
                'gejalas'      => [
                    ['kode' => 'G62', 'not' => false],
                ],
            ],
            [
                'kode_rule'    => 'R49',
                'kode_k'       => 'K06',
                'keterangan'   => 'Charger Fast Charging PD Fail',
                'gejalas'      => [
                    ['kode' => 'G63', 'not' => false],
                    ['kode' => 'G64', 'not' => true],
                ],
            ],
            [
                'kode_rule'    => 'R50',
                'kode_k'       => 'K32',
                'keterangan'   => 'Baterai Rapid Degradation',
                'gejalas'      => [
                    ['kode' => 'G64', 'not' => false],
                    ['kode' => 'G63', 'not' => true],
                ],
            ],
            [
                'kode_rule'    => 'R51',
                'kode_k'       => 'K02',
                'keterangan'   => 'SSD NVMe Missing in File Explorer',
                'gejalas'      => [
                    ['kode' => 'G65', 'not' => false],
                    ['kode' => 'G66', 'not' => true],
                ],
            ],
            [
                'kode_rule'    => 'R52',
                'kode_k'       => 'K33',
                'keterangan'   => 'SSD NVMe Controller Thermal Throttling',
                'gejalas'      => [
                    ['kode' => 'G66', 'not' => false],
                ],
            ],
        ];

        foreach ($rulesData as $r) {
            $kerusakan = Kerusakan::where('kode_kerusakan', $r['kode_k'])->first();
            if ($kerusakan) {
                $rule = Rule::updateOrCreate([
                    'kode_rule' => $r['kode_rule'],
                ], [
                    'kerusakan_id' => $kerusakan->id,
                    'keterangan'   => $r['keterangan'],
                ]);

                // Clear existing rule_gejala
                RuleGejala::where('rule_id', $rule->id)->delete();

                foreach ($r['gejalas'] as $gInfo) {
                    $gejala = Gejala::where('kode_gejala', $gInfo['kode'])->first();
                    if ($gejala) {
                        RuleGejala::create([
                            'rule_id'    => $rule->id,
                            'gejala_id'  => $gejala->id,
                            'is_negated' => $gInfo['not'],
                        ]);
                    }
                }
            }
        }
    }
}
