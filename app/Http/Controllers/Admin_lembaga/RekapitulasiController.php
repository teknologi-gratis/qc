<?php

namespace App\Http\Controllers\Admin_lembaga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Lembaga_survey;
use App\Provinsi;
use App\Kabupaten;
use App\Kecamatan;
use App\Kelurahan;
use App\Pemilihan;
use App\Calon;
use App\Suara;
use App\Tps;
use DB;
use Auth;

class RekapitulasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pemilihan = Pemilihan::whereLembagaId(Auth::user()->lembaga_id)->latest('updated_at')->get();
        $provinsi = Provinsi::select('nama', 'id_prov')->get();
        $tahun = [];
        foreach ($pemilihan as $value) {
            $tahun[] = $value->tahun;
        }
        $tahun = array_unique($tahun);

        return view('admin_lembaga.rekapitulasi.index', compact('provinsi', 'pemilihan', 'tahun'));
    }

    public function filter(Request $request)
    {
        $result = [];
        $totalSuara = 0;
        $code = 200;
        $suaraTiapTPS = [];
        $totalSuaraTiapCalon = [];
        $pemilihan = Pemilihan::whereLembagaId(Auth::user()->lembaga_id)
          ->whereProvId($request->provinsi)
          ->whereTahun($request->tahun)
          ->first();

        if (! is_null($pemilihan)) {
            $semuaCalon = Calon::wherePemilihanId($pemilihan->id)->get();
            $tps = Tps::whereProvId($request->provinsi)->whereIdPemilihan($pemilihan->id);
            if ($request->filter == 'kabupaten' && $request->has('kabupaten')) {
                $tps = $tps->whereKabId($request->kabupaten);
            }
            if ($request->filter == 'kecamatan' && $request->has('kecamatan')) {
                $tps = $tps->whereKecId($request->kecamatan);
            }
            if ($request->filter == 'kelurahan' && $request->has('kelurahan')) {
                $tps = $tps->whereKelId($request->kelurahan);
            }
            $tps = $tps->get();

            if (! is_null($tps)) {
                $suaraTotalTiapCalon = [];
                foreach ($tps as $key => $row) {
                    $totalSuaraPerTPS = 0;
                    $suaraTiapCalon = [];
                    foreach ($semuaCalon as $calon) {
                        $calonId = intval($calon->id);
                        $suara = Suara::whereCalonId($calonId)->whereTpsId($row->id)->first();
                        if (! is_null($suara)) {
                            $totalSuaraPerTPS += $suara->total_suara;
                            if (isset($suaraTiapCalon[$calonId])) {
                                $suaraTiapCalon[$calonId] += $suara->total_suara;
                            } else {
                                $suaraTiapCalon[$calonId] = $suara->total_suara ?? 0;
                            }
                            if (! isset($totalSuaraTiapCalon[$calonId]['nama_pasangan'])) {
                                $totalSuaraTiapCalon[$calonId]['nama_pasangan'] = $calon->calon_utama_nama . ' & ' . $calon->calon_wakil_nama;
                            }
                            if (isset($totalSuaraTiapCalon[$calonId]['total_suara'])) {
                                $total = $totalSuaraTiapCalon[$calonId]['total_suara'];
                                $total += $suaraTiapCalon[$calonId];
                            } else {
                                $totalSuaraTiapCalon[$calonId]['total_suara'] = array_key_exists($calonId, $suaraTiapCalon) ? $suaraTiapCalon[$calonId] : 0;
                            }
                            if (isset($suaraTotalTiapCalon[$calonId])) {
                                $suaraTotalTiapCalon[$calonId] += $suara->total_suara;
                            } else {
                                $suaraTotalTiapCalon[$calonId] = $suara->total_suara ?? 0;
                            }
                        } else {
                              $totalSuaraPerTPS += 0;
                              if (isset($suaraTiapCalon[$calonId])) {
                                  $suaraTiapCalon[$calonId] += 0;
                              } else {
                                  $suaraTiapCalon[$calonId] = 0;
                              }
                              if (! isset($totalSuaraTiapCalon[$calonId]['nama_pasangan'])) {
                                  $totalSuaraTiapCalon[$calonId]['nama_pasangan'] = $calon->calon_utama_nama . ' & ' . $calon->calon_wakil_nama;
                              }
                              if (isset($totalSuaraTiapCalon[$calonId]['total_suara'])) {
                                  $total = $totalSuaraTiapCalon[$calonId]['total_suara'];
                                  $total += $suaraTiapCalon[$calonId];
                              } else {
                                  $totalSuaraTiapCalon[$calonId]['total_suara'] = 0;
                              }
                              if (isset($suaraTotalTiapCalon[$calonId])) {
                                  $suaraTotalTiapCalon[$calonId] += 0;
                              } else {
                                  $suaraTotalTiapCalon[$calonId] = 0;
                              }
                        }
                    }
                    $totalSuara += $totalSuaraPerTPS;
                    $suaraTiapTPS['TPS_' . $row->id] = $suaraTiapCalon;
                }
                $result = [
                    'total' => $suaraTotalTiapCalon,
                    'total_suara_tiap_calon' => $suaraTotalTiapCalon,
                    'total_suara' => $totalSuara,
                    'suara' => $suaraTiapTPS,
                    'calon' => $semuaCalon
                ];
            } else {
                $result = [
                    'message' => 'Tidak ada TPS.'
                ];
                $code = 404; // Not found
            }
        } else {
            $result = [
                'message' => 'Tidak ada data.'
            ];
            $code = 404; // Not found
        }

        return response()->json($result, $code);
    }
}
