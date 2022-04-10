<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obatalkes;
use App\Models\Signa;
use App\Models\Racikan;
use App\Models\Resep;
use App\Models\ResepDetail;

class ResepController extends Controller
{
    public function index(Request $request)
    {   
        $data['obat'] = Obatalkes::all();
        $data['obatRacik'] = Racikan::all();
        $data['signa'] = Signa::all();
        if ($request->input('ajax')=="yes") {
            return view('resep.index',['data' => $data]);
        }else{
            $pages = 'resep.index';
            return view('layout.content', ['konten' => $pages, 'data' => $data]);
        }
    }

    public function get_signa_racikan(Request $request)
    {
        $racikan_kode = $request->input('rako');
        $getSigna = Racikan::where('racikan_kode', $racikan_kode)->first();
        $sina = $getSigna->signa_nama ?? '';
        $siko = $getSigna->signa_kode ?? '';

        $darr = array('sina' => '' . $sina . '', 'siko' => '' . $siko . '');
        return response()->json($darr);
    }

    public function simpan_detail_resep(Request $request){
        $kode_resep = $request->input('kode_resep');

        $obat = $request->input('obat');
        $obat_nama = $request->input('obat_nama');
        $obat_signa = $request->input('obat_signa');
        $obat_signa_nama = $request->input('obat_signa_nama');
        $qty_obat = $request->input('qty_obat');

        $obat_racikan = $request->input('obat_racikan');
        $obat_racikan_nama = $request->input('obat_racikan_nama');
        $signa_obat_racikan = $request->input('signa_obat_racikan');
        $signa_obat_racikan_nama = $request->input('signa_obat_racikan_nama');
        $qty_obat_racikan = $request->input('qty_obat_racikan');

        $post = [
            ['kode_resep' => $kode_resep, 'obat_kode' => $obat, 'obat_nama' => $obat_nama, 'qty' => $qty_obat, 'signa_kode' => $obat_signa, 'signa_nama' => $obat_signa_nama ],
            ['kode_resep' => $kode_resep, 'obat_kode' => $obat_racikan, 'obat_nama' => $obat_racikan_nama, 'qty' => $qty_obat_racikan, 'signa_kode' => $signa_obat_racikan, 'signa_nama' => $signa_obat_racikan_nama ]
        ];

        // foreach($post as $key => $data){
        //     Resep::create($post);
        // }
        
        $cekStok = ResepDetail::where('kode_resep', $kode_resep)->where('obat_kode',$obat)->first();
        if($cekStok){
            return response()->json(['data'=>'sudah ada']);
        }else{
            $query = ResepDetail::insert($post);
            return true;
        }
        
        
    }

    public function simpan_resep(Request $request){
        $kode_resep = $request->input('kode_resep');
        $nama_resep = $request->input('nama_resep');

        $post = [
            'kode_resep' => $kode_resep,
            'nama_resep' => $nama_resep,
        ];

        $query = Resep::create($post);
        return true;
    }

    public function data_tabel_resep(Request $request){
        $data = Resep::all();

        return \DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('kode_resep', function($data){
            return $data->kode_resep;
        })
        ->addColumn('kode_nama', function($data){
            return $data->kode_nama;
        })
        ->rawColumns(['racikan_kode','racikan_nama'])
        ->make(true);
    }

    public function edit_resep(Request $request){
        $kode_resep = $request->input('kode_resep');

        $data['obat'] = Obatalkes::all();
        $data['obatRacik'] = Racikan::all();
        $data['signa'] = Signa::all();

        $getResep = Resep::where('kode_resep', $kode_resep)->first();
        $namaResep = $getResep->nama_resep ?? '';

        $form = view("resep.form_obat_resep", ['data' => $data, 'nama_resep' => $namaResep, 'kode_resep' => $kode_resep]);
        $darr = array('data' => '' . $form . '');
        return response()->json($darr);
    }


    public function data_tabel_resep_detail(Request $request){
        $kode_resep = $request->input('kode_resep');
        
        $data = ResepDetail::where('kode_resep',$kode_resep)->get();

        return \DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('qty', function($data){
            return $data->qty;
        })
        ->addColumn('obat_nama', function($data){
            return $data->obat_nama;
        })
        ->rawColumns(['obat_kode','qty'])
        ->make(true);
    }

    public function print_resep(Request $request){
        $kode_resep = $request->input('kode_resep');
        $getNama = Resep::where('kode_resep', $kode_resep)->first();
        $nama_resep = $getNama->nama_resep ?? '';

        $getDetail = ResepDetail::where('kode_resep', $kode_resep)->get();

        return view('resep.print', ['nama_resep' => $nama_resep, 'detail' => $getDetail]);
    }

    public function hapus_resep_detail(Request $request){
        $kode_resep = $request->input('kode_resep');
        $obat_kode = $request->input('obat_kode');

        $query = ResepDetail::where('kode_resep', $kode_resep)->where('obat_kode', $obat_kode)->delete();
        return $query;
    }

    public function hapus_resep(Request $request){
        $kode_resep = $request->input('kode_resep');

        $query = Resep::where('kode_resep', $kode_resep)->delete();
        // hapus detail resep yang bersangkutan
        ResepDetail::where('kode_resep', $kode_resep)->delete();
        return $query;
    }
}
