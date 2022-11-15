<?php
namespace App\Services;

use App\Entities\AuthEntity;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\GeneralHelper;
use App\Models\User;
use App\Repositories\OverviewRepository;
use Illuminate\Pagination\CursorPaginator;

class HomeService {

    protected $data;
    private $principals;
    private $sites;
    private $productGroup;
    private $repository;

    public function __construct(AuthEntity $authEntity, OverviewRepository $repository)
    {
        $this->principals = !empty($authEntity->getPrincipals()) ? $authEntity->getPrincipals() : null;
        $this->sites = !empty($authEntity->getSites()) ? $authEntity->getSites() : null;
        $this->productGroup = !empty($authEntity->getProductGroups()) ? $authEntity->getProductGroups() : null;

        $this->repository = $repository;
    }

    /**
     * Menghitung total user aktif berdasarkan is_logged_in
     */
    public function countActiveUser() :int {
        $users = User::where('is_logged_in', 'Y');
        return (int) $users->count();
    }

    public function countOverview(string $view, $state) {
        $data = $this->repository->call($view)->where('state', $state);

        if(!is_null($this->principals))
        {
            $data->whereIn('principal', $this->principals);
        }

        if(!is_null($this->sites))
        {
            $data->whereIn('site', $this->sites);
        }

        if(!is_null($this->productGroup))
        {
            $data->whereIn('prdgrpm', $this->productGroup);
        }

        return $data->count();
    }

    /**
     * mengambil keseluruhan sales data
     * berdasarkan principal
     */
    private function salesData()
    {
        $salesData = DB::table("xxx_dwhouse_detail_tab")->selectRaw("principal, principal_name,
            SUM(sales_amount) AS total");
        return $salesData;
    }

    /**
     * mengambil keseluruhan total sales
     * berdasarkan principal
     */
    private function totalSales()
    {
        $totalSales = DB::table("xxx_dwhouse_detail_tab");
        return $totalSales;
    }

    /**
     * mengambil keseluruhan sales data site
     * berdasarkan principal yang dipilih
     */
    private function salesDataSite()
    {
        $salesDataSite = DB::table("xxx_dwhouse_detail_tab")->selectRaw("branch, ifsapp.site_api.Get_Description(branch) site_name,
            SUM(sales_amount) AS total");
        return $salesDataSite;
    }

    public function decisionSalesDataSite(string $principal) :array{
        $salesData = $this->salesDataSite();
        $totalSales = $this->totalSales();

        $salesData->where('principal', $principal);
        $totalSales->where('principal', $principal);

        $data = [
            "salesData" => $salesData->groupBy(DB::raw("branch"))
                ->orderBy('principal', 'ASC'),
            "totalSales" => (float) $totalSales->sum("sales_amount"),
        ];

        return $data;
    }

    public function getTotalSales(string $principal, string $state){
        if($state == 'all'){
            $totalSales = $this->totalSales();
        } else if($state == 'current') {
            $awal = date('Y-m-01');
            $akhir = date('Y-m-t');
            $totalSales = $this->totalSales()->whereBetween('invoice_date', [$awal, $akhir]);
        }

        $totalSales->where('principal', $principal);

        return $totalSales->sum('sales_amount');
    }

    // total sales setahun
    public function decisionSales() :array
    {
        $salesData = $this->salesData();
        $totalSales = $this->totalSales();

        $awal = date("Y") . "-01-01";
        $akhir = date("Y") . "12-31";

        $totalSales->whereBetween('invoice_date', [$awal, $akhir]);
        
        if(!is_null($this->principals))
        {
            $salesData->whereIn('principal', $this->principals);
            $totalSales->whereIn('principal', $this->principals);
        }

        if(!is_null($this->sites))
        {
            $salesData->whereIn('branch', $this->sites);
            $totalSales->whereIn('branch', $this->sites);
        }

        $data = [
            "salesData" => $salesData->groupBy(DB::raw("principal, principal_name"))
                ->orderBy('principal', 'ASC')->paginate(10),
            "totalSales" => (int) $totalSales->sum("sales_amount"),
        ];

        return $data;
    }

    public function decisionSalesCurrentMonth() :array
    {
        $awal = date('Y-m-01');
        $akhir = date('Y-m-t');

        $salesData = $this->salesData()->whereBetween('invoice_date', [$awal, $akhir]);
        $totalSales = $this->totalSales()->whereBetween('invoice_date', [$awal, $akhir]);

        if(!is_null($this->principals))
        {
            $salesData->whereIn('principal', $this->principals);
            $totalSales->whereIn('principal', $this->principals);
        }

        if(!is_null($this->sites))
        {
            $salesData->whereIn('branch', $this->sites);
            $totalSales->whereIn('branch', $this->sites);
        }

        $data = [
            "salesDataCurrent" => $salesData->groupBy(DB::raw("principal, principal_name"))
                ->orderBy('principal', 'ASC')->paginate(10),
            "totalSalesCurrent" => (float) $totalSales->sum("sales_amount"),
        ];

        return $data;
    }

    public function decisionSalesCurrentMonthSite(string $principal) :array
    {
        $awal = date('Y-m-01');
        $akhir = date('Y-m-t');

        $salesData = $this->salesDataSite()->whereBetween('invoice_date', [$awal, $akhir]);
        $totalSales = $this->totalSales()->whereBetween('invoice_date', [$awal, $akhir]);

        if(!is_null($this->principals))
        {
            $salesData->whereIn('principal', $this->principals);
            $totalSales->whereIn('principal', $this->principals);
        }

        if(!is_null($this->sites))
        {
            $salesData->whereIn('branch', $this->sites);
            $totalSales->whereIn('branch', $this->sites);
        }

        $salesData->where('principal', $principal);
        $totalSales->where('principal', $principal);
        
        $data = [
            "salesData" => $salesData->groupBy(DB::raw("branch"))
                ->orderBy('principal', 'ASC'),
            "totalSales" => (int) $totalSales->sum("sales_amount"),
        ];

        return $data;
    }
}
