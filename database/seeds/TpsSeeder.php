<?php

use App\User;
use App\Tps;
use App\Kelurahan;
use App\Kecamatan;
use App\Kabupaten;
use App\Pemilihan;
use App\Lembaga_survey;
use Illuminate\Database\Seeder;

class TpsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lembaga = Lembaga_survey::find(1);
        $pemilihan = Pemilihan::find();
        $saksi = User::whereRole(20)->inRandomOrder()->limit(1)->first();
        for ($i=0; $i < 135; $i++) {
            $kelurahan = Kelurahan::all()->random(1)->first();
            $kecamatan = Kecamatan::find($kelurahan->id_kec);
            $kabupaten = Kabupaten::find($kecamatan->id_kab);
            $dpt = rand(1000, 10000);
            $totalSuara = $dpt - rand(10,900);
            Tps::create([
                'kec_id' => $kecamatan->id_kec,
                'kel_id' => $kelurahan->id_kel,
                'kab_id' => $kabupaten->id_kab,
                'prov_id' => $kabupaten->id_prov,
                'total_suara' => $totalSuara,
                'jumlah_dpt' => $dpt,
                'suara_tidak_sah' => $dpt - $totalSuara,
                'lembaga_id' => $lembaga->id,
                'saksi_id' => $saksi->id,
                'id_pemilihan' => $pemilihan->id,
                'no_tps' => rand(1, 10),
                'images' => 'a'
            ]);
        }
    }
}
