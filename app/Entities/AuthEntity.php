<?php
namespace App\Entities;

use Illuminate\Support\Facades\Auth;

class AuthEntity {

    // array
    private $principals;

    // array
    private $sites;

    // array
    private $prodGroups;

    // string where principal
    private $stringPrincipals;

    // string where sites
    private $stringSites;

    // strinng where product group
    private $stringProdGroups;

    private $peMin;
    private $peMax;

    public function __construct()
    {
        $this->principals = Auth::user()->principal ? explode(",", Auth::user()->principal) : [];
        $this->sites = Auth::user()->site ? explode(",", Auth::user()->site) : [];
        $this->prodGroups = auth()->user()->grp_prod ? explode(",", auth()->user()->grp_prod) : [];

        // descision string of where principal
        if(count($this->principals) <= 0)
        {
            $wherePrincipalString = implode("','", $this->principals);
            $this->stringPrincipals = "'$wherePrincipalString'";
        } else {
            $this->stringPrincipals = "";
        }

        if(count($this->sites) <= 0){
            $whereSitesString = implode("','", $this->sites);
            $this->stringSites = "'$whereSitesString'";
        } else {
            $this->stringSites = "";
        }

        if(count($this->prodGroups) <= 0)
        {
            $whereProdGroupsString = implode("','", $this->prodGroups);
            $this->stringProdGroups = "'$whereProdGroupsString'";
        } else {
            $this->stringProdGroups = "";
        }

        $this->pemin = Auth::user()->pemindisc;
        $this->pemax = Auth::user()->pemaxdisc;
    }

    /**
     * return array jika ada
     */
    public function getPrincipals() :array
    {
        return $this->principals;
    }

    /**
     * return array jika ada
     */
    public function getSites() :array{
        return $this->sites;
    }

    /**
     * return array jika ada
     */
    public function getProductGroups() :array{
        return $this->prodGroups;
    }

    /**
     * @return string
     */
    public function getStringPrincipal() :string
    {
        return $this->stringPrincipals;
    }

    /**
     * @return string
     */
    public function getStringSite() :string
    {
        return $this->stringSites;
    }

    /**
     * @return string
     */
    public function getStirngProductGroup() :string {
        return $this->stringProdGroups;
    }

    public function getPeMin() {
        return $this->peMin;
    }

    public function getPeMax() {
        return $this->peMax;
    }

}
