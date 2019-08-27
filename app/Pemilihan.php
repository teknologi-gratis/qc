<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pemilihan extends Model
{
    use Notifiable;

    protected $table = 'pemilihan';
    protected $fillable = [
        'id','jenis','tahun', 'prov_id', 'kab_id','lembaga_id'
    ];
    protected $primaryKey = 'id';

    public static function rules($update = false, $id = null)
    {
        $commun = [
            'tahun' => 'required|max:4'
            
        ];
        return $commun;
   }

   public function provinsi(){
        return $this->hasOne('App\Provinsi', 'id_prov', 'prov_id');
   }

   function kabupaten(){
    return $this->hasOne('App\Kabupaten', 'id_kab', 'kab_id');
   }

}


