<?php
namespace App\Services;

use Mpdf\Mpdf;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\GeneralHelper;

class OverviewPdfService {
    private $dmsNo;
    private $state;
    private $view;

    public function __construct(string $dmsNo, string $state, string $view)
    {
        $this->dmsNo = $dmsNo;
        $this->state = $state;
        $this->view = $view;
    }

    public function body() :string
    {
        $data = DB::table($this->view)->where('dms_no', $this->dmsNo)
            ->where('state', $this->state)->first();

        /**
         * this for get data product by DmsNo
         */
        $products = GeneralHelper::getProductByDmsNo($this->dmsNo);

        //  convert date for display
        $created_date = date('d-M-y H:i', strtotime($data->created_date));
        $date_from = date('d-M-y', strtotime($data->date_from));
        $date_to = date('d-M-y', strtotime($data->date_to));

        $baseStyleFont = "font-size:9pt;font-family:Arial, sans-serif;margin-top:0;";

        // Template Header
        $html = "
            <table style='$baseStyleFont' cellpadding='2' width='100%'>
                <tr>
                    <td width='40%'>
                        DMS Nomor&nbsp;:&nbsp; $data->dms_no
                    </td>
                    <td width='30%'>
                        DMS Type&nbsp;:&nbsp; $data->dms_type
                    </td>
                    <td width='30%'>
                        Created Date&nbsp;:&nbsp; $created_date
                    </td>
                </tr>
                <tr>
                    <td width='40%'>
                        Date From&nbsp;:&nbsp; $date_from
                    </td>
                    <td width='30%'>
                        To Date&nbsp;:&nbsp; $date_to
                    </td>
                    <td width='30%'>
                        DMS Focus&nbsp;:&nbsp; $data->dms_focus
                    </td>
                </tr>
            </table>
        ";

        $html .= "
            <table style='$baseStyleFont' cellpadding='2' width='100%'>
                <tr>
                    <td width='70%'>
                        Principal&nbsp;:&nbsp;$data->principal
                    </td>
                    <td width='30%'>
                        State&nbsp;:&nbsp;$data->state
                    </td>
                </tr>
            </table>
        ";

        if(is_null($data->dms_note) || $data->dms_note == '' || strlen($data->dms_note) < 0 
        || empty($data->dms_note)) {
            $dmsNote = 'Tidak ada keterangan';
        } else {
            $dmsNote = $data->dms_note;
        }

        $html .= "
            <table style='$baseStyleFont' cellpadding='2' width='100%'>
                <tr>
                    <td>
                        Refrence No&nbsp;:&nbsp;$data->ref_no
                    </td>
                </tr>
                <tr>
                    <td>
                        Note Text&nbsp;:&nbsp;$dmsNote
                    </td>
                </tr>
            </table>
        ";

        $all_outlet = $data->all_outlet ? $data->all_outlet : 'No';
        $all_product_grp  = $data->all_product_grp  ? $data->all_product_grp  : 'No';
        $all_product = $data->all_product ? $data->all_product : 'No';
        $rma_not_allowed = $data->rma_not_allowed ? $data->rma_not_allowed : 'No';
        $hna_flag = $data->hna_flag ? $data->hna_flag : 'No';
        $netto_flag = $data->netto_flag ? $data->netto_flag : 'No';

        // all outlet dkk
        $html .= "
            <table style='$baseStyleFont;margin-top:25px;' cellpadding='2' width='100%'>
                <tr>
                    <td>
                        All Product :
                        <td style='border: 1px solid #000;display:inline-block;
                            width: 6%;padding:5px !important;padding-left:10px;
                        '>
                            $all_outlet
                        </td>
                    </td>
                    <td>
                        <span>
                            All Product Group :
                            <td style='border: 1px solid #000;display:inline-block;
                                width: 6%;padding:5px !important;padding-left:10px;
                            '>$all_product_grp</td>
                        </span>
                    </td>
                    <td>
                        <span>
                            All Product :
                            <td style='border: 1px solid #000;display:inline-block;
                                width: 6%;padding:5px !important;padding-left:10px;
                            '>$all_product</td>
                        </span>
                    </td>
                    <td>
                        <span>
                            RMA Not Allowed :
                            <td style='border: 1px solid #000;display:inline-block;
                                width: 6%;padding:5px !important;padding-left:10px;
                            '>$rma_not_allowed</td>
                        </span>
                    </td>
                </tr>
            </table>
        ";

        $html .= "
            <table style='$baseStyleFont;margin-top:5px;' cellpadding='2' width='100%'>
                <tr>
                    <td width='25%'>
                        <span>
                            HNA Flag :
                            <td style='border: 1px solid #000;display:inline-block;
                                width: 5%;padding:5px !important;padding-left:10px;
                            '>$hna_flag</td>
                        </span>
                    </td>
                    <td>
                        <span>
                            Netto Flag :
                            <td style='border: 1px solid #000;display:inline-block;
                                width: 5%;padding:5px !important;padding-left:10px;
                            '>$netto_flag</td>
                        </span>
                    </td>
                    <td>
                        <span>
                            <td style='display:inline-block;
                                width: 5%;padding:5px !important;padding-left:10px;
                            '></td>
                        </span>
                    </td>
                    <td>
                        <span>
                            <td style='display:inline-block;
                                width: 5%;padding:5px !important;padding-left:10px;
                            '></td>
                        </span>
                    </td>
                </tr>
            </table>
        ";
        // End Of Templeate Header

        // Template Product
        $html .="
            <table cellpadding='6' cellspacing='0' width='100%'
                style='margin:25px 0;border: 1px solid #000;font-size:8.5pt;font-famliy:'Arial', sans-serif;'
            >
                <thead>
                    <tr style='border:1px solid #000;'>
                        <td style='text-align: center;border:1px solid #000;'>Product</td>
                        <td style='text-align: center;border:1px solid #000;'>Product Description</td>
                        <td style='text-align: center;border:1px solid #000;'>Min Qty</td>
                        <td style='text-align: center;border:1px solid #000;'>Max Qty</td>
                        <td style='text-align: center;border:1px solid #000;'>Product Bonus</td>
                        <td style='text-align: center;border:1px solid #000;'>Product Description</td>
                        <td style='text-align: center;border:1px solid #000;'>Bonus</td>
                        <td style='text-align: center;border:1px solid #000;'>Kelipatan</td>
                        <td style='text-align: center;border:1px solid #000;'>Keterangan Discount</td>
                    </tr>
                </thead>
                <tbody>
        ";

        foreach($products as $key => $product)
        {
            $min_qty = (int) $product->min_qty;
            $max_qty = (int) $product->max_qty;
            $qty = (int) $product->quantity;
            $bnsQty = (int) $product->bonus_qty;
            $html .= "
                    <tr style='border:1px solid #000;'>
                        <td style='border:1px solid #000;'>
                            $product->part_no
                        </td>
                        <td style='border:1px solid #000;'>
                            $product->keterangan
                        </td>
                        <td style='border:1px solid #000;'>
                            $min_qty
                        </td>
                        <td style='border:1px solid #000;'>
                            $max_qty
                        </td>
                        <td style='border:1px solid #000;'>
                            $product->bonus_part
                        </td>
                        <td style='border:1px solid #000;'>
                            $product->desc_part_discount
                        </td>
                        <td style='border:1px solid #000;'>
                            $bnsQty
                        </td>
                        <td style='border:1px solid #000;'>
                            $product->kelipatan
                        </td>
                        <td style='border:1px solid #000;'>
                            $product->ket_disc
                        </td>
                    </tr>
            ";
        }

        // tutup table
        $html .="</tbody></table>";
        // End Of Template Product

        // <hr/>
        $html .= '<hr style="border:1px solid #000;width:100%;" />';

        // Template Order Type
        $orderTypes = GeneralHelper::getOrderTypeByDmsNo($this->dmsNo);

        $html .="
            <table style='margin:5px 0;$baseStyleFont' cellpadding='2' width='100%'>
                <thead>
                    <tr>
                        <td width='25%' style='text-align:justify;'>Order Type</td>
                        <td width='25%' style='text-align:justify;'>Exclude/Include</td>
                        <td width='25%' style='text-align:justify;'>Description</td>
                        <td width='25%' style='text-align:justify;'></td>
                    </tr>
                </thead>
                <tbody>
        ";

        if($orderTypes->count() >  0)
        {
            foreach($orderTypes as $row)
            {
                $html .= "
                    <tr>
                        <td width='25%' style='text-align:justify;'>$row->order_type</td>
                        <td width='25%' style='text-align:justify;'>$row->exclude_include</td>
                        <td width='25%' style='text-align:justify;'></td>
                        <td width='25%' style='text-align:justify;'></td>
                    </tr>
                ";
            }
        } else {
            $html .= "
                <tr>
                    <td width='25%' style='text-align:justify;'></td>
                    <td width='25%' style='text-align:justify;'></td>
                    <td width='25%' style='text-align:justify;'></td>
                    <td width='25%' style='text-align:justify;'></td>
                </tr>
            ";
        }

        // tutup table order type
        $html .= "</tbody></table>";
        // End Of Template Order Type

        // Template Product Group
        $productGroups = GeneralHelper::getProductGroupByDmsNo($this->dmsNo);

        $html .="
            <table style='margin:5px 0;$baseStyleFont' cellpadding='2' width='100%'>
                <thead>
                    <tr>
                        <td width='25%' style='text-align:justify;'>Product Group</td>
                        <td width='25%' style='text-align:justify;'>Exclude/Include</td>
                        <td width='50%' style='text-align:justify;'>Description</td>
                    </tr>
                </thead>
                <tbody>
        ";

        if($productGroups->count() > 0)
        {
            foreach($productGroups as $row)
            {
                $html .= "
                    <tr>
                        <td width='25%' style='text-align:justify;'>$row->sales_group</td>
                        <td width='25%' style='text-align:justify;'>$row->exclude_include</td>
                        <td width='50%' style='text-align:justify;'></td>
                    </tr>
                ";
            }
        } else {
            $html .= "
                <tr>
                    <td width='25%' style='text-align:justify;'></td>
                    <td width='25%' style='text-align:justify;'></td>
                    <td width='50%' style='text-align:justify;'></td>
                </tr>
            ";
        }

        // tutup table product group
        $html .= "</tbody></table>";
        // End Of Template Product Group

        // Template Customer Group
        $custGroups = GeneralHelper::getCusotmerGroup($this->dmsNo);

        $html .="
            <table style='margin:5px 0;$baseStyleFont' cellpadding='2' width='100%'>
                <thead>
                    <tr>
                        <td width='25%' style='text-align:justify;'>Customer Group</td>
                        <td width='25%' style='text-align:justify;'>Exclude/Include</td>
                        <td width='50%' style='text-align:justify;'>Description</td>
                    </tr>
                </thead>
                <tbody>
        ";

        if($custGroups->count() > 0)
        {
            foreach($custGroups as $row)
            {
                $html .= "
                    <tr>
                        <td width='25%' style='text-align:justify;'>$row->cust_group</td>
                        <td width='25%' style='text-align:justify;'>$row->exclude_include</td>
                        <td width='50%' style='text-align:justify;'></td>
                    </tr>
                ";
            }
        } else {
            $html .= "
                <tr>
                    <td width='25%' style='text-align:justify;'></td>
                    <td width='25%' style='text-align:justify;'></td>
                    <td width='50%' style='text-align:justify;'></td>
                </tr>
            ";
        }

        // tutup table customer group
        $html .= "</tbody></table>";
        // End Of Template Customer Group

        // Template Customer Chain
        $custChains = GeneralHelper::getCustomerChain($this->dmsNo);

        $html .="
            <table style='margin:5px 0;$baseStyleFont' cellpadding='2' width='100%'>
                <thead>
                    <tr>
                        <td width='25%' style='text-align:justify;'>Customer Chain</td>
                        <td width='25%' style='text-align:justify;'>Exclude/Include</td>
                        <td width='50%' style='text-align:justify;'></td>
                    </tr>
                </thead>
                <tbody>
        ";

        if($custChains->count() > 0)
        {
            foreach($custChains as $row)
            {
                $html .= "
                    <tr>
                        <td width='25%' style='text-align:justify;'>$row->cust_chain</td>
                        <td width='25%' style='text-align:justify;'>$row->exclude_include</td>
                        <td width='50%' style='text-align:justify;'></td>
                    </tr>
                ";
            }
        } else {
            $html .= "
                <tr>
                    <td width='25%' style='text-align:justify;'></td>
                    <td width='25%' style='text-align:justify;'></td>
                    <td width='50%' style='text-align:justify;'></td>
                </tr>
            ";
        }

        // tutup table customer chain
        $html .= "</tbody></table>";
        // End Of Template Customer Chain

        // Template Customer Id
        $customers = GeneralHelper::getCustomerByDmsNo($this->dmsNo);

        $html .="
            <table style='margin:5px 0;$baseStyleFont' cellpadding='2' width='100%'>
                <thead>
                    <tr>
                        <td width='25%' style='text-align:justify;'>Customer Id</td>
                        <td width='25%' style='text-align:justify;'>Exclude/Include</td>
                        <td width='25%' style='text-align:justify;'>Customer Name</td>
                        <td width='25%' style='text-align:justify;'></td>
                    </tr>
                </thead>
                <tbody>
        ";

        if(count($customers) > 0)
        {
            foreach($customers as $row)
            {
                $html .= "
                    <tr>
                        <td width='25%' style='text-align:justify;'>$row->customer_id</td>
                        <td width='25%' style='text-align:justify;'>$row->exclude_include</td>
                        <td width='25%' style='text-align:justify;'>$row->customer_name</td>
                        <td width='25%' style='text-align:justify;'></td>
                    </tr>
                ";
            }
        } else {
            $html .= "
                <tr>
                    <td width='25%' style='text-align:justify;'></td>
                    <td width='25%' style='text-align:justify;'></td>
                    <td width='25%' style='text-align:justify;'></td>
                    <td width='25%' style='text-align:justify;'></td>
                </tr>
            ";
        }

        // tutup table customer id
        $html .= "</tbody></table>";
        // End Of Template Customer Id

        // Template Order Value
        $orderValues = GeneralHelper::getOrderValuesByDmsNo($this->dmsNo);

        $html .="
            <p style='margin:5px 0 !important;padding:2px;font-family:Arial, sans-serif;font-size:9pt;'>
                ORDER VALUE
            </p>
            <table style='margin:5px 0;$baseStyleFont' cellpadding='2' width='100%'>
                <thead>
                    <tr>
                        <td>Line Nomor</td>
                        <td>Min Value</td>
                        <td>Max Value</td>
                        <td>Type Discount</td>
                        <td>Discount Value</td>
                    </tr>
                </thead>
                <tbody>
        ";

        if($orderValues->count() > 0){
            foreach($orderValues as $value)
            {
                $html .= "

                        <tr>
                            <td>$value->line_no</td>
                            <td>$value->min_value</td>
                            <td>$value->max_value</td>
                            <td>$value->discount_type</td>
                            <td>$value->discount_value</td>
                        </tr>
                ";
            }
        } else {
            $html .= "
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
            ";
        }
        // end of table order value
        $html .= "</tbody></table>";
        // End Of Template Order Value

        // Template Mix Bonus
        // mix bonus
        $mixBonus = GeneralHelper::getMixedBonusByDmsNo($this->dmsNo);

        $html .="
            <p style='margin:5px 0 !important;padding:2px;font-family:Arial, sans-serif;font-size:9pt;'>
                MIX BONUS
            </p>
            <table style='margin:5px 0;$baseStyleFont' cellpadding='2' width='100%'>
                <thead>
                    <tr>
                        <td width='25%' style='text-align:justify;'>Min Qty Bonus</td>
                        <td width='25%' style='text-align:justify;'>Max Qty Bonus</td>
                        <td width='25%' style='text-align:justify;'>Bonus Quantity</td>
                        <td width='25%' style='text-align:justify;'>Keterangan Discount</td>
                    </tr>
                </thead>
                <tbody>
        ";

        if($mixBonus->count() > 0)
        {
            foreach($mixBonus as $bonus)
            {
                $html .= "
                        <tr>
                            <td width='25%' style='text-align:justify;'>$bonus->min_qty</td>
                            <td width='25%' style='text-align:justify;'>$bonus->max_qty</td>
                            <td width='25%' style='text-align:justify;'>$bonus->bonus_qty</td>
                            <td width='25%' style='text-align:justify;'>$bonus->note</td>
                        </tr>
                ";
            }
        } else {
            $html .= "
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
            ";
        }

        $html .= "</tbody></table>";
        // End Of Template Mix Bonus

        // Template Mix Persen
        $mixPersen = GeneralHelper::getMixedPersenByDmsNo($this->dmsNo);

        $html .="
            <p style='margin:5px 0 !important;padding:2px;font-family:Arial, sans-serif;font-size:9pt;'>
                MIX PERSEN
            </p>
            <table style='margin:5px 0;$baseStyleFont' cellpadding='2' width='100%'>
                <thead>
                    <tr>
                        <td width='25%' style='text-align:justify;'>Min Qty</td>
                        <td width='25%' style='text-align:justify;'>Max Qty</td>
                        <td width='25%' style='text-align:justify;'>Keterangan Discount</td>
                        <td width='25%' style='text-align:justify;'></td>
                    </tr>
                </thead>
                <tbody>
        ";

        if($mixPersen->count() > 0)
        {
            foreach($mixPersen as $row)
            {
                $html .= "
                    <tr>
                        <td width='25%' style='text-align:justify;'>$row->min_qty</td>
                        <td width='25%' style='text-align:justify;'>$row->max_qty</td>
                        <td width='25%' style='text-align:justify;'>$row->note</td>
                        <td width='25%' style='text-align:justify;'></td>
                    </tr>
                ";
            }
        } else {
            $html .= "
                <tr>
                    <td width='25%' style='text-align:justify;'></td>
                    <td width='25%' style='text-align:justify;'></td>
                    <td width='25%' style='text-align:justify;'></td>
                    <td width='25%' style='text-align:justify;'></td>
                </tr>
            ";
        }

        // tutup table mix perse
        $html .= "</tbody></table>";
        // End Of Template Mix Persen

        // Template Of Signature By
        $signatureBy = GeneralHelper::getSignatureByDmsNo($this->dmsNo);

        $html .="
            <p style='margin:5px 0 !important;padding:2px;font-family:Arial, sans-serif;font-size:9pt;'>
                SIGNATURE BY <b>:</b>
            </p>
            <table style='margin:5px 0;$baseStyleFont' cellpadding='2' width='100%'>
                <thead>
                    <tr>
                        <td width='25%' style='text-align:justify;'>Person Id</td>
                        <td width='25%' style='text-align:justify;'>Name Signature</td>
                        <td width='25%' style='text-align:justify;'>Keterangan</td>
                        <td width='25%' style='text-align:justify;'></td>
                    </tr>
                </thead>
                <tbody>
        ";

        if($signatureBy->count() > 0)
        {
            foreach($signatureBy as $row)
            {

                $html .= "
                        <tr>
                            <td width='25%' style='text-align:justify;'>$row->person_id</td>
                            <td width='25%' style='text-align:justify;'>$row->name</td>
                            <td width='25%' style='text-align:justify;'>$row->notes</td>
                            <td width='25%' style='text-align:justify;'></td>
                        </tr>
                ";
            }
        } else {
            $html .= "
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
            ";
        }
        // end of table  signature by
        $html .= "</tbody></table>";
        $html .= '<hr style="border:1px solid #000;width:100%;" />';
        // End Of Template Signature By

        // INFO INSERT BY
        $html .="
            <p style='margin:5px 0 !important;padding:2px;font-family:Arial, sans-serif;font-size:9pt;'>
                INFO INSERT BY <b>:</b>
            </p>
            <table style='margin:5px 0;$baseStyleFont' cellpadding='2' width='100%'>
                <thead>
                    <tr>
                        <td width='25%' style='text-align:justify;'>User</td>
                        <td width='25%' style='text-align:justify;'>Date Info</td>
                        <td width='25%' style='text-align:justify;'>Keterangan</td>
                        <td width='25%' style='text-align:justify;'></td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td width='25%' style='text-align:justify;'></td>
                        <td width='25%' style='text-align:justify;'></td>
                        <td width='25%' style='text-align:justify;'></td>
                        <td width='25%' style='text-align:justify;'></td>
                    </tr>
                </tbody>
            </table>
        ";

        // TEmplate Dms History
        $histories = GeneralHelper::getDmsHistoryByDmsNo($this->dmsNo);

        $html .="
            <p style='margin:5px 0 !important;padding:2px;font-family:Arial, sans-serif;font-size:9pt;'>
                DMS HISTORY PROSES <b>:</b>
            </p>
            <table style='margin:5px 0;$baseStyleFont' cellpadding='2' width='100%'>
                <thead>
                    <tr>
                        <td width='25%' style='text-align:justify;'>State</td>
                        <td width='25%' style='text-align:justify;'>Date Proses</td>
                        <td width='25%' style='text-align:justify;'>Diproses Oleh</td>
                        <td width='25%' style='text-align:justify;'>Catatan</td>
                    </tr>
                </thead>
                <tbody>
        ";

        if($histories->count() > 0)
        {
            foreach($histories as $history)
            {
                $date_entered = date("d/m/Y H:i:s", strtotime($history->date_entered));
                $html .= "
                    <tr>
                        <td width='25%' style='text-align:justify;'>$history->state</td>
                        <td width='25%' style='text-align:justify;'>$date_entered</td>
                        <td width='25%' style='text-align:justify;'>$history->userid</td>
                        <td width='25%' style='text-align:justify;'>$history->message_text</td>
                    </tr>
                ";
            }
        }  else {
            $html .= "
                <tr>
                    <td width='25%' style='text-align:justify;'></td>
                    <td width='25%' style='text-align:justify;'></td>
                    <td width='25%' style='text-align:justify;'></td>
                    <td width='25%' style='text-align:justify;'></td>
                </tr>
            ";
        }

        $html .= "</tbody></table>";
        // End Of Template Dms History

        return $html;
    }

    public function footer() :string {
        $now = date('d/m/Y H:i:s', time());

        $footer = '<table width="100%" style="vertical-align: bottom; font-family: Arial;
            font-size: 9pt; color: #000000;">
            <tr>
                <td width="75%">
                    <span>
                        Print Date&nbsp;:&nbsp;'.$now.' Document '. $this->dmsNo .'
                    </span>
                </td>
                <td width="25%" style="text-align: right; ">{PAGENO}</td>
            </tr>
        </table>';
        return $footer;
    }

    public function handle() :void {
        $mpdf = new Mpdf([
            // 210 mm X 330mm
            'debug'=>FALSE,'mode' => 'utf-8', 'orientation' => 'P', 'format' => [210, 330],
            'setAutoTopMargin' => false,
            'autoMarginPadding' => 0,
            'bleedMargin' => 0,
            'crossMarkMargin' => 0,
            'cropMarkMargin' => 0,
            'nonPrintMargin' => 0,
            'margBuffer' => 0,
            'collapseBlockMargins' => false,
            'tempDir' => '/tmp',
        ]);

        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHTMLFooter($this->footer());
        $mpdf->WriteHTML($this->body());
        $mpdf->Output("$this->dmsNo.pdf", 'I');
        exit;
    }
}
