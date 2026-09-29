<?php

namespace Database\Seeders;

use App\Models\CertificateTemplate;
use Illuminate\Database\Seeder;

class CertificateTemplateSeeder extends Seeder
{
    public function run(): void
    {
        if (CertificateTemplate::count() === 0) {
            CertificateTemplate::create(CertificateTemplate::getDefaultAttributes());
        }
    }
}
