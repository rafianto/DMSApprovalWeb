<?php
namespace App\Services;

use App\Http\Helpers\GeneralHelper;

class TodoService {
    private $data;

    /**
     * @return array
     */
    public function todo(string $dmsNo, $state)
    {
        $this->data['idd'] = $dmsNo;
        $this->data['isdata'] = GeneralHelper::getDmsHeaderByDmsNo($dmsNo, $state);
        $this->data['sqldmshist'] = GeneralHelper::getHistoryDmsHeaderByDmsNo($dmsNo);
        $this->data['isdetailprod'] = GeneralHelper::getProductByDmsNo($dmsNo);
        $this->data['orderValues'] = GeneralHelper::getOrderValuesByDmsNo($dmsNo);
        $this->data['mixBonus'] = GeneralHelper::getMixedBonusByDmsNo($dmsNo);

        // mix persen
        $this->data['mixPersen'] = GeneralHelper::getMixedPersenByDmsNo($dmsNo);

        // signature by
        $this->data['signatureBy'] = GeneralHelper::getSignatureByDmsNo($dmsNo);

        // customer_group
        $this->data['customer_group'] = GeneralHelper::getCusotmerGroup($dmsNo);

        $this->data['customer_chains'] = GeneralHelper::getCustomerChain($dmsNo);

        // getCustomerByDmsNo(string $dms_no, string $table_customer_name) => berdasarkan skema
        $this->data['customers'] = GeneralHelper::getCustomerByDmsNo($dmsNo);

        $this->data['orderTypes'] = GeneralHelper::getOrderTypeByDmsNo($dmsNo);

        $this->data['productGroups'] = GeneralHelper::getProductGroupByDmsNo($dmsNo);

        return $this->data;
    }

    /**
     * @return array
     */
    public function todoHistory(string $dmsNo)
    {
        $this->data['idd'] = $dmsNo;
        $this->data['isdata'] = GeneralHelper::getDmsHeaderByDmsNo($dmsNo);
        $this->data['sqldmshist'] = GeneralHelper::getHistoryDmsHeaderByDmsNo($dmsNo);
        $this->data['isdetailprod'] = GeneralHelper::getProductByDmsNo($dmsNo);
        $this->data['orderValues'] = GeneralHelper::getOrderValuesByDmsNo($dmsNo);
        $this->data['mixBonus'] = GeneralHelper::getMixedBonusByDmsNo($dmsNo);

        // mix persen
        $this->data['mixPersen'] = GeneralHelper::getMixedPersenByDmsNo($dmsNo);

        // signature by
        $this->data['signatureBy'] = GeneralHelper::getSignatureByDmsNo($dmsNo);

        // customer_group
        $this->data['customer_group'] = GeneralHelper::getCusotmerGroup($dmsNo);

        $this->data['customer_chains'] = GeneralHelper::getCustomerChain($dmsNo);

        // getCustomerByDmsNo(string $dms_no, string $table_customer_name) => berdasarkan skema
        $this->data['customers'] = GeneralHelper::getCustomerByDmsNo($dmsNo);

        $this->data['orderTypes'] = GeneralHelper::getOrderTypeByDmsNo($dmsNo);

        $this->data['productGroups'] = GeneralHelper::getProductGroupByDmsNo($dmsNo);

        return $this->data;
    }
}
