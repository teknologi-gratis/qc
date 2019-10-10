<?php

namespace App\Http\Controllers\Admin_lembaga;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\TpsImport;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use App\Pemilihan;
use App\User;
use App\Tps;
use App\Provinsi;
use App\Kabupaten;
use App\Kecamatan;
use App\Kelurahan;
use Auth;

class TpsPemilihanController extends Controller
{
    public function tpss_import(request $request)
	{
		// validasi
		$this->validate($request, [
			'file' => 'required|mimes:csv,xls,xlsx'
		]);

		// menangkap file excel
		$file = $request->file('file');

		// membuat nama file unik
		$nama_file = rand().$file->getClientOriginalName();

		// upload ke folder file_siswa di dalam folder public
		$file->move('file_tps',$nama_file);

		// import data
        Excel::import(new TpsImport, public_path('/file_tps/'.$nama_file));

		// notifikasi dengan session
		Session::flash('sukses','Data Tps Berhasil Diimport!');

		// alihkan halaman kembali
		return redirect()->route('tpsPemilihan', $request->id);
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $lembagaId = Auth::user()->lembaga_id;
        $pemilihan = Pemilihan::findOrFail($id);
        // dd(Kecamatan::all()->random());
        $allTps = Tps::whereIdPemilihan($pemilihan->id)->whereLembagaId($lembagaId)->get();
        return view('admin_lembaga.tps_pemilihan.index', compact('allTps', 'pemilihan', 'id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $pemilihan = Pemilihan::findOrFail($id);
        $provinsi=Provinsi::all();
        $kabupaten=Kabupaten::all();
        $kecamatan=Kecamatan::all();
        $saksis=User::where('role', 20)->where('lembaga_id', Auth::user()->lembaga_id)->get();
        $provinsi_untuk_select2 = $kabupaten_untuk_select2 = $kecamatan_untuk_select2 = $saksi_untuk_select2 = array();

        foreach($provinsi as $item){
            $provinsi_untuk_select2[$item->id_prov] = $item->nama;
        }
        foreach($kabupaten as $item){
            $kabupaten_untuk_select2[$item->id_kab] = $item->nama;
        }
        foreach($kecamatan as $item){
            $kecamatan_untuk_select2[$item->id_kec] = $item->nama;
        }
        // foreach($saksis as $item){
        //     $saksi_untuk_select2[$item->id] = $item->nama;
        // }
        return view('admin_lembaga.tps_pemilihan.create', compact('id','pemilihan','provinsi_untuk_select2','kabupaten_untuk_select2','kecamatan_untuk_select2','saksi_untuk_select2'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, Tps::rules());

        Tps::create($request->all());

        return back()->withSuccess(trans('app.success_store'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $item = TPS::findOrFail($id);
        $provinsi=Provinsi::all()->toArray();
        $kabupaten=Kabupaten::where('id_prov',$item->prov_id)->get()->toArray();
        $kecamatan=Kecamatan::where('id_kab',$item->kab_id)->get()->toArray();
        $kelurahan=Kelurahan::where('id_kec',$item->kec_id)->get()->toArray();
        $saksis=User::where('role', 20)->where('lembaga_id', Auth::user()->lembaga_id)->get();
        $provinsi_untuk_select2 = array();
        $kabupaten_untuk_select2 = array();
        $kecamatan_untuk_select2 = array();
        $kelurahan_untuk_select2 = array();
        $saksi_untuk_select2 = array();
        foreach($provinsi as $itemz){
            $provinsi_untuk_select2[$itemz['id_prov']] = $itemz['nama'];
        }
        foreach($kabupaten as $itemc){
            $kabupaten_untuk_select2[$itemc['id_kab']] = $itemc['nama'];
        }
        foreach($kecamatan as $itemd){
            $kecamatan_untuk_select2[$itemd['id_kec']] = $itemd['nama'];
        }
        foreach($kelurahan as $iteme){
            $kelurahan_untuk_select2[$iteme['id_kel']] = $iteme['nama'];
        }
        foreach($saksis as $itemf){
            $saksi_untuk_select2[$itemf['id']] = $itemf['nama'];
        }
        return view('admin_lembaga.tps_pemilihan.edit', compact('item','id','provinsi_untuk_select2','kabupaten_untuk_select2','kecamatan_untuk_select2','kelurahan_untuk_select2','saksi_untuk_select2'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, TPS::rules(true, $id));

        $item = TPS::findOrFail($id);
        $item->update($request->except('id_pemilihan'));

        return redirect()->back()->withSuccess(trans('app.success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Tps::destroy($id);
        return back()->withSuccess(trans('app.success_destroy'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'threshold' => ['required']
        ]);

        $code = 200; // default code
        $result = collect([]); // membuat object laravel collections
        $lembaga_id = Auth::user()->lembaga_id;
        $pemilihan = Pemilihan::findOrFail($request->id);
        if ($pemilihan->jenis == 'gubernur') {
            $daerah = Kabupaten::whereIdProv($pemilihan->prov_id)->get();
        } else {
            $daerah = Kecamatan::whereIdKab($pemilihan->kab_id)->get();
        }
        $total = collect([]);
        foreach ($daerah as $key => $item) {
            if ($pemilihan->jenis == 'gubernur') {
                $allTps = Tps::whereIdPemilihan($pemilihan->id)
                    ->whereLembagaId($lembaga_id)
                    ->whereKabId($item->id_kab)
                    ->get();
            } else {
                $allTps = Tps::whereIdPemilihan($pemilihan->id)
                    ->whereLembagaId($lembaga_id)
                    ->whereKecId($item->id_kec)
                    ->get();
            }
            $resultTemp = collect([]);
            if (! is_null($allTps)) {
                $populasi = $allTps->count();
                if ($populasi == 0) {
                  continue;
                }
                $threshold = $request->threshold * $request->threshold;
                $temp = round($populasi / (1 + ($populasi * $threshold)));
                $jumlahSampel = $temp > 0 ? $temp : 1;
                $interval = round($populasi / $jumlahSampel);
                for($i = 0; $i < $populasi; $i++){
                    if ($resultTemp->count() == $jumlahSampel) {
                        break;
                    }
                    if($i % $interval == 0) {
                        $data['id'] = $allTps[$i]->id;
                        $data['no_tps'] = $allTps[$i]->no_tps;
                        $data['provinsi'] = $allTps[$i]->provinsi->nama;
                        $data['kabupaten'] = $allTps[$i]->kabupaten->nama;
                        $data['kecamatan'] = $allTps[$i]->kecamatan->nama;
                        $data['kelurahan'] = $allTps[$i]->kelurahan->nama;
                        $data['total_suara'] = $allTps[$i]->total_suara;
                        $data['suara_tidak_sah'] = $allTps[$i]->suara_tidak_sah;
                        $data['suara_tidak_digunakan'] = $allTps[$i]->suara_tidak_digunakan;
                        $data['jumlah_dpt'] = $allTps[$i]->total_suara + $allTps[$i]->suara_tidak_sah + $allTps[$i]->suara_tidak_digunakan;
                        $resultTemp->push($data);
                    }
                    $total->push(['populasi' => $populasi, 'jumlah_sampel_seharusnya' => $jumlahSampel, 'interval' => $interval, 'jumlah_sampel_diambil' => $resultTemp->count(), 'populasi_ke' => ($i+1)]);
                }
                $result->push($resultTemp->toArray());
            }
        }
        $message = 'Pengambilan sampel berhasil.';
        return response()->json([
            'message' => $message,
            'data' => $result->collapse()
        ], $code);
    }
}
