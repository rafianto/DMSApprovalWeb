<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailNotificationApproval;
use App\Services\ApprovalService;
use App\Services\DatatableOverviewService;
use App\Services\OverviewPdfService;
use App\Services\OverviewService;
use App\Services\TodoService;

class BranchController extends Controller
{
    private $service;
    private $datatableService;
    private $todoService;
    private $approvalService;

    public function __construct(OverviewService $service, ApprovalService $approvalService,
        DatatableOverviewService $datatableService, TodoService $todoService){
        $this->middleware('non.active');
        $this->service = $service;
        $this->datatableService = $datatableService;
        $this->todoService = $todoService;
        $this->approvalService = $approvalService;
    }

    public function getBranch(Request $request) {
        return view('__proses.branch');
    }

    public function getAllData(Request $request, DataTables $dataTables)
    {
        $state = 'ApprovedByBranch';
        $view = 'dms_list_aprcab_pgview';
        $linkPdf = 'branchpdf';
        $linkTodo = 'branchtodo';

        // get data from mbs.dms_list_aprcab_pgview
        $data = $this->service->getAllDataOverview($state, $view);

        return $this->datatableService->datatableOverview($dataTables, $data, $linkPdf, $linkTodo);
    }

    public function getBranchpdf(string $dms_no)
    {

        $DmsNo = base64_decode($dms_no);
        $state = 'ApprovedByBranch';
        $view = 'dms_list_aprcab_pgview';

        $pdf = new OverviewPdfService($DmsNo, $state, $view);

        $pdf->handle();
    }

    public function getBranchtodo($id) {

        $idd = base64_decode($id);
        $dmsNo = $idd;
        $state = "ApprovedByBranch";

        $data = $this->todoService->todo($dmsNo, $state);

        return view('__proses.branch_todo', $data);
    }

    /**
     * this for approve or cancel
     * @param Request $request
     */
    public function approveOrCancel(Request $request)
    {
        $message = [
            "dms_no.required" => "Dms No field kosong. Dms No tidak boleh kosong<br />",
            "principal.required" => "Principal field kosong. Principal tidak boleh kosong.",
        ];

        $validator = Validator::make($request->all(), [
            "dms_no" => "required",
            "principal" => "required",
        ], $message);

        if ($validator->fails()) {
            return response()->json([
                "error" => true,
                "message" => $validator->errors(),
            ], 422);
        }

        $data = $request->except("_token", "_method");
        
        $doApprove = $this->approvalService->doApproval($data, 'branch');

        if(!$doApprove['error']) {
            $this->emailApproveOrCancel($request, $data['action']);
        }

        return response()->json($doApprove, 200);
    }

    private function emailApproveOrCancel($request, $action)
    {
        $req = $request->all();
        $dms_no = $request->dms_no;
        $email_to = Auth::user()->email;
        $wemail = Auth::user()->wemail ? explode(";", Auth::user()->wemail) : null;
        $wccemail = Auth::user()->wccmail ? explode(";", Auth::user()->wccmail) : null;

        $emails = array($email_to);

        if(!is_null($wemail))
        {
            $emails = array_merge($emails, $wemail);
        }

        if(!is_null($wccemail))
        {
            $emails = array_merge($emails, $wccemail);
        }

        $send = Mail::to($emails)->send(new EmailNotificationApproval($dms_no, $action));

        return true;
    }

}
