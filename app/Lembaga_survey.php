<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Lembaga_survey extends Model
{
    use Notifiable;

    protected $table = 'lembaga_survey';
    protected $fillable = [
        'nama', 'prov_id', 'kab_id', 'kec_id', 'alamat', 'kontak', 'status', 'jenis'
    ];
    protected $primaryKey = 'id';

    public static function rules($update = false, $id = null)
    {
        $commun = [
            'nama' => 'required|max:100',
            'prov_id' => 'required|numeric',
            'kab_id' => 'required|numeric',
            'kec_id' => 'numeric',
            'kontak' => 'required|max:50',
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
}


