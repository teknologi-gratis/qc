<?php

namespace App\Imports;

use App\User;
use Maatwebsite\Excel\Concerns\ToModel;

class SaksiTpsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        //saksi modelnya di dalem user, soalnya user itu ya semua user ambar jadiin satu
        return new User([
            'id' =>$row[0],
            'nama'=>$row[1],
            'email'=>$row[2],
            'email_verified_at'=>$row[3],
            'password'=>$row[4],
            //'avatar'=>$row[5],
            'role'=>$row[6],
            'id_pemilihan'=>$row[7],
            'lembaga_id'=>$row[8],
            'nik'=>$row[9],
            'kontak'=>$row[10],
            'no_tps'=>$row[11],
            'bio'=>$row[12],
            'remember_token'=>$row[13],
            'created_at'=>$row[14],
            'updated_at'=>$row[15],
        ]);
    }
}
