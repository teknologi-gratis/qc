<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kecamatan extends Model
{
    use Notifiable;

    protected $table = 'kecamatan';
    protected $fillable = [
        'id_kec', 'id_kab', 'nama'
    ];
    protected $primaryKey = 'id_kec';

    public static function rules($update = false, $id = null)
    {
        $commun = [
            'id_kec' => 'required|max:6|numeric',
            'id_kab' => 'required|max:4|numeric',
            'nama' => 'required|max:20|alpha'
            
            
        ];
        return $commun;
   }
}
