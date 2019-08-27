<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Provinsi extends Model
{
    use Notifiable;

    protected $table = 'provinsi';
    protected $fillable = [
        'id_prov', 'nama'
    ];
    protected $primaryKey = 'id_prov';

    public static function rules($update = false, $id = null)
    {
        $commun = [
            'id_prov' => 'required|max:2|numeric',
            'nama' => 'required|max:20|alpha',
            
        ];
        return $commun;
   }
}
