<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kelurahan extends Model
{
    use Notifiable;

    protected $table = 'kelurahan';
    protected $fillable = [
        'id_kel', 'id_kac', 'nama'
    ];
    protected $primaryKey = 'id_kec';

    public static function rules($update = false, $id = null)
    {
        $commun = [
            'id_kel' => 'required|max:10|numeric',
            'id_kec' => 'required|max:6|numeric',
            'nama' => 'required|max:20|alpha'
            
            
        ];
        return $commun;
   }
}
