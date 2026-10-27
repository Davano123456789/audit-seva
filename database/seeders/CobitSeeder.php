<?php

namespace Database\Seeders;

use App\Models\Domain;
use App\Models\ItProcess;
use App\Models\Practice;
use Illuminate\Database\Seeder;

/**
 * Data awal COBIT 2019 sesuai ruang lingkup proposal:
 * 3 domain (APO, BAI, DSS) dan 6 proses TI beserta management practice-nya.
 * Pertanyaan tidak di-seed, diinput lewat menu Data Master > Pertanyaan.
 */
class CobitSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->domains() as $domain) {
            Domain::updateOrCreate(['id' => $domain['id']], $domain);
        }

        foreach ($this->processes() as $process) {
            $practices = $process['practices'];
            unset($process['practices']);

            ItProcess::updateOrCreate(['code' => $process['code']], $process);

            foreach ($practices as $code => [$name, $description]) {
                Practice::updateOrCreate(
                    ['code' => $code],
                    ['process_code' => $process['code'], 'name' => $name, 'description' => $description]
                );
            }
        }
    }

    private function domains(): array
    {
        return [
            [
                'id' => 'APO',
                'name' => 'Align, Plan and Organize',
                'description' => 'Berfokus pada penyelarasan strategi TI dengan tujuan bisnis, serta perencanaan dan pengorganisasian sumber daya TI.',
            ],
            [
                'id' => 'BAI',
                'name' => 'Build, Acquire and Implement',
                'description' => 'Berfokus pada pengadaan, pembangunan, dan implementasi solusi TI serta pengelolaan perubahan dan aset.',
            ],
            [
                'id' => 'DSS',
                'name' => 'Deliver, Service and Support',
                'description' => 'Berfokus pada penyampaian layanan TI, operasional, dukungan, dan keamanan layanan.',
            ],
        ];
    }

    private function processes(): array
    {
        return [
            [
                'code' => 'APO07',
                'domain_id' => 'APO',
                'name' => 'Managed Human Resources',
                'description' => 'Pengelolaan SDM TI',
                'practices' => [
                    'APO07.01' => ['Acquire and maintain adequate and appropriate staffing', 'Memperoleh dan mempertahankan staf yang memadai dan sesuai'],
                    'APO07.02' => ['Identify key IT personnel', 'Mengidentifikasi personel TI kunci'],
                    'APO07.03' => ['Maintain the skills and competencies of personnel', 'Memelihara keterampilan dan kompetensi personel'],
                    'APO07.04' => ['Assess and recognize/reward employee job performance', 'Menilai serta memberi penghargaan atas kinerja pegawai'],
                    'APO07.05' => ['Plan and track the usage of IT and business human resources', 'Merencanakan dan memantau penggunaan SDM TI dan bisnis'],
                    'APO07.06' => ['Manage contract staff', 'Mengelola staf kontrak'],
                ],
            ],
            [
                'code' => 'APO12',
                'domain_id' => 'APO',
                'name' => 'Managed Risk',
                'description' => 'Pengelolaan Risiko TI',
                'practices' => [
                    'APO12.01' => ['Collect data', 'Mengumpulkan data risiko'],
                    'APO12.02' => ['Analyze risk', 'Menganalisis risiko'],
                    'APO12.03' => ['Maintain a risk profile', 'Memelihara profil risiko'],
                    'APO12.04' => ['Articulate risk', 'Mengomunikasikan risiko'],
                    'APO12.05' => ['Define a risk management action portfolio', 'Menetapkan portofolio tindakan pengelolaan risiko'],
                    'APO12.06' => ['Respond to risk', 'Merespons risiko'],
                ],
            ],
            [
                'code' => 'APO13',
                'domain_id' => 'APO',
                'name' => 'Managed Security',
                'description' => 'Pengelolaan Keamanan Informasi',
                'practices' => [
                    'APO13.01' => ['Establish and maintain an information security management system (ISMS)', 'Membangun dan memelihara sistem manajemen keamanan informasi (SMKI)'],
                    'APO13.02' => ['Define and manage an information security and privacy risk treatment plan', 'Menetapkan dan mengelola rencana penanganan risiko keamanan informasi dan privasi'],
                    'APO13.03' => ['Monitor and review the information security management system', 'Memantau dan meninjau sistem manajemen keamanan informasi'],
                ],
            ],
            [
                'code' => 'APO14',
                'domain_id' => 'APO',
                'name' => 'Managed Data',
                'description' => 'Pengelolaan Data',
                'practices' => [
                    'APO14.01' => ["Define and communicate the organization's data management strategy and roles and responsibilities", 'Menetapkan dan mengomunikasikan strategi, peran, dan tanggung jawab pengelolaan data'],
                    'APO14.02' => ['Define and maintain a consistent business glossary', 'Menetapkan dan memelihara glosarium bisnis yang konsisten'],
                    'APO14.03' => ['Establish the processes and infrastructure for metadata management', 'Membangun proses dan infrastruktur pengelolaan metadata'],
                    'APO14.04' => ['Define a data quality strategy', 'Menetapkan strategi kualitas data'],
                    'APO14.05' => ['Establish data profiling methodologies, processes and tools', 'Menetapkan metodologi, proses, dan alat profiling data'],
                    'APO14.06' => ['Ensure a data quality assessment approach', 'Memastikan pendekatan penilaian kualitas data'],
                    'APO14.07' => ['Define the data cleansing approach', 'Menetapkan pendekatan pembersihan data'],
                    'APO14.08' => ['Manage the life cycle of data assets', 'Mengelola siklus hidup aset data'],
                    'APO14.09' => ['Support data archiving and retention', 'Mendukung pengarsipan dan retensi data'],
                    'APO14.10' => ['Manage data backup and restore arrangements', 'Mengelola pencadangan dan pemulihan data'],
                ],
            ],
            [
                'code' => 'BAI09',
                'domain_id' => 'BAI',
                'name' => 'Managed Assets',
                'description' => 'Pengelolaan Aset TI',
                'practices' => [
                    'BAI09.01' => ['Identify and record current assets', 'Mengidentifikasi dan mencatat aset yang ada'],
                    'BAI09.02' => ['Manage critical assets', 'Mengelola aset kritis'],
                    'BAI09.03' => ['Manage the asset life cycle', 'Mengelola siklus hidup aset'],
                    'BAI09.04' => ['Optimize asset value', 'Mengoptimalkan nilai aset'],
                    'BAI09.05' => ['Manage licenses', 'Mengelola lisensi'],
                ],
            ],
            [
                'code' => 'DSS05',
                'domain_id' => 'DSS',
                'name' => 'Managed Security Services',
                'description' => 'Layanan Keamanan TI',
                'practices' => [
                    'DSS05.01' => ['Protect against malicious software', 'Melindungi dari perangkat lunak berbahaya (malware)'],
                    'DSS05.02' => ['Manage network and connectivity security', 'Mengelola keamanan jaringan dan konektivitas'],
                    'DSS05.03' => ['Manage endpoint security', 'Mengelola keamanan perangkat endpoint'],
                    'DSS05.04' => ['Manage user identity and logical access', 'Mengelola identitas pengguna dan akses logis'],
                    'DSS05.05' => ['Manage physical access to I&T assets', 'Mengelola akses fisik ke aset TI'],
                    'DSS05.06' => ['Manage sensitive documents and output devices', 'Mengelola dokumen sensitif dan perangkat output'],
                    'DSS05.07' => ['Manage vulnerabilities and monitor the infrastructure for security-related events', 'Mengelola kerentanan dan memantau infrastruktur terhadap kejadian keamanan'],
                ],
            ],
        ];
    }
}
