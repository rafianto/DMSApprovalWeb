<?php
namespace App\Http\Helpers;

use Illuminate\Support\Facades\DB;
use PDO;

class GeneralHelper
{

    /**
     * get all data header from dms header table
     */
    public static function getDmsHeaderByDmsNo(string $dmsNo, $state = null)
    {
        $select = "dms_no, ref_no, note_text, site, principal,
            netto_flag, hna_flag, contract_value, contract_no, code_c,
            CODE_C_DESCRIPTION AS division, parameter, value, state,
            TO_CHAR(created_date, 'DD/MM/YYYY HH24:MI:SS') AS created_date,
            TO_CHAR(date_from, 'DD/MM/YYYY') AS date_from,
            TO_CHAR(date_to, 'DD/MM/YYYY') AS date_to,
            ctm_dms_focus AS dms_focus, CTM_DMS_TYPE AS dms_type,
            CTM_DMS_NOTE_TO_DATE AS dms_note, all_outlet_db AS all_outlet,
            all_product_grp_db AS all_product_grp, all_product_db AS all_product,
            rma_not_allowed_db AS rma_not_allowed,
            APPROVAL_PRINCIPAL_ALLOWED_DB AS APPROVAL_PRINCIPAL_ALLOWED,
            dms_principal_api.DMS_CEK_PE_TOTAL(dms_no) JMLPE,
            dms_principal_api.DMS_CEK_CE_TOTAL(dms_no) JMLCE
        ";

        $data = DB::table("IFSAPP.CTM_DMS_HEAD")->selectRaw($select)->where('dms_no', $dmsNo);

        if(!is_null($state)){
            $data->where('state', $state);
        }

        return $data->first();
    }

    public static function getHistoryDmsHeaderByDmsNo(string $dmsNo)
    {
        $select = "history_no,dms_no,state,date_entered,userid,message_text";

        $data = DB::table("ifsapp.ctm_dms_head_hist")->selectRaw($select)
            ->where('dms_no', $dmsNo)->orderBy('history_no', "ASC")->get();
        return $data;
    }

    /**
     * get product group by batch principal
     */
    public static function getGroupProductByPrincipal(array $principal)
    {
        $data = DB::table("bn_product")
        ->select("catalog_group", "group_name")->distinct()
        ->whereIn('supplier_id', $principal)->get();
        return $data;
    }

    /**
     * @param string $dms_no
     * get customer chain by dms_no
     * @return array/collection
     */
    public static function  getCustomerChain(string $dms_no)
    {
        $data = DB::table("IFSAPP.CTM_DMS_CUSTOMER_CHAIN_TAB a")
        ->selectRaw("a.dms_no, a.cust_chain,
        IFSAPP.CTM_DMS_CUSTOMER_CHAIN_API.Get_Exclude_Include(a.dms_no, a.cust_chain) AS exclude_include")
        ->where('dms_no', $dms_no)->get();
        return $data;
    }

    /**
     * @param string $dms_no
     * get customer group by dms_no
     * @return array/collection
     */
    public static function getCusotmerGroup(string $dms_no)
    {
        $data = DB::table("IFSAPP.CTM_DMS_CUSTOMER_GROUP_TAB a")
        ->selectRaw("a.dms_no, a.cust_group,
        IFSAPP.CTM_DMS_CUSTOMER_GROUP_API.Get_Exclude_Include(a.dms_no, a.cust_group) AS exclude_include")
        ->where('dms_no', $dms_no)->get();
        return $data;
    }

    /**
     * @param string $dms_no
     * get Signature By dms_no
     * @return array/collection
     */
    public static function getSignatureByDmsNo(string $dms_no)
    {
        $data = DB::table("IFSAPP.CTM_DMS_SIGNATURE")
        ->selectRaw("person_id, name, position, notes")
        ->where('dms_no', $dms_no)->get();
        return $data;
    }

    /**
     * @param string $dms_no
     * get data mix persen by dms_no
     * @return array/collection
     */
    public static function getMixedPersenByDmsNo(string $dms_no)
    {
        $data = DB::table("IFSAPP.CTM_DMS_MIX_PERCENT_TAB")->where('dms_no', $dms_no)->get();
        return $data;
    }

    /**
     * @param string $dms_no
     * get data mixed bonus by dms_no
     * @return array/collection
     */
    public static function getMixedBonusByDmsNo(string $dms_no)
    {
        $data = DB::table("IFSAPP.CTM_DMS_MIX_BONUS_TAB")->where('dms_no', $dms_no)->get();
        return $data;
    }

    /**
     * @param strnig $dms_no
     * get data order values by dms_no
     * @return array/collection
     * database schema MBS
     */
    public static function getOrderValuesByDmsNo(string $dms_no)
    {
        $data = DB::table("DMS_MST_ORDVAL_VIEW")
        ->select("line_no", "min_value", "max_value", "discount_type", "discount_value")
        ->where('dms_no', $dms_no)->get();
        return $data;
    }

    /**
     * @param string $dms_no
     * get data customer by dms no
     * @return array
     */
    public static function getCustomerByDmsNo(string $dms_no)
    {
        $data = DB::select("SELECT a.dms_no, a.customer_id,
        IFSAPP.CTM_DMS_CUSTOMER_API.Get_Exclude_Include(a.dms_no, a.customer_id) AS exclude_include,
        b.name AS customer_name
        FROM IFSAPP.CTM_DMS_CUSTOMER_TAB a
        INNER JOIN IFSAPP.CUSTOMER_INFO_TAB b
        ON a.customer_id = b.customer_id
        WHERE a.dms_no = '$dms_no'");

        return $data;
    }

    /**
     * @param string $dms_no
     * get data order type by dms_no
     * @return array/collection
     */
    public static function getOrderTypeByDmsNo(string $dms_no)
    {
        $data = DB::table("IFSAPP.CTM_DMS_ORDER_TYPE")->select("order_type", "exclude_include")
        ->where('dms_no', $dms_no)->get();
        return $data;
    }

    public static function getProductGroupByDmsNo(string $dms_no)
    {
        $data = DB::table("IFSAPP.CTM_DMS_PRODUCT_GROUP")->select("dms_no", "sales_group", "exclude_include")
        ->where("dms_no", $dms_no)->get();

        return $data;
    }

    public static function getProductByDmsNo(string $dms_no)
    {
        $data = DB::table("IFSAPP.CTM_DMS_PRODUCT1")
        ->selectRaw("dms_no, part_no, line_no, site, quantity, min_qty, max_qty, bonus_part, bonus_qty,
            kelipatan, harga, disc_ce, disc_pe, disc_ck, disc_pk, 
                IFSAPP.SALES_PART_API.GET_CATALOG_DESC(IFSAPP.CTM_DMS_HEAD_API.Get_Site(dms_no),
	            part_no) keterangan,
                IFSAPP.SALES_PART_API.GET_CATALOG_DESC(IFSAPP.CTM_DMS_HEAD_API.Get_Site(dms_no),
	            bonus_part) desc_part_discount,
                CASE
                WHEN ket_disc IS NOT NULL  THEN ket_disc
                ELSE
                'Tidak Ada Keterangan'
            END AS ket_disc
            , min_value, max_value,
            condition, order_no
        ")->where('dms_no', $dms_no)->get();
        return $data;
    }

    /**
     * @param string $dms_no
     * get history approval dms
     * @return array/collection
     */
    public static function getDmsHistoryByDmsNo(string $dms_no)
    {
        $data = DB::table("IFSAPP.CTM_DMS_HEAD_HIST")->select("history_no", "state", 
            "date_entered", "userid", "message_text")
        ->where("dms_no", $dms_no)->orderBy("date_entered", "ASC")->get();
        return $data;
    }

    /**
     * @param string $dms_no
     * @param string $principal
     * this static function for cancel approval
     * @return array
     */
    public static function cancelApproval(string $dms_no, string $principal)
    {
        $responseMessage = [];
        $state = "3";
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare("BEGIN
                IFSAPP.MBS_DMS_DTWH1_PROSSES(:dms_no, :state, :principal);
            END;
        ");
        $stmt->bindParam(":dms_no", $dms_no, PDO::PARAM_STR);
        $stmt->bindParam(":state", $state, PDO::PARAM_STR);
        $stmt->bindParam(":principal", $principal, PDO::PARAM_STR);
        $result = $stmt->execute();

        if(!$result){
            $responseMessage['error'] = true;
            $responseMessage['code'] = 500;
            $responseMessage['message'] = "Internal Server Error. Failed to cancel dms, please try again later.";
        } else {
            $responseMessage['error'] = false;
            $responseMessage['code'] = 200;
            $responseMessage['message'] = "Dms No : $dms_no, has been cancelled.";
        }
        return $responseMessage;

    }

    /**
     * @param array $data
     * this static function for do approval
     */
    public static function doApprovalBranch(array $data)
    {
        $responseMessage = [];
        $stateInput = $data['state'];
        /**
         * get count data discount type berdasrakan dms_no dan discount_type = CE
         * jika mengembalikan 0 berarti tidak ada data CE
         * jika mengembalikan lebih dari 0 berarti ada data CE
         */
        $ceAvailable = DB::table("IFSAPP.CTM_DMS_MIX_PERCENT_DTL_TAB")
        ->where('dms_no', $data['dms_no'])->where('discount_type', 'CE')->count();

        /**
         * get count data discount type berdasrakan dms_no dan discount_type where in ['PE', 'PB', 'P1', 'P2']
         * jika mengembalikan 0 berarti tidak ada data ['PE', 'PB', 'P1', 'P2']
         * jika mengembalikan lebih dari 0 berarti ada data ['PE', 'PB', 'P1', 'P2']
         */
        $peAvailable = DB::table("IFSAPP.CTM_DMS_MIX_PERCENT_DTL_TAB")
        ->where('dms_no', $data['dms_no'])->where('discount_type', 'LIKE', "P%")->count();
        
        // prepare statement untuk menjalankan prosedur approval
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare("BEGIN
                IFSAPP.MBS_DMS_DTWH1_PROSSES(:dms_no, :state, :principal);
            END;
        ");

        // cek PE, jika tidak ada maka akan dilakukan ApprovedByKpst/$peAvailabel <= 0
        // --Stat = '6' = Melakukan Proses ApprovedByKpst tanpa sent jika dms tidak ada beban Principal
        if($peAvailable <= 0)
        {
            $stateChange = '6';
            $stmt->bindParam(':dms_no', $data['dms_no'], PDO::PARAM_STR);
            $stmt->bindParam(':state', $stateChange, PDO::PARAM_STR);
            $stmt->bindParam(':principal', $data['principal'], PDO::PARAM_STR);
        } else {
            // --Stat = '2' = Melakukan Proses Send + Approved
            $stateChange = '2';
            $stmt->bindParam(':dms_no', $data['dms_no'], PDO::PARAM_STR);
            $stmt->bindParam(':state', $stateChange, PDO::PARAM_STR);
            $stmt->bindParam(':principal', $data['principal'], PDO::PARAM_STR);
        }

        $result = $stmt->execute();

        if(!$result){
            $responseMessage['error'] = true;
            $responseMessage['code'] = 500;
            $responseMessage['message'] = "Internal Server Error. Failed to cancel approval, please try again later.";
        } else {
            $responseMessage['error'] = false;
            $responseMessage['code'] = 200;
            $responseMessage['message'] = "Dms No : ".$data['dms_no'].", has been approved.";
        }
        return $responseMessage;
    }

    /**
     * @param string $dms_no
     * @param string $principal
     * this static function for close dms
     */
    public static function closeDms(string $dms_no, string $principal)
    {
        $responseMessage = [];
        $state = "4";
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare("BEGIN
                IFSAPP.MBS_DMS_DTWH1_PROSSES(:dms_no, :state, :principal);
            END;
        ");
        $stmt->bindParam(":dms_no", $dms_no, PDO::PARAM_STR);
        $stmt->bindParam(":state", $state, PDO::PARAM_STR);
        $stmt->bindParam(":principal", $principal, PDO::PARAM_STR);
        $result = $stmt->execute();

        if(!$result){
            $responseMessage['error'] = true;
            $responseMessage['code'] = 422;
            $responseMessage['message'] = "Internal Server Error. Failed to close dms, please try again later.";
        } else {
            $responseMessage['error'] = false;
            $responseMessage['code'] = 200;
            $responseMessage['message'] = "Dms No : $dms_no, has been closed.";
        }
        return $responseMessage;
    }

    public static function approvalByKpst(string $dmsNo)
    {
        $responseMessage = [];
        $info = "";
        $attr = "";

        // get ctm dms head
        $dmsHead = self::getCtmDmsHead($dmsNo);

        // prepare statement untuk menjalankan prosedur approval
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare("BEGIN
                IFSAPP.ctm_dms_head_api.Approve_By_Kpst__(:info, :objid, :objversion, :attr, 'DO');
            END;
        ");

        $stmt->bindParam(':info', $info, PDO::PARAM_STR, 2000);
        $stmt->bindParam(':attr', $attr, PDO::PARAM_STR, 2000);
        $stmt->bindParam(':objid', $dmsHead->objid, PDO::PARAM_STR);
        $stmt->bindParam(':objversion', $dmsHead->objversion, PDO::PARAM_STR);

        $result = $stmt->execute();

        if(!$result){
            $responseMessage['error'] = true;
            $responseMessage['code'] = 500;
            $responseMessage['message'] = "Internal Server Error. Failed to approval, please try again later.";
        } else {
            $responseMessage['error'] = false;
            $responseMessage['code'] = 200;
            $responseMessage['message'] = "Dms No : ". $dmsNo .", has been approved.";
        }
        return $responseMessage;
    }

    public static function approvalByPrincipal(string $dmsNo)
    {
        $responseMessage = [];
        $info = "";
        $attr = "";

        // get ctm dms head
        $dmsHead = self::getCtmDmsHead($dmsNo);

        // prepare statement untuk menjalankan prosedur approval
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare("BEGIN
                IFSAPP.ctm_dms_head_api.Approve_By_Principal__(:info, :objid, :objversion, :attr, 'DO');
            END;
        ");

        $stmt->bindParam(':info', $info, PDO::PARAM_STR, 2000);
        $stmt->bindParam(':attr', $attr, PDO::PARAM_STR, 2000);
        $stmt->bindParam(':objid', $dmsHead->objid, PDO::PARAM_STR);
        $stmt->bindParam(':objversion', $dmsHead->objversion, PDO::PARAM_STR);

        $result = $stmt->execute();

        if(!$result){
            $responseMessage['error'] = true;
            $responseMessage['code'] = 500;
            $responseMessage['message'] = "Internal Server Error. Failed to approval, please try again later.";
        } else {
            $responseMessage['error'] = false;
            $responseMessage['code'] = 200;
            $responseMessage['message'] = "Dms No : ".$dmsNo.", has been approved.";
        }
        return $responseMessage;
    }

    public static function approvalSent(string $dmsNo)
    {
        $responseMessage = [];
        $info = "";
        $attr = "";

        // get ctm dms head
        $dmsHead = self::getCtmDmsHead($dmsNo);

        // prepare statement untuk menjalankan prosedur approval
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare("BEGIN
                IFSAPP.ctm_dms_head_api.send__(:info, :objid, :objversion, :attr, 'DO');
            END;
        ");

        $stmt->bindParam(':info', $info, PDO::PARAM_STR, 2000);
        $stmt->bindParam(':attr', $attr, PDO::PARAM_STR, 2000);
        $stmt->bindParam(':objid', $dmsHead->objid, PDO::PARAM_STR);
        $stmt->bindParam(':objversion', $dmsHead->objversion, PDO::PARAM_STR);

        $result = $stmt->execute();

        if(!$result){
            $responseMessage['error'] = true;
            $responseMessage['code'] = 500;
            $responseMessage['message'] = "Internal Server Error. Failed to approval, please try again later.";
        } else {
            $responseMessage['error'] = false;
            $responseMessage['code'] = 200;
            $responseMessage['message'] = "Dms No : ". $dmsNo .", has been Sent.";
        }
        return $responseMessage;
    }

    /**
     * @return boolean
     * @param string $dms_no
     */
    public static function checkPE(string $dms_no)
    {
         /**
         * get count data discount type berdasrakan dms_no dan discount_type = CE
         * jika mengembalikan 0 berarti tidak ada data CE
         * jika mengembalikan lebih dari 0 berarti ada data CE
         */
        $ceAvailable = DB::table("IFSAPP.ctm_dms_product1_disc_tab")
        ->where('dms_no', $dms_no)->where('discount_type', 'CE')->count();

        /**
         * get count data discount type berdasrakan dms_no dan discount_type where in ['PE', 'PB', 'P1', 'P2']
         * jika mengembalikan 0 berarti tidak ada data ['PE', 'PB', 'P1', 'P2']
         * jika mengembalikan lebih dari 0 berarti ada data ['PE', 'PB', 'P1', 'P2']
         */
        $peAvailable = DB::table("IFSAPP.ctm_dms_product1_disc_tab")
        ->where('dms_no', $dms_no)->where('discount_type', 'LIKE', "P%")->count();
        
        if($peAvailable <= 0)
        {
            return false;
        }

        return true;
    }

    /**
     * get ctm_dms_head for approval
     */
    public static function getCtmDmsHead(string $dms_no)
    {
        $data = DB::table("IFSAPP.CTM_DMS_HEAD")
            ->selectRaw("ROWIDTOCHAR(objid) as objid, objversion")
            ->where("dms_no", $dms_no)
            ->first();

        return $data;
    }

    public static function totalSalesDms($wherePrincipalString = null, $whereSitesString = null)
    {
        $where = null; // kalo kondisi semua tidak terpenuhi maka where nya kosong

        if(!is_null($wherePrincipalString) && !is_null($whereSitesString))
        {
            $where = "AND principal IN ($wherePrincipalString) AND branch IN ($whereSitesString)";
        } else if(!is_null($wherePrincipalString) && is_null($whereSitesString)) {
            $where = "AND principal IN ($wherePrincipalString)";
        } else if(!is_null($whereSitesString) && is_null($wherePrincipalString)) {
            $where = "AND branch IN ($whereSitesString)";
        }

        if(is_null($where))
        {
            $sql = "SELECT principal, SUM(sales_amount) AS nilai
            FROM xxx_dwhouse_detail_tab
            WHERE invoice_date BETWEEN (TRUNC(MIN(invoice_date), 'MM') AND MAX(LAST_DAY(invoice_date)))
            GROUP BY principal";
        } else {
            $sql = "SELECT principal, SUM(sales_amount) AS nilai
                FROM xxx_dwhouse_detail_tab
                WHERE invoice_date BETWEEN (TRUNC(MIN(invoice_date), 'MM') AND MAX(LAST_DAY(invoice_date)))
                $where
                GROUP BY principal
            ";
        }

        $label = ["Principal", "Nilai"];
        $rows = DB::select($sql);

        $data = [];
        array_push($data, $label);
        foreach($rows as $row)
        {
            $temp = array($row->principal, (int)$row->nilai);
            array_push($data, $temp);
        }

        return json_encode($data);
    }

    public static function salesBulanIni($wherePrincipalString = null, $whereSitesString = null)
    {
        $where = null; // kalo kondisi semua tidak terpenuhi maka where nya kosong

        if(!is_null($wherePrincipalString) && !is_null($whereSitesString))
        {
            $where = "AND principal IN ($wherePrincipalString) AND branch IN ($whereSitesString)";
        } else if(!is_null($wherePrincipalString) && is_null($whereSitesString)) {
            $where = "AND principal IN ($wherePrincipalString)";
        } else if(!is_null($whereSitesString) && is_null($wherePrincipalString)) {
            $where = "AND branch IN ($whereSitesString)";
        }

        if(is_null($where))
        {
            /*$sql = "SELECT principal, SUM(sales_amount) AS nilai
            FROM xxx_dwhouse_detail_tab
            WHERE invoice_date BETWEEN TRUNC(SYSDATE, 'MM') AND LAST_DAY(TRUNC(SYSDATE, 'MM'))
            GROUP BY principal --, site"; */

            $sql = "SELECT z.*,ifsapp.supplier_info_api.Get_Name(z.principal) as nameprincipal FROM (
                SELECT principal, SUM(sales_amount) AS nilai
                            FROM xxx_dwhouse_detail_tab
                            WHERE invoice_date BETWEEN TRUNC(SYSDATE-8, 'MM') AND LAST_DAY(TRUNC(SYSDATE-8, 'MM'))
                            GROUP BY principal ) z ORDER BY principal ";
        } else {
            /*$sql = "SELECT principal, SUM(sales_amount) AS nilai
                FROM xxx_dwhouse_detail_tab
                WHERE invoice_date BETWEEN TRUNC(SYSDATE, 'MM') AND LAST_DAY(TRUNC(SYSDATE, 'MM'))
                $where
                GROUP BY principal --, site "; */

                $sql = "SELECT z.*,ifsapp.supplier_info_api.Get_Name(z.principal) as nameprincipal FROM (
                    SELECT principal, SUM(sales_amount) AS nilai
                                FROM xxx_dwhouse_detail_tab
                                WHERE invoice_date BETWEEN TRUNC(SYSDATE-8, 'MM') AND LAST_DAY(TRUNC(SYSDATE-8, 'MM')) 
                                $where 
                                GROUP BY principal ) z ORDER BY principal ";
        
        }

        $label = ["Principal", "Nilai"];
        $rows = DB::select($sql);
        $data = [];
        array_push($data, $label);
        foreach($rows as $row)
        {
            $temp = array($row->principal, (int)$row->nilai);
            array_push($data, $temp);
        }

        return json_encode($data);
    }

    public static function randomColorPart() {
        return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
    }

    public static function generateRandomColor() {
        return "#" . self::randomColorPart() . self::randomColorPart() . self::randomColorPart();
    }

    public static function getSalesDataByPrincipalsAndSites()
    {
        $principals = auth()->user() ? explode(",", auth()->user()->principal) : [];
        $sites = auth()->user() ? explode(",", auth()->user()->site) : [];

        $wherePrincipalString = implode("','", $principals);
        $wherePrincipalString = "'$wherePrincipalString'";
        $whereSitesString = implode("','", $sites);
        $whereSitesString = "'$whereSitesString'";

        // sales data
        $salesData = DB::select("SELECT x.supplier_id,x.catalog_grup, x.catdisc, x.site,
            sum(x.value) as nilai
            FROM ( SELECT t.* FROM mbs.dms_data_sales_pgview t
                WHERE t.supplier_id IN ($wherePrincipalString)
                AND t.site IN ($whereSitesString) ) x
            GROUP BY x.supplier_id,x.catalog_grup,x.catdisc,x.site
        ");

        return $salesData;
    }

    public static function getDvision()
    {
        $data = DB::table("ifsapp.ctm_part_division")->select("part_division_code", "division_code", "part_division_description")->get();
        return $data;
    }

    public static function getDataCbp($awal = null, $akhir = null,
        $principals = null, $sites = null, $productGroup = null)
    {
        $select = "branch || ' - ' || IFSAPP.SITE_API.GET_DESCRIPTION(branch) AS cabang,
            principal,
            product_group_code || ' ' || product_group_name AS pgroup,
            SUM(cbp * buy_qty_due) AS total_bcp";
        $groupBy = "branch, principal, product_group_code || ' ' || product_group_name";

        $data = DB::table("xxx_dwhouse_detail_tab")->selectRaw($select)
            ->whereBetween('invoice_date', [$awal, $akhir]);

        if(!is_null($principals))
        {
            $data->whereIn('principal', $principals);
        }

        if(!is_null($sites))
        {
            $data->whereIn('site', $sites);
        }

        if(!is_null($productGroup))
        {
            $data->whereIn('product_group_code', $productGroup);
        }

        $data->groupBy(DB::raw($groupBy))->orderBy('principal', "ASC")->orderBy('branch', "ASC");

        return $data;
    }

    public static function getDataHna($awal = null, $akhir = null,
        $principals = null, $sites = null, $productGroup = null)
    {
        $select = "branch || ' - ' || IFSAPP.SITE_API.GET_DESCRIPTION(branch) AS cabang,
            principal,
            product_group_code || ' ' || product_group_name AS pgroup,
            SUM(buy_qty_due * hna) AS total_hna";
        $groupBy = "branch, principal, product_group_code || ' ' || product_group_name";

        $data = DB::table("xxx_dwhouse_detail_tab")->selectRaw($select)
            ->whereBetween('invoice_date', [$awal, $akhir]);

        if(!is_null($principals))
        {
            $data->whereIn('principal', $principals);
        }

        if(!is_null($sites))
        {
            $data->whereIn('site', $sites);
        }

        if(!is_null($productGroup))
        {
            $data->whereIn('product_group_code', $productGroup);
        }

        $data->groupBy(DB::raw($groupBy))->orderBy('principal', "ASC")->orderBy('branch', "ASC")
        ->orderBy(DB::raw("product_group_code || ' ' || product_group_name"), "ASC");

        return $data;
    }

}
