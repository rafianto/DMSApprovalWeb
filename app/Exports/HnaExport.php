<?php

namespace App\Exports;

use App\Http\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HnaExport implements FromQuery, WithHeadings
{
    use Exportable;

    private $awal;
    private $akhir;
    private $principals;
    private $sites;
    private $productGroup;


    public function __construct($awal, $akhir)
    {
        $this->awal = $awal;
        $this->akhir = $akhir;
        $this->principals = Auth::user()->principal ? explode(",", Auth::user()->principal) : null;
        $this->sites = Auth::user()->site ? explode(",", Auth::user()->site) : null;
        $this->productGroup = Auth::user()->grp_prod ? explode(",", Auth::user()->grp_prod) : null;
    }

    public function query()
    {
        return GeneralHelper::getDataHna($this->awal, $this->akhir, $this->principals,
            $this->sites, $this->productGroup);
    }

    public function headings():array {
        return [
            "No",
            "Cabang",
            "Principal",
            "Product Group",
            "Sales",
        ];
    }
}
