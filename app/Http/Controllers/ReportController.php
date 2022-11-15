<?php

namespace App\Http\Controllers;

use App\Exports\CbpExport;
use App\Exports\HnaExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('non.active');
    }

    public function index()
    {
        if(request()->segment(2) == 'cbp')
        {
            return view('reports.cbp');
        } else if(request()->segment(2) == 'hna'){
            return view('reports.hna');
        }
    }

    public function getAllDataCbp(Request $request, DataTables $dataTables)
    {
        $segment = $request->segment(2);
        $awal = isset($request->awal) ? $request->awal : null;
        $akhir = isset($request->akhir) ? $request->akhir : null;

        $data = $this->decisionGetData($request->segment(2), $awal, $akhir);
        return $dataTables->query($data)
        ->editColumn('principal', function($data) {
            $data = DB::table("IFSAPP.SUPPLIER_INFO_TAB ")
                ->selectRaw("supplier_id || ' - ' || name AS principal")
                ->where('supplier_id', $data->principal)
                ->first();
            return $data->principal;
        })
        ->editColumn('total_bcp', function($data) {
            return number_format((int) $data->total_bcp, 2);
        })
        ->rawColumns([
            'principal', 'total_bcp',
        ])
        ->make(true);
    }

    public function getAllDataHna(Request $request, DataTables $dataTables) {
        $segment = $request->segment(2);
        $awal = isset($request->awal) ? $request->awal : null;
        $akhir = isset($request->akhir) ? $request->akhir : null;

        $data = $this->decisionGetData($request->segment(2), $awal, $akhir);
        return $dataTables->query($data)
        ->editColumn('principal', function($data) {
            $data = DB::table("IFSAPP.SUPPLIER_INFO_TAB ")
                ->selectRaw("supplier_id || ' - ' || name AS principal")
                ->where('supplier_id', $data->principal)
                ->first();
            return $data->principal;
        })
        ->editColumn('total_hna', function($data) {
            return number_format((int) $data->total_hna, 2);
        })
        ->rawColumns([
            'principal', 'total_bcp',
        ])
        ->make(true);
    }

    private function decisionGetData($segment, $awal = null, $akhir = null)
    {
        $principals = Auth::user()->principal ? explode(",", Auth::user()->principal) : null;
        $sites = Auth::user()->site ? explode(",", Auth::user()->site) : null;
        $productGroup = Auth::user()->grp_prod ? explode(",", Auth::user()->grp_prod) : null;

        if(is_null($awal) && is_null($akhir))
        {
            $awal = date('Y-m-01');
            $akhir = date('Y-m-t');
        } else if(!is_null($awal) && is_null($akhir))
        {
            $awal = date('Y-m-01');
            $akhir = date('Y-m-t');
        } else if(is_null($awal) && !is_null($akhir)) {
            $awal = date('Y-m-01');
            $akhir = date('Y-m-t');
        }

        if($segment == 'cbp') {
            $select = "branch || ' - ' || IFSAPP.SITE_API.GET_DESCRIPTION(branch) AS branch, principal,
                product_group_code || ' ' || product_group_name AS pgroup,
            SUM(cbp * buy_qty_due) AS total_bcp";
            $groupBy = "branch, principal, product_group_code || ' ' || product_group_name";
        } else if($segment == 'hna')
        {
            $select = "branch || ' - ' || IFSAPP.SITE_API.GET_DESCRIPTION(branch) AS branch, principal,
            product_group_code || ' ' || product_group_name AS pgroup,
        SUM(buy_qty_due * hna) AS total_hna";
            $groupBy = "branch, principal, product_group_code || ' ' || product_group_name";
        }

        $data = DB::table("xxx_dwhouse_detail_tab")->selectRaw($select)
        ->whereBetween('invoice_date', [$awal, $akhir]);

        if(!is_null($principals))
        {
            $data->whereIn('principal', $principals);
        }

        if(!is_null($sites))
        {
            $data->whereIn('branch', $sites);
        }

        if(!is_null($productGroup))
        {
            $data->whereIn('product_group_code', $productGroup);
        }

        $data->groupBy(DB::raw($groupBy))->orderBy('principal', "ASC")->orderBy('branch', "ASC")
        ->orderBy(DB::raw("product_group_code || ' ' || product_group_name"), "ASC");

        return $data;
    }

    public function exportExcelCbp(Request $request)
    {
        $awal = $request->input('awal') ? $request->input('awal') : null;
        $akhir = $request->input('akhir') ? $request->input('akhir') : null;

        if(is_null($awal) && is_null($akhir))
        {
            $awal = date('Y-m-01');
            $akhir = date('Y-m-t');
        } else if(!is_null($awal) && is_null($akhir))
        {
            $awal = date('Y-m-01');
            $akhir = date('Y-m-t');
        } else if(is_null($awal) && !is_null($akhir)) {
            $awal = date('Y-m-01');
            $akhir = date('Y-m-t');
        }
        $time = time();
        return (new CbpExport($awal, $akhir))->download("report_cbp_$time.xlsx");
    }

    public function exportExcelHna(Request $request)
    {
        $awal = $request->input('awal') ? $request->input('awal') : null;
        $akhir = $request->input('akhir') ? $request->input('akhir') : null;

        if(is_null($awal) && is_null($akhir))
        {
            $awal = date('Y-m-01');
            $akhir = date('Y-m-t');
        } else if(!is_null($awal) && is_null($akhir))
        {
            $awal = date('Y-m-01');
            $akhir = date('Y-m-t');
        } else if(is_null($awal) && !is_null($akhir)) {
            $awal = date('Y-m-01');
            $akhir = date('Y-m-t');
        }
        $time = time();

        return (new HnaExport($awal, $akhir))->download("report_hna_$time.xlsx");
    }
}
