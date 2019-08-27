<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Calon extends Model
{
    use Notifiable;

    protected $table = 'calon';
    protected $fillable = [
        'pemilihan_id', 'lembaga_id', 'calon_utama_nama', 'calon_wakil_nama', 'calon_nomor_urut','gambar'
    ];
    protected $primaryKey = 'id';

    public static function rules($update = false, $id = null)
    {
        $commun = [
            'pemilihan_id' => 'required|max:11',
            'calon_utama_nama' => 'required',
            'calon_wakil_nama' => 'required',
            'calon_nomor_urut' => 'required|numeric',
        ];
        return $commun;
   }

//    public function provinsi(){
//         return $this->hasOne('App\Provinsi', 'id_prov', 'prov_id');
//    }

//    function kabupaten(){
//     return $this->hasOne('App\Kabupaten', 'id_kab', 'kab_id');
//    }

//    function kecamatan(){
//     return $this->hasOne('App\Kecamatan', 'id_kec', 'kec_id');
//    }
}


