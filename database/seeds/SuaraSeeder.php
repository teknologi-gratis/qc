<?php

use Illuminate\Database\Seeder;
use App\Suara;
use App\Tps;
use App\Calon;

class SuaraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $jum_tps = 518;
        $dataSuara = [];
        $data_tps = [];
        for($i = 1; $i<=$jum_tps; $i++){
            $suara1 = rand(0, 50);
            $suara2 = rand(0, 50);
            $total_suara = $suara1 + $suara2;
            $calon1 =  [
                'total_suara' => $suara1,
                'calon_id' => 1,
                'tps_id' => $i
            ];
            $calon2 = [
                'total_suara' => $suara2,
                'calon_id' => 2,
                'tps_id' => $i
            ];
            $tps = [
                'id' => $i,
                'total_suara' => $total_suara
            ];

            array_push($dataSuara, $calon1);
            array_push($dataSuara, $calon2);
            array_push($data_tps, $tps);
        }

        foreach($dataSuara as $ds){
            $tps = Tps::find($ds['tps_id']);
            if($tps){
                Suara::create($ds);
            }
        }
        
        foreach($data_tps as $dt){
            $tps = Tps::find($dt['id']);
            if($tps){
                $tps->update($dt);
            }
        }
    }
}
