<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tps extends Model
{
    use Notifiable;

    protected $table = 'tps';
    protected $fillable = [
        'prov_id', 'kab_id', 'kec_id', 'kel_id', 'no_tps','total_suara',
         'suara_tidak_sah','threshold','id_pemilihan','saksi_id','lembaga_id','is_sample','images','jumlah_dpt','suara_tidak_digunakan'
    ];
    protected $primaryKey = 'id';

    public static function rules($update = false, $id = null)
    {
        $commun = [
            'id' => 'numeric',
            'total_suara' => 'numeric',
            'suara_tidak_sah' => 'numeric',

        ];
        return $commun;
   }

   public function provinsi(){
            return $this->hasOne('App\Provinsi', 'id_prov', 'prov_id');
        }

        function kabupaten(){
         return $this->hasOne('App\Kabupaten', 'id_kab', 'kab_id');
        }

        function kecamatan(){
         return $this->hasOne('App\Kecamatan', 'id_kec', 'kec_id');
        }

        function kelurahan(){
            return $this->hasOne('App\Kelurahan', 'id_kel', 'kel_id');
           }

        function lembaga_survey(){
            return $this->hasOne('App\Lembaga_survey', 'id', 'lembaga_id');
           }
}
