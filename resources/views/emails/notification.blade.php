<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lampiran DMS Proses Approved</title>
</head>

<body style="margin: 0; padding: 0;">

    <table align="left" border="0" cellpadding="0" cellspacing="0" width="85%" style="border-collapse: collapse;">
        <tr>
            <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                <h2>
                    Lampiran DMS Proses
                </h2>
                <!-- Header DMS -->
                <table border="0" cellpadding="8" cellspacing="0"
                    width="100%" style="border-collapse: collapse;font-size:9pt;margin:25px 0 !important;"
                >
                    <tr>
                        <td width="30%">
                            DMS Nomor
                        </td>
                        <td width="2%" style="text-align:center;">:</td>
                        <td width="68%">{{ $head->dms_no }}</td>
                    </tr>
                    <tr>
                        <td width="30%">
                            Tanggal Dibuat
                        </td>
                        <td width="2%" style="text-align:center;">:</td>
                        <td width="68%">{{ $head->created_date }}</td>
                    </tr>
                    <tr>
                        <td width="30%">
                            Berlaku Mulai
                        </td>
                        <td width="2%" style="text-align:center;">:</td>
                        <td width="68%">{{ $head->date_from }}</td>
                    </tr>
                    <tr>
                        <td width="30%">
                            Sampai Dengan
                        </td>
                        <td width="2%" style="text-align:center;">:</td>
                        <td width="68%">{{ $head->date_to }}</td>
                    </tr>
                    <tr>
                        <td width="30%">
                            HNA Flag
                        </td>
                        <td width="2%" style="text-align:center;">:</td>
                        <td width="68%">{{ $head->hna_flag }}</td>
                    </tr>
                    <tr>
                        <td width="30%">
                            Netto Flag
                        </td>
                        <td width="2%" style="text-align:center;">:</td>
                        <td width="68%">{{ $head->netto_flag }}</td>
                    </tr>
                    <tr>
                        <td width="30%">
                            Note
                        </td>
                        <td width="2%" style="text-align:center;">:</td>
                        <td width="68%">{{ $head->note_text }}</td>
                    </tr>
                    <tr>
                        <td width="30%">
                            Order Type
                        </td>
                        <td width="2%" style="text-align:center;">:</td>
                        <td width="68%">
                            {{ $order_type ? $order_type->order_type : null }} - {{ $order_type ? $order_type->exclude_include : null }}
                        </td>
                    </tr>
                    <tr>
                        <td width="30%">
                            Customer
                        </td>
                        <td width="2%" style="text-align:center;">:</td>
                        <td width="68%">
                            {{ $customers ? $customers->customer_id : null }} - {{ $customers ? $customers->exclude_include : null }}
                        </td>
                    </tr>
                </table>
                <!-- End Header DMS -->
                <!-- Product DMS -->
                <h3>
                    Product
                </h3>
                <table border="1" cellpadding="8" cellspacing="0"
                    width="100%"
                    style="border-collapse: collapse;font-size:9pt;margin:25px 0 !important;"
                >
                    <thead>
                        <tr>
                            <td style="text-align:center !important;">
                                Part No
                            </td>
                            <td style="text-align:center !important;">
                                Product Description
                            </td>
                            <td style="text-align:center !important;">
                                Line No
                            </td>
                            <td style="text-align:center !important;">
                                Min Quantity
                            </td>
                            <td style="text-align:center !important;">
                                Max Quantity
                            </td>
                            <td style="text-align:center !important;">
                                Keterangan
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($products) <= 0)
                            <tr>
                                <td colspan="5" style="text-align:center !important;">
                                    <b>Tidak ada data.</b>
                                </td>
                            </tr>
                        @endif
                        @foreach ($products as $product)
                            <tr>
                                <td style="text-align: justify !important;">
                                    {{ $product->part_no }}
                                </td>
                                <td style="text-align: justify !important;">
                                    {{ $product->keterangan }}
                                </td>
                                <td style="text-align: justify !important;">
                                    {{ $product->line_no }}
                                </td>
                                <td style="text-align: justify !important;">
                                    {{ $product->min_qty }}
                                </td>
                                <td style="text-align: justify !important;">
                                    {{ $product->max_qty }}
                                </td>
                                <td style="text-align: justify !important;">
                                    {{ $product->ket_disc }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- End Of Product DMS -->
                <!-- Product Discount DMS -->
                <h3>
                    Product Discount
                </h3>
                <table border="1" cellpadding="8" cellspacing="0"
                    width="100%"
                    style="border-collapse: collapse;font-size:9pt;margin:25px 0 !important;"
                >
                    <thead>
                        <tr>
                            <td style="text-align:center !important;">
                                Part No
                            </td>
                            <td style="text-align:center !important;">
                                Line No
                            </td>
                            <td style="text-align:center !important;">
                                Min Quantity
                            </td>
                            <td style="text-align:center !important;">
                                Max Quantity
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($product_discounts) <= 0)
                            <tr>
                                <td colspan="4" style="text-align:center !important;">
                                    <b>Tidak ada data.</b>
                                </td>
                            </tr>
                        @endif
                        @foreach ($product_discounts as $product)
                            <tr>
                                <td style="text-align: justify !important;">
                                    {{ $product->part_no }}
                                </td>
                                <td style="text-align: justify !important;">
                                    {{ $product->line_no }}
                                </td>
                                <td style="text-align: justify !important;">
                                    {{ $product->min_qty }}
                                </td>
                                <td style="text-align: justify !important;">
                                    {{ $product->max_qty }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- End Of Product Discount DMS -->

                <!-- Product Group DMS -->
                <h3>
                    Product Group
                </h3>
                <table border="1" cellpadding="8" cellspacing="0"
                    width="100%"
                    style="border-collapse: collapse;font-size:9pt;margin:25px 0 !important;"
                >
                    <thead>
                        <tr>
                            <td style="text-align:center !important;">
                                Sales Group
                            </td>
                            <td style="text-align:center !important;">
                                Exclude Include
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($product_groups) <= 0)
                            <tr>
                                <td colspan="2" style="text-align:center !important;">
                                    <b>Tidak ada data.</b>
                                </td>
                            </tr>
                        @endif
                        @foreach ($product_groups as $row)
                            <tr>
                                <td style="text-align: justify !important;">
                                    {{ $row->sales_group }}
                                </td>
                                <td style="text-align: justify !important;">
                                    {{ $row->exclude_include }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- End Of Product GROUP DMS -->

                <!-- Order Values DMS -->
                <h3>
                    Order Values
                </h3>
                <table border="1" cellpadding="8" cellspacing="0"
                    width="100%"
                    style="border-collapse: collapse;font-size:9pt;margin:25px 0 !important;"
                >
                    <thead>
                        <tr>
                            <td style="text-align:center !important;">
                                Part No
                            </td>
                            <td style="text-align:center !important;">
                                Line No
                            </td>
                            <td style="text-align:center !important;">
                                Min Value
                            </td>
                            <td style="text-align:center !important;">
                                Max Value
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($product_groups) <= 0)
                            <tr>
                                <td colspan="4" style="text-align:center !important;">
                                    <b>Tidak ada data.</b>
                                </td>
                            </tr>
                        @endif
                        @foreach ($order_values as $row)
                            <tr>
                                <td style="text-align: justify !important;">
                                    {{ $row->part_no }}
                                </td>
                                <td style="text-align: justify !important;">
                                    {{ $row->line_no }}
                                </td>
                                <td style="text-align: justify !important;">
                                    {{ $row->min_value }}
                                </td>
                                <td style="text-align: justify !important;">
                                    {{ $row->max_value }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- End Of Order Values DMS -->

                <!-- Customer Group DMS -->
                <h3>
                    Customer Group
                </h3>
                <table border="1" cellpadding="8" cellspacing="0"
                    width="100%"
                    style="border-collapse: collapse;font-size:9pt;margin:25px 0 !important;"
                >
                    <thead>
                        <tr>
                            <td style="text-align:center !important;">
                                Customer Group
                            </td>
                            <td style="text-align:center !important;">
                                Exclude Include
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($customer_groups) <= 0)
                            <tr>
                                <td colspan="2" style="text-align:center !important;">
                                    <b>Tidak ada data.</b>
                                </td>
                            </tr>
                        @endif
                        @foreach ($customer_groups as $row)
                            <tr>
                                <td style="text-align: justify !important;">
                                    {{ $row->cust_group }}
                                </td>
                                <td style="text-align: justify !important;">
                                    {{ $row->exclude_include }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- End Of Customer GROUP DMS -->

                <!-- Customer Chain DMS -->
                <h3>
                    Customer Chain
                </h3>
                <table border="1" cellpadding="8" cellspacing="0"
                    width="100%"
                    style="border-collapse: collapse;font-size:9pt;margin:25px 0 !important;"
                >
                    <thead>
                        <tr>
                            <td style="text-align:center !important;">
                                Customer Chain
                            </td>
                            <td style="text-align:center !important;">
                                Exclude Include
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($customer_chains) <= 0)
                            <tr>
                                <td colspan="2" style="text-align:center !important;">
                                    <b>Tidak ada data.</b>
                                </td>
                            </tr>
                        @endif
                        @foreach ($customer_chains as $row)
                            <tr>
                                <td style="text-align: justify !important;">
                                    {{ $row->cust_chain }}
                                </td>
                                <td style="text-align: justify !important;">
                                    {{ $row->exclude_include }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- End Of Customer Chain DMS -->

                <!-- Mix Bonus DMS -->
                <h3>
                    Mixed Bonus
                </h3>
                <table border="1" cellpadding="8" cellspacing="0"
                    width="100%"
                    style="border-collapse: collapse;font-size:9pt;margin:25px 0 !important;"
                >
                    <thead>
                        <tr>
                            <td style="text-align:center !important;">
                                Line No
                            </td>
                            <td style="text-align:center !important;">
                                Min Quantity
                            </td>
                            <td style="text-align:center !important;">
                                Max Quantity
                            </td>
                            <td style="text-align:center !important;">
                                Min Amount
                            </td>
                            <td style="text-align:center !important;">
                                Max Amount
                            </td>
                            <td style="text-align:center !important;">
                                Bonus Quantity
                            </td>
                            <td style="text-align:center !important;">
                                Note
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($mix_bonuses) <= 0)
                            <tr>
                                <td colspan="7" style="text-align:center !important;">
                                    <b>Tidak ada data.</b>
                                </td>
                            </tr>
                        @endif
                        @foreach ($mix_bonuses as $row)
                            <tr>
                                <td style="text-align: justify !important;">
                                    {{ $row->line_no }}
                                </td>
                                <td style="text-align: justify !important;">
                                    {{ $row->min_qty }}
                                </td>
                                <td style="text-align: justify !important;">
                                    {{ $row->max_qty }}
                                </td>
                                <td style="text-align: justify !important;">
                                    {{ $row->min_amount }}
                                </td>
                                <td style="text-align: justify !important;">
                                    {{ $row->max_amount }}
                                </td>
                                <td style="text-align: justify !important;">
                                    {{ $row->bonus_qty }}
                                </td>
                                <td style="text-align: justify !important;">
                                    {{ $row->note }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- End Of Mix Bonus DMS -->

                <!-- Mix Bonus Detail DMS -->
                <h3>
                    Mixed Bonus Detail
                </h3>
                <table border="1" cellpadding="8" cellspacing="0"
                    width="100%"
                    style="border-collapse: collapse;font-size:9pt;margin:25px 0 !important;"
                >
                    <thead>
                        <tr>
                            <td style="text-align:center !important;">
                                Line No
                            </td>
                            <td style="text-align:center !important;">
                                Line Item No
                            </td>
                            <td style="text-align:center !important;">
                                Min Quantity
                            </td>
                            <td style="text-align:center !important;">
                                Discount Type
                            </td>
                            <td style="text-align:center !important;">
                                Discount Value
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($bonus_detail) <= 0)
                            <tr>
                                <td colspan="5" style="text-align:center !important;">
                                    <b>Tidak ada data.</b>
                                </td>
                            </tr>
                        @endif
                        @foreach ($bonus_detail as $row)
                            <tr>
                                <td style="text-align: justify !important;">
                                    {{ $row->line_no }}
                                </td>
                                <td style="text-align: justify !important;">
                                    {{ $row->line_item_no }}
                                </td>
                                <td style="text-align: justify !important;">
                                    {{ $row->min_qty }}
                                </td>
                                <td style="text-align: justify !important;">
                                    {{ $row->discount_type }}
                                </td>
                                <td style="text-align: justify !important;">
                                    {{ $row->discount_value }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- End Of Mix Bonus Detail DMS -->

                <!-- Mix Percent DMS -->
                <h3>
                    Mixed Percent
                </h3>
                <table border="1" cellpadding="8" cellspacing="0"
                    width="100%"
                    style="border-collapse: collapse;font-size:9pt;margin:25px 0 !important;"
                >
                    <thead>
                        <tr>
                            <td style="text-align:center !important;">
                                Line No
                            </td>
                            <td style="text-align:center !important;">
                                Line Item No
                            </td>
                            <td style="text-align:center !important;">
                                Min Quantity
                            </td>
                            <td style="text-align:center !important;">
                                Discount Type
                            </td>
                            <td style="text-align:center !important;">
                                Discount Value
                            </td>
                            <td style="text-align:center !important;">
                                Partial SUM
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($mix_persens) <= 0)
                            <tr>
                                <td colspan="6" style="text-align:center !important;">
                                    <b>Tidak ada data.</b>
                                </td>
                            </tr>
                        @endif
                        @foreach ($mix_persens as $row)
                            <tr>
                                <td style="text-align: justify !important;">
                                    {{ $row->line_no }}
                                </td>
                                <td style="text-align: justify !important;">
                                    {{ $row->line_item_no }}
                                </td>
                                <td style="text-align: justify !important;">
                                    {{ $row->min_qty }}
                                </td>
                                <td style="text-align: justify !important;">
                                    {{ $row->discount_type }}
                                </td>
                                <td style="text-align: justify !important;">
                                    {{ $row->discount_value }}
                                </td>
                                <td style="text-align: justify !important;">
                                    {{ $row->create_partial_sum }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- End Of Mix Percent DMS -->

                <!-- History Proses DMS -->
                <h3>
                    History Proses DMS
                </h3>
                <table border="1" cellpadding="8" cellspacing="0"
                    width="100%"
                    style="border-collapse: collapse;font-size:9pt;margin:25px 0 !important;"
                >
                    <thead>
                        <tr>
                            <td style="text-align:center !important;">
                                History No
                            </td>
                            <td style="text-align:center !important;">
                                Status
                            </td>
                            <td style="text-align:center !important;">
                                Tanggal
                            </td>
                            <td style="text-align:center !important;">
                                User Id
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($histories as $row)
                            <tr>
                                <td style="text-align: justify !important;">
                                    {{ $row->history_no }}
                                </td>
                                <td style="text-align: justify !important;">
                                    {{ $row->rowstate }}
                                </td>
                                <td style="text-align: justify !important;">
                                    {{ $row->date_entered }}
                                </td>
                                <td style="text-align: justify !important;">
                                    {{ $row->userid }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- End Of Mix Percent DMS -->

            </td>
        </tr>
    </table>

</body>

</html>
