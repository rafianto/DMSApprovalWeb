<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\GeneralHelper;

class EmailNotificationApproval extends Mailable
{
    use Queueable, SerializesModels;

    private $dms_no;
    private $action;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $dms_no, string $action)
    {
        $this->dms_no = $dms_no;
        $this->action = $action;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = [];
        $data['head'] = DB::table("ifsapp.ctm_dms_head")->selectRaw(" dms_no, ref_no, note_text, site, principal,
            netto_flag, hna_flag, contract_value, contract_no, code_c,
            CODE_C_DESCRIPTION AS division, parameter, value, state,
            TO_CHAR(created_date, 'DD/MM/YYYY HH24:MI:SS') AS created_date,
            TO_CHAR(date_from, 'DD/MM/YYYY') AS date_from,
            TO_CHAR(date_to, 'DD/MM/YYYY') AS date_to,
            ctm_dms_focus AS dms_focus, CTM_DMS_TYPE AS dms_type,
            CTM_DMS_NOTE_TO_DATE AS dms_note, all_outlet_db AS all_outlet,
            all_product_grp_db AS all_product_grp, all_product_db AS all_product,
            rma_not_allowed_db AS rma_not_allowed,
            APPROVAL_PRINCIPAL_ALLOWED_DB AS APPROVAL_PRINCIPAL_ALLOWED")->where("dms_no",$this->dms_no)->first();
        $data['products'] = GeneralHelper::getProductByDmsNo($this->dms_no);
        $data['product_discounts'] = DB::table("IFSAPP.CTM_DMS_PRODUCT1_TAB")->where('dms_no', $this->dms_no)->get();
        $data['product_groups'] = DB::table("IFSAPP.CTM_DMS_PRODUCT_GROUP_TAB a")->selectRaw("a.sales_group,
            IFSAPP.CTM_DMS_PRODUCT_GROUP_API.GET_EXCLUDE_INCLUDE(a.dms_no, a.sales_group) AS exclude_include")
            ->where('dms_no', $this->dms_no)->get();
        $data['order_type'] = DB::table("IFSAPP.CTM_DMS_ORDER_TYPE_TAB a")->selectRaw("a.order_type,
            IFSAPP.CTM_DMS_ORDER_TYPE_API.GET_EXCLUDE_INCLUDE(a.dms_no, a.ORDER_TYPE) AS exclude_include")
            ->where('dms_no', $this->dms_no)->first();
        $data['customers'] = DB::table("IFSAPP.CTM_DMS_CUSTOMER_TAB a")->selectRaw("a.customer_id,
            IFSAPP.CTM_DMS_CUSTOMER_API.GET_EXCLUDE_INCLUDE(a.dms_no, a.customer_id) AS exclude_include ")
        ->where('dms_no', $this->dms_no)->first();
        $data['customer_groups'] = DB::table("IFSAPP.CTM_DMS_CUSTOMER_GROUP_TAB a")->selectRaw("a.cust_group,
            IFSAPP.CTM_DMS_CUSTOMER_GROUP_API.GET_EXCLUDE_INCLUDE(a.dms_no, a.cust_group) AS exclude_include")
            ->where('dms_no', $this->dms_no)->get();
        $data['customer_chains'] = DB::table("IFSAPP.CTM_DMS_CUSTOMER_CHAIN_TAB a")->selectRaw("a.cust_chain,
            IFSAPP.CTM_DMS_CUSTOMER_CHAIN_API.GET_EXCLUDE_INCLUDE(a.dms_no, a.cust_chain) AS exclude_include")
            ->where('dms_no', $this->dms_no)->get();
        $data['order_values'] = DB::table("IFSAPP.CTM_DMS_ORDER_VALUE_TAB a")
            ->selectRaw("a.part_no, a.line_no, a.min_value, a.max_value")
            ->where('dms_no', $this->dms_no)->get();
        $data['mix_bonuses'] = DB::table("IFSAPP.CTM_DMS_MIX_BONUS_TAB a")->selectRaw("a.line_no, a.note, a.min_amount,
            a.min_qty, a.max_qty, a.bonus_qty, a.max_amount")
            ->where('dms_no', $this->dms_no)->get();
        $data['bonus_detail'] = DB::table("IFSAPP.CTM_DMS_MIX_BONUS_DTL_TAB")->selectRaw("line_no, line_item_no, min_qty,
            discount_type, discount_value")->where('dms_no', $this->dms_no)->get();
        $data['mix_persens'] = DB::table("IFSAPP.CTM_DMS_MIX_PERCENT_DTL_TAB")->where('dms_no', $this->dms_no)
            ->get();
        $data['signature_by'] = DB::table("IFSAPP.CTM_DMS_SIGNATURE_TAB")->where('dms_no', $this->dms_no)
            ->first();
        $data['histories'] = DB::table('IFSAPP.CTM_DMS_HEAD_HIST_TAB')
            ->selectRaw("history_no, rowstate, TO_CHAR(date_entered, 'DD/MM/YYYY HH24:MI:SS') AS date_entered,
            userid")
            ->where('dms_no', $this->dms_no)->orderBy('history_no', 'ASC')->get();

        return $this->subject("Email Test Aplikasi DMS")->view('emails.notification', $data);
    }
}
