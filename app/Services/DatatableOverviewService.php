<?php
namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DatatableOverviewService {

    /**
     * return dataTables from yajra dataTables
     */
    public function datatableOverview($dataTables, $data, string $linkPdf, string $linkTodo) {
        return $dataTables->query($data)
        ->editColumn('dms_no', function($data) use($linkPdf){
            $dms_no = base64_encode($data->dms_no);
            $btn = "<a href='". route($linkPdf, ['id' => $dms_no]) ."' class='card-link' target='_blank'>
                {$data->dms_no}
            </a>";
            return $btn;
        })
        ->editColumn('created_date', function($data) {
            return date("d/m/Y H:i:s", strtotime($data->created_date));
        })
        ->editColumn('date_from', function($data) {
            return date("d/m/Y", strtotime($data->date_from));
        })
        ->editColumn('date_to', function($data){
            return date("d/m/Y", strtotime($data->date_to));
        })
        ->editColumn('principal', function($data){
            $principal = DB::table('IFSAPP.SUPPLIER_INFO_TAB')
                ->selectRaw("CONCAT(CONCAT(supplier_id, '-'), name) AS principal")
                ->where('supplier_id', $data->principal)->first();
            
            return $principal->principal;
        })
        ->editColumn('site', function($data){
            $site = DB::table('ifsapp.site')
                ->selectRaw("CONCAT(CONCAT(contract, '-'), description) AS site")
                ->where('contract', $data->site)->first();
            
            return $site->site;
        })
        ->addColumn('action', function($data) use($linkTodo){
            $dms_no = base64_encode($data->dms_no);
            $btn = "<a href='". route($linkTodo, ['id' => $dms_no]) ."' class='btn btn-block btn-success btn-xs' >
                Proccess
            </a>";
            return $btn;
        })
        ->rawColumns([
            'dms_no', 'created_date', 'date_from', 'date_to', 'action', 'principal', 'site'
        ])->make(true);
    }

    public function datatableOverviewHistory($dataTables, $data, string $linkPdf,
        string $linkTodo) {

        return $dataTables->query($data)
        ->editColumn('dms_no', function($data) {
            $dms_no = base64_encode($data->dms_no);
            $state = $data->state;
            $btn = "<a href='". route('historypdf', ['id' => $dms_no, 'state' => $state]) ."' class='card-link' target='_blank'>
                {$data->dms_no}
            </a>";
            return $btn;
        })
        ->editColumn('created_date', function($data) {
            return date("d/m/Y H:i:s", strtotime($data->created_date));
        })
        ->editColumn('date_from', function($data) {
            return date("d/m/Y", strtotime($data->date_from));
        })
        ->editColumn('date_to', function($data){
            return date("d/m/Y", strtotime($data->date_to));
        })
        ->editColumn('principal', function($data){
            $principal = DB::table('IFSAPP.SUPPLIER_INFO_TAB')
                ->selectRaw("CONCAT(CONCAT(supplier_id, '-'), name) AS principal")
                ->where('supplier_id', $data->principal)->first();
            
            return $principal->principal;
        })
        ->editColumn('site', function($data){
            $sites = DB::table('ifsapp.site')
                ->selectRaw("CONCAT(CONCAT(contract, '-'), description) AS site")
                ->where('contract', $data->site)->get();
            $site = [];
            $i = 0;
            foreach($sites as $row)
            {
                $site[$i] = $row->site;
            }
            return $site;
        })
        ->addColumn('action', function($data) {
            $dms_no = base64_encode($data->dms_no);
            $btn = "<a href='". route('historytodo', ['id' => $dms_no]) ."' class='btn btn-block btn-success btn-xs' >
                Proccess
            </a>";
            return $btn;
        })
        ->rawColumns([
            'dms_no', 'created_date', 'date_from', 'date_to', 'action', 'principal', 'site'
        ])->make(true);

    }

    public function datatableSalesDataSiteHome($dataTables, $data, $totalSales)
    {
        return $dataTables->query($data)
        ->addColumn('percentage', function($data) use($totalSales) {
            $persen =  number_format((float) ($data->total / $totalSales) * 100, 2);
            return $persen . "%";
        })
        ->editColumn('total', function($data) {
            return number_format($data->total, 2);
        })
        ->rawColumns([
            'percentage', 'total'
        ])
        ->make(true);
    }

}
