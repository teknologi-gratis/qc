<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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

        // $this->validate($request, [
        //       'email'     => 'required|email',
        //       'password'  => 'required|min:3'
        //     ]);
        // $superadmin_data =  array(
        //       'email'     => $request->get('email'),
        //       'password'  => $request->get('password')
        //        );
        // $email = $superadmin_data['email'];
        // $password = bcrypt($superadmin_data['password']);

            $role = 20;
            // $bcrypt = new Bcrypt(16);
            // $password1 = $bcrypt->hash($password);

            $data = DB::table('users')
            ->join('tps','users.id','=','tps.saksi_id')
            ->where('users.email', $email)
            ->where('users.role',$role)
            ->select('users.*','tps.jumlah_dpt','tps.id AS id_tps')
            ->get();
    if(count($data) > 0){ //mengecek apakah data kosong atau tidak
      foreach ($data as $value) {
        // code...
        if (password_verify($password, $value->password)) {
          // code...
          $res['status'] = true;
          $res['code'] = 200;
          $res['message'] = "Success!";
          $res['data'] = $data;
          return response($res);
        } else {
          $res['status'] = false;
          $res['code'] = 400;
          // $res['contoh'] = $password;
          $res['message'] = "Password Salah Goblok";
          return response($res);
        }

      }
    }else{
        $res['status'] = false;
        $res['code'] = 400;
        // $res['contoh'] = $password;
          $res['message'] = "no";
          return response($res);
      }

    //   if(count($data) > 0){ //mengecek apakah data kosong atau tidak
    //     if(Hash::check($password, $data->password)){
    //       $res['status'] = true;
    //       $res['code'] = 200;
    //       $res['message'] = "Success!";
    //       $res['data'] = $data;
    //       return response($res);
    //
    //     } else {
    //
    //       $res['status'] = false;
    //       $res['code'] = 400;
    //       $res['message'] = "no";
    //       return response($res);
    //     }
    // }

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
        $lembaga_id = $request->input('lembaga_id'),
        $tps_id = $request->input('tps_id')
        ]);

        $dataCalon = Calon::where('lembaga_id', $lembaga_id)->get()->all();
        //
        // $data = DB::table('users')
        // ->join('tps','users.id','=','tps.saksi_id')
        // ->where('users.email', $email)
        // ->where('users.password', md5($password))
        // ->where('users.role',$role)
        // ->select('users.*','tps.jumlah_dpt')
        // ->get();

        // $dataCalon = DB::table('calon')
        // ->join('suara','calon.id','=','suara.calon_id')
        // ->where('calon.lembaga_id', $lembaga_id)
        // ->where('suara.tps_id', $tps_id)
        // ->select('calon.*','suara.total_suara')
        // ->get();

        if(count($dataCalon)>0){

          // $respon = array('status'=>200,'data'=>$dataCalon,'message'=>'OK!');
          // return response()->json($respon);
          $res['status'] = 200;
          // $res['code'] = 200;
          $res['data'] = $dataCalon;
          $res['message'] = "Success!";
          return response($res);
        } else {
          $respon = array('status'=>400,'data'=>'No Data','message'=>'NO!');
          return response()->json($respon);
        }
    }


    public function updateDataTpsSuara(Request $request){

        $idtps = $request->id;
        $suarasah = $request->suarasah;
        $suaratidaksah = $request->suaratidaksah;
        $notps = $request->idtps;
        $dpt = $request->dpt;
        $tidakdigunakan = $request->tidakdigunakan;
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
        rename($tmp, "./tmp_c1/$name$type");



        $array = [
            'no_tps'=>$notps,
            'total_suara'=>$suarasah,
            'suara_tidak_sah'=>$suaratidaksah,
            'suara_tidak_digunakan'=>$tidakdigunakan,
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
