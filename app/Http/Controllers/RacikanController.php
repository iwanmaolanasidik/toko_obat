<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Racikan;
use App\Models\Obatalkes;
use App\Models\KomposisiObat;
use App\Models\Signa;

class RacikanController extends Controller
{
    public function index(Request $request)
    {   
        $data['obat'] = Obatalkes::all();
        $data['signa'] = Signa::all();
        if ($request->input('ajax')=="yes") {
            return view('racikan.index',['data'=>$data]);
        }else{
            $pages = 'racikan.index';
            return view('layout.content', ['konten' => $pages, 'data'=>$data]);
        }
    }

    public function create(Request $request){
        $racikan_kode = $request->input('rako');
        $racikan_nama = $request->input('rana');
        $signa_kode = $request->input('siko');
        $signa_nama = $request->input('sina');

        $post = [
            'racikan_kode' => $racikan_kode,
            'racikan_nama' => $racikan_nama,
            'signa_kode' => $signa_kode,
            'signa_nama' => $signa_nama,
        ];

        $query = Racikan::create($post);
        return response()->json([
            'status' => true,
            'info' => "Success"
        ], 201);
    }

    public function racikan_delete(Request $request){
        $racikan_kode = $request->input('rako');

        $query = Racikan::where('racikan_kode', $racikan_kode)->delete();
        return $query;
    }

    public function tabel_racikan(){
        $form = view("racikan.tabel_racikan");
        $darr = array('data' => '' . $form . '');
        return response()->json($darr);
    }

    public function data_tabel_racikan(Request $request){
        $data = Racikan::all();

        return \DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('racikan_kode', function($data){
            return $data->racikan_kode;
        })
        ->addColumn('racikan_nama', function($data){
            return $data->racikan_nama;
        })
        ->rawColumns(['racikan_kode','racikan_nama'])
        ->make(true);
    }

    public function komposisi_racikan(Request $request){
        $racikan_kode = $request->input('rako');
        $getRacikan = Racikan::where('racikan_kode',$racikan_kode)->first();
        $namaRacikan = $getRacikan->racikan_nama;
        $kodeRacikan = $getRacikan->racikan_kode;
        $obat = Obatalkes::all();
        $getKomposisiObatRacikan = KomposisiObat::where('racikan_kode',$racikan_kode)->get();

        $form = view("racikan.form_komposisi",['obat'=>$obat, 'rana' => $namaRacikan, 'rako' => $kodeRacikan, 'komposisi' => $getKomposisiObatRacikan]);
        $darr = array('data' => '' . $form . '');
        return response()->json($darr);
    }

    public function komposisi_racikan_create(Request $request){
        $racikan_kode = $request->input('rako');
        $racikan_nama = $request->input('rana');
        $obat_kode = $request->input('obat_kode');
        $obat_nama = $request->input('obat_nama');
        $obat_qty = $request->input('obat_qty');

        // cek sudah di tambahkan atau belum
        $cek = KomposisiObat::where('racikan_kode', $racikan_kode)->where('obatalkes_kode', $obat_kode)->first();
        $obatalkes = $cek->obatalkes_kode ?? '';
        if($obatalkes){
            return false;
        }else{
            $post = [
                'racikan_kode' => $racikan_kode,
                'racikan_nama' => $racikan_nama,
                'obatalkes_kode' => $obat_kode,
                'obatalkes_nama' => $obat_nama,
                'obat_qty' => $obat_qty,
            ];
            
            $query = KomposisiObat::create($post);
            return true;
        }
        

        
    }

    public function data_tabel_komposisi(Request $request){
        $data = KomposisiObat::all();

        return \DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('obat_nama', function($data){
            return $data->obatalkes_nama;
        })
        ->addColumn('obat_qty', function($data){
            return $data->obat_qty;
        })
        ->rawColumns(['obat_nama','obat_qty'])
        ->make(true);
    }

    public function racikan_komposisi_delete(Request $request){
        $racikan_kode = $request->input('rako');
        $obatalkes_kode = $request->input('okesko');

        $query = KomposisiObat::where('racikan_kode', $racikan_kode)->where('obatalkes_kode', $obatalkes_kode)->delete();
        return $query;
    }
}
