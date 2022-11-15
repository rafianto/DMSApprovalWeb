<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class OverviewRepository {

    protected $data;

    public function call($view) {
        $this->data = DB::table($view);
        return $this->data;
    }

}
