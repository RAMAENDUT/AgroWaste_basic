<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    public function run(): void
    {
        Module::create([
            'title' => 'Pengenalan Limbah Pertanian',
            'slug' => 'pengenalan-limbah-pertanian',
            'description' => 'Pelajari dasar-dasar limbah pertanian dan potensi pemanfaatannya',
            'content' => '<h2>Pengenalan Limbah Pertanian</h2>
<p>Limbah pertanian adalah sisa hasil kegiatan pertanian yang tidak dimanfaatkan secara optimal. Limbah ini sebenarnya memiliki potensi besar untuk diolah menjadi produk berguna.</p>

<h3>Jenis-Jenis Limbah Pertanian</h3>
<ul>
    <li><strong>Limbah Jerami:</strong> Sisa panen padi yang dapat diolah menjadi pupuk kompos atau pakan ternak</li>
    <li><strong>Limbah Tongkol Jagung:</strong> Dapat dimanfaatkan untuk media tanam jamur atau pakan ternak</li>
    <li><strong>Limbah Kulit Kacang:</strong> Bisa diolah menjadi pupuk organik yang kaya nutrisi</li>
    <li><strong>Limbah Batang dan Daun:</strong> Sangat baik untuk pembuatan kompos</li>
</ul>

<h3>Manfaat Mengolah Limbah Pertanian</h3>
<ol>
    <li>Mengurangi pencemaran lingkungan</li>
    <li>Menghasilkan produk bernilai ekonomis</li>
    <li>Meningkatkan pendapatan petani</li>
    <li>Mendukung pertanian berkelanjutan</li>
</ol>

<h3>Potensi Ekonomi</h3>
<p>Dengan pengolahan yang tepat, limbah pertanian dapat menghasilkan:</p>
<ul>
    <li>Pupuk organik berkualitas tinggi</li>
    <li>Pakan ternak yang bergizi</li>
    <li>Bahan bakar alternatif (biogas)</li>
    <li>Media tanam yang subur</li>
</ul>',
            'order' => 1,
            'is_active' => true,
            'duration_minutes' => 30,
        ]);

        Module::create([
            'title' => 'Pembuatan Pupuk Kompos',
            'slug' => 'pembuatan-pupuk-kompos',
            'description' => 'Teknik dan cara membuat pupuk kompos dari limbah pertanian',
            'content' => '<h2>Pembuatan Pupuk Kompos dari Limbah Pertanian</h2>
<p>Pupuk kompos adalah pupuk organik hasil penguraian bahan-bahan organik oleh mikroorganisme. Kompos sangat bermanfaat untuk menyuburkan tanah.</p>

<h3>Bahan-Bahan yang Diperlukan</h3>
<ul>
    <li>Limbah pertanian (jerami, daun, batang tanaman) - 100 kg</li>
    <li>Kotoran hewan - 25 kg</li>
    <li>EM4 atau aktivator kompos - 1 liter</li>
    <li>Air secukupnya</li>
    <li>Dedak atau bekatul - 5 kg</li>
</ul>

<h3>Langkah-Langkah Pembuatan</h3>
<ol>
    <li><strong>Persiapan Bahan:</strong> Cacah limbah pertanian hingga ukuran 2-5 cm untuk mempercepat proses pengomposan</li>
    <li><strong>Pencampuran:</strong> Campurkan semua bahan secara merata, siram dengan larutan EM4 yang sudah dicampur air</li>
    <li><strong>Penyusunan Tumpukan:</strong> Susun campuran dengan tinggi sekitar 1 meter, bentuk menyerupai gunung</li>
    <li><strong>Penutupan:</strong> Tutup tumpukan dengan terpal atau karung goni untuk menjaga kelembaban</li>
    <li><strong>Pembalikan:</strong> Balik tumpukan setiap 3-4 hari sekali untuk aerasi</li>
    <li><strong>Pemantauan:</strong> Jaga kelembaban sekitar 50-60%, jika terlalu kering siram dengan air</li>
    <li><strong>Panen:</strong> Setelah 3-4 minggu, kompos siap digunakan (berwarna coklat kehitaman, berbau tanah)</li>
</ol>

<h3>Tips Keberhasilan</h3>
<ul>
    <li>Perbandingan bahan hijau dan coklat harus seimbang (1:2)</li>
    <li>Jaga kelembaban tetap stabil</li>
    <li>Pastikan aerasi cukup dengan pembalikan rutin</li>
    <li>Suhu ideal pengomposan 40-60°C</li>
</ul>',
            'order' => 2,
            'is_active' => true,
            'duration_minutes' => 45,
        ]);

        Module::create([
            'title' => 'Pengolahan Pakan Ternak',
            'slug' => 'pengolahan-pakan-ternak',
            'description' => 'Cara mengolah limbah pertanian menjadi pakan ternak berkualitas',
            'content' => '<h2>Pengolahan Limbah Pertanian Menjadi Pakan Ternak</h2>
<p>Limbah pertanian seperti jerami, tongkol jagung, dan dedak dapat diolah menjadi pakan ternak yang bergizi dan ekonomis.</p>

<h3>Jenis Pakan dari Limbah</h3>
<ul>
    <li><strong>Silase:</strong> Fermentasi hijauan pakan dalam kondisi anaerob</li>
    <li><strong>Hay:</strong> Hijauan pakan yang dikeringkan</li>
    <li><strong>Pakan Fermentasi:</strong> Pakan yang difermentasi dengan probiotik</li>
    <li><strong>Pakan Konsentrat:</strong> Campuran limbah dengan nilai gizi tinggi</li>
</ul>

<h3>Pembuatan Pakan Fermentasi</h3>
<p><strong>Bahan-bahan:</strong></p>
<ul>
    <li>Jerami padi atau tongkol jagung cacah - 100 kg</li>
    <li>Dedak halus - 10 kg</li>
    <li>Molases atau gula merah - 2 kg</li>
    <li>EM4 atau probiotik - 500 ml</li>
    <li>Air bersih - 30-40 liter</li>
    <li>Garam - 200 gram</li>
</ul>

<p><strong>Cara Pembuatan:</strong></p>
<ol>
    <li>Cacah jerami atau tongkol jagung hingga ukuran 3-5 cm</li>
    <li>Larutkan molases, EM4, dan garam dalam air</li>
    <li>Campurkan semua bahan, siram dengan larutan secara merata</li>
    <li>Masukkan dalam drum atau kantong plastik, padatkan dan tutup rapat</li>
    <li>Fermentasi selama 7-14 hari</li>
    <li>Pakan siap diberikan dengan bau harum khas fermentasi</li>
</ol>

<h3>Keuntungan Pakan Fermentasi</h3>
<ul>
    <li>Nilai gizi lebih tinggi</li>
    <li>Mudah dicerna ternak</li>
    <li>Dapat disimpan lebih lama</li>
    <li>Menghemat biaya pakan hingga 30-40%</li>
    <li>Meningkatkan produktivitas ternak</li>
</ul>',
            'order' => 3,
            'is_active' => true,
            'duration_minutes' => 40,
        ]);
    }
}
