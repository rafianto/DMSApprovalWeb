<?php
namespace App\Services;

use App\Entities\AuthEntity;
use Illuminate\Support\Facades\DB;

class OverviewService {

    private $data;

    /**
     * this return data collection laravel
     * for datatables
     */
    public function getAllDataOverview($state, string $view, $peMin = null, $peMax = null)
    {
        // instance auth entity for decision view
        $authEntity = new AuthEntity();

        $this->data = DB::table($view);

        // check $state is array
        if(is_array($state))
        {
            // use whereIn for condition view
            $this->data->whereIn('state', $state);
        } else {
            $this->data->where('state', $state);
        }

        $data =  $this->decisionWhere($this->data, $authEntity);
        
        // check PE, for  overview sent
        if($state == 'Sent') {

            if(!is_null($peMin) && !is_null($peMax)) {
                $pe_min = !is_null($peMin) ? (int) $peMin : 0;
                $pe_max = !is_null($peMax) ? (int) $peMax : 0;

                $data->whereBetween('pemax', [(int)$pe_min, (int)$pe_max]);
            }
        }
        
        return $data;
    }

    private function decisionWhere($data, $authEntity)
    {   
        if(count($authEntity->getPrincipals()) > 0)
        {
            $data->whereIn('principal', $authEntity->getPrincipals());
        }
        if(count($authEntity->getSites()) > 0) {
            $data->whereIn('site', $authEntity->getSites());
        }
        
        if(count($authEntity->getProductGroups()) > 0)
        {
            $data->whereIn('prdgrpm', $authEntity->getProductGroups());
        }
        
        return $data->orderBy('created_date', 'DESC');
    }

}
