<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Suara;
use App\Calon;
use App\Tps;
// use DB;
use Illuminate\Support\Facades\DB;

class ControllerLogin extends Controller
{
    public function Loginsaksi(Request $request){
        $this->validate($request, [
            $email = $request->input('email'),
            $password = $request->input('password')
            ]);
            $role = 20;

            $data = \App\User::where('email', $email)
            ->where('password', md5($password))->where('role',$role)->get();
    if(count($data) > 0){ //mengecek apakah data kosong atau tidak
      $res['status'] = true;
      $res['code'] = 200;
      $res['message'] = "Success!";
        $res['data'] = $data;
        return response($res);
    }else{
        $res['status'] = false;
        $res['code'] = 400;
          $res['message'] = "no";
          return response($res);
      }
    }

    public function InputSuara(Request $request){
      $this->validate($request, [
        $calon_id = $request->input('calon_id'),
        $prov_id = $request->input('prov_id'),
        $kab_id = $request->input('kab_id'),
        $kec_id = $request->input('kec_id'),
        $kel_id = $request->input('kel_id'),
        $total_suara = $request->input('total_suara'),
        $suara_tidak_sah = $request->input('suara_tidak_sah'),
        $saksi_id = $request->input('saksi_id'),
        ]);

        $datainsert = array(
          'calon_id' => $calon_id,
          'prov_id' => $prov_id,
          'kab_id' => $kab_id,
          'kec_id' => $kec_id,
          'kel_id' => $kel_id,
          'total_suara' => $total_suara,
          'suara_tidak_sah' => $suara_tidak_sah,
          'saksi_id' => $saksi_id
        );

        Suara::create($datainsert);
        return response()->json(array('status'=>200,'data'=>'No Data', 'message'=>'Sukses!'));
    }

    public function TampilCalon(Request $request){
      $this->validate($request, [
        $lembaga_id = $request->input('lembaga_id')
        ]);

        $dataCalon = Calon::where('lembaga_id', $lembaga_id)->get()->all();

        if(count($dataCalon)>0){

          $respon = array('status'=>200,'data'=>$dataCalon,'message'=>'OK!');
          return response()->json($respon);
        } else {
          $respon = array('status'=>400,'data'=>'No Data','message'=>'OK!');
          return response()->json($respon);
        }
    }
    

    public function updateDataTpsSuara(Request $request){

        $suarasah = $request->suarasah;
        $suaratidaksah = $request->suaratidaksah;
        $idtps = $request->idtps;
        $dpt = $request->dpt;
        $c1 = $request->imagesc1;
        // echo str_replace(' ', '+',$c1);
        // die;
        // dd($request);




        $tmp = tempnam('./tmp_c1', 'imgprotmp_');
        file_put_contents($tmp, base64_decode(str_replace(' ', '+',$c1)));
        $imginf = getimagesize($tmp);

        chmod($tmp, 0777); //chg permission
        // die();
        // $_FILES['userfile'] = array(
        //     'name' => uniqid().'.'.preg_replace('!\w+/!', '', $imginf['mime']), //uniqid() generate name, preg_...']) Get image name property
        //     'tmp_name' => $tmp, //temp file directory
        //     'size'  => filesize($tmp), //get size file
        //     'error' => UPLOAD_ERR_OK, //dont delete
        //     'type'  => $imginf['mime'], //its is png/jpg or other?
        //     );

        $name = md5(time()+$suarasah+$suaratidaksah);
        $type = image_type_to_extension($imginf[2]);
        rename($tmp, "./c1/$name$type");



        $array = [
            'id'=>$idtps,
            'total_suara'=>$suarasah,
            'suara_tidak_sah'=>$suaratidaksah,
            'images'=> "$name$type",
            'jumlah_dpt'=>$dpt
        ];

        DB::table('tps')->where('id',$idtps)->update($array);

        $respon = array('status'=>200,'data'=>'No Data','message'=>'Data Sukses Diupdate!');
        return response()->json($respon);

    }

    public function updatesuaracalon(Request $request){

        $idcalon = $request->idcalon;
        $idtps = $request->idtps;
        $totalsuara = $request->totalsuara;
        $dataar = [
            'total_suara'=>$totalsuara,
            'calon_id'=>$idcalon,
            'tps_id'=>$idtps
        ];

        if (DB::table('suara')->where('tps_id', '=', $idtps)->where('calon_id','=',$idcalon)->exists()) {
            // user found
            DB::table('suara')->where('tps_id',$idtps)->where('calon_id', $idcalon)->update($dataar);
            $respon = array('status'=>200,'data'=>'No Data','message'=>'Data Sukses Diupdate!');
            return response()->json($respon);
         } else {
            DB::table('suara')->insert($dataar);
            $respon = array('status'=>200,'data'=>'No Data','message'=>'Data Sukses Diupdate!');
            return response()->json($respon);
         }

    }
}
