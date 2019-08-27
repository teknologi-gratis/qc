<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Suara extends Model
{
    use Notifiable;

    protected $table = 'suara';
    protected $fillable = [
        'total_suara','tps_id','calon_id'
    ];
    protected $primaryKey = 'id';

    public static function rules($update = false, $id = null)
    {
        $commun = [
            'id' => 'numeric',
            'total_suara' => 'numeric',
            

        ];
        return $commun;
   }

//    public function provinsi(){
//             return $this->hasOne('App\Provinsi', 'id_prov', 'prov_id');
//         }

//         function kabupaten(){
//          return $this->hasOne('App\Kabupaten', 'id_kab', 'kab_id');
//         }

//         function kecamatan(){
//          return $this->hasOne('App\Kecamatan', 'id_kec', 'kec_id');
//         }

//         function kelurahan(){
//             return $this->hasOne('App\Kelurahan', 'id_kel', 'kel_id');
//            }

}
