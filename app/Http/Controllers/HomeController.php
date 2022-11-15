<?php

namespace App\Http\Controllers;

use App\Services\DatatableOverviewService;
use App\Services\HomeService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('non.active');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function getHome(HomeService $service) {
        $this->data['usersActive'] = $service->countActiveUser();
        $this->data['branch'] = $service->countOverview("dms_list_aprcab_pgview", 'ApprovedByBranch');
        $this->data['sent'] = $service->countOverview("dms_list_aprkpst_pgview", "Sent");
        $this->data['history'] = $service->countOverview("dms_list_aprkpsthist_pgview",
            array("ApprovedByPrincipal", "ApprovedByKpst"));

        $sales = $service->decisionSales();
        $this->data['sales_data'] = $sales['salesData'];
        $this->data['total_sales'] = $sales['totalSales'];

        $salesDataCurrentMonth = $service->decisionSalesCurrentMonth();
        
        $this->data['salesDataCurrent'] = $salesDataCurrentMonth['salesDataCurrent'];
        $this->data['totalSalesCurrent'] = $salesDataCurrentMonth['totalSalesCurrent'];

        return view('welcome2',$this->data);
    }

    public function getAllDataSalesSite(Request $request, HomeService $service,
        DatatableOverviewService $datatableOverviewService, DataTables $dataTables)
    {
        if($request->state == 'all') {
            $proccess = $service->decisionSalesDataSite($request->principal);
        } else if($request->state == 'current') {
            $proccess = $service->decisionSalesCurrentMonthSite($request->principal);
        }

        $data = $proccess['salesData'];
        $totalSales = $proccess['totalSales'];

        $dataTable = $datatableOverviewService->datatableSalesDataSiteHome($dataTables, $data, $totalSales);
        return $dataTable;
    }

    public function getTotalSalesSite(Request $request, HomeService $service)
    {
        $totalSales = $service->getTotalSales($request->principal, $request->state);
        return response()->json([
            "error" => false,
            "totalSales" => number_format($totalSales, 2),
        ], 200);
    }

}
