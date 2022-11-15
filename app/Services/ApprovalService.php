<?php
namespace App\Services;

use App\Http\Helpers\GeneralHelper;
use Illuminate\Support\Facades\DB;

class ApprovalService {

    public function doApproval($data, string $overview)
    {
        if($overview == 'branch') { // approval branch
            $do = $this->doApprovalBranch($data);
        } else if($overview == 'sent')
        { // approval sent
            $do = $this->doApprovalSent($data);
        } else if($overview == 'close') { // approval close dms
            $do = $this->closeDms($data['dms_no'], $data['principal']);
        }
        
        return $do;
    }

    /**
     * @param string $dmsNo
     */
    private function approvalByKpst(string $dmsNo, string $note = null)
    {
        $do = GeneralHelper::approvalByKpst($dmsNo);

        if(!$do["error"]) {
            $state = 'ApprovedByKpst';
            $this->insertNoteTextApproval($dmsNo, $state, $note);
        }

        return $do;
    }

    private function insertNoteTextApproval(string $dmsNo, string $state, string $note = null) :void
    {
        DB::table("IFSAPP.CTM_DMS_HEAD_HIST_TAB")->where('dms_no', $dmsNo)->where('rowstate', $state)
        ->update([
            "message_text" => $note,
        ]);
    }

    private function approvalByPrincipal(string $dmsNo, string $note = null)
    {
        $do = GeneralHelper::approvalByPrincipal($dmsNo);

        if(!$do["error"]) {
            $state = 'ApprovedByPrincipal';
            $this->insertNoteTextApproval($dmsNo, $state, $note);
        }

        return $do;
    }

    private function cancelDms(string $dmsNo, string $principal, string $note = null)
    {
        $do = GeneralHelper::cancelApproval($dmsNo, $principal);

        if(!$do["error"]) {
            $state = 'Cancelled';
            $this->insertNoteTextApproval($dmsNo, $state, $note);
        }

        return $do;
    }

    private function approvalSent(string $dmsNo, string $note = null)
    {
        $do = GeneralHelper::approvalSent($dmsNo);

        if(!$do["error"]) {
            $state = 'Sent';
            $this->insertNoteTextApproval($dmsNo, $state, $note);
        }

        return $do;
    }

    private function closeDms(string $dmsNo, string $principal) {
        $do = GeneralHelper::closeDms($dmsNo, $principal);

        return $do;
    }

    private function doApprovalBranch($data)
    {
        // get PE/PB/dkk
        $checkPe = GeneralHelper::checkPE($data['dms_no']);
        
        // cek action
        if($data['action'] == 'cancel')
        {
            $approveOrCancel = $this->cancelDms($data['dms_no'], $data['principal'], $data['note']);
        } else if($data['action'] == 'approved') {
            
            // jika tidak ada PE approvalByKpst
            if(!$checkPe)
            {
                $approveOrCancel = $this->approvalByKpst($data['dms_no'], $data['note']);
            } else { // jika ada PE, lakukan approval sent
                $approveOrCancel = $this->approvalByKpst($data['dms_no'], $data['note']);
                $approveOrCancel = $this->approvalSent($data['dms_no'], $data['note']);
            }

        }

        return $approveOrCancel;
    }

    private function doApprovalSent($data)
    {
        // cek action
        if($data['action'] == 'cancel')
        {
            $approveOrCancel = $this->cancelDms($data['dms_no'], $data['principal'], $data['note']);
        } else if($data['action'] == 'approved') {
            $approveOrCancel = $this->approvalByPrincipal($data['dms_no'], $data['note']);
        }
        return $approveOrCancel;
    }

}
