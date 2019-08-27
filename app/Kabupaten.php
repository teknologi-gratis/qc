<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kabupaten extends Model
{
    use Notifiable;

    protected $table = 'kabupaten';
    protected $fillable = [
        'id_kab', 'id_prov', 'nama', 'id_jenis'
    ];
    protected $primaryKey = 'id_kab';

    public static function rules($update = false, $id = null)
    {
        $commun = [
            'id_kab' => 'required|max:4|numeric',
            'id_prov' => 'required|max:2|numeric',
            'nama' => 'required|max:20|alpha',
            'id_jenis' => 'required|max:11|numeric'
            
        ];
        return $commun;
   }
}
