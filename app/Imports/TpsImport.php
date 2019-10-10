<?php

namespace App\Imports;

use App\Tps;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class TpsImport implements ToModel, WithCalculatedFormulas
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Tps([
            'prov_id'=> $row[0],
            'kab_id'=> $row[1],
            'kec_id'=> $row[2],
            'kel_id'=> $row[3],
            'id_pemilihan'=> $row[4],
            'no_tps'=> $row[5],
            'jumlah_dpt' => $row[6],
            'total_suara'=> $row[7],
            'suara_tidak_sah'=> $row[8],
            'suara_tidak_digunakan'=> $row[9],
            'lembaga_id'=> $row[10],

        ]);
    }
}
