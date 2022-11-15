<?php

namespace App\Http\Controllers;

use App\Mail\EmailNotificationApproval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Mail;
use App\Services\DatatableOverviewService;
use App\Services\OverviewService;
use App\Entities\AuthEntity;
use App\Services\TodoService;
use App\Services\ApprovalService;
use App\Services\OverviewPdfService;

class HistoryController extends Controller
{
    private $service;
    private $datatableService;
    private $todoService;
    private $approvalService;

    public function __construct(OverviewService $service, DatatableOverviewService $datatableService,
        TodoService $todoService, ApprovalService $approvalService)
    {
        $this->middleware('non.active');
        $this->service = $service;
        $this->datatableService = $datatableService;
        $this->todoService = $todoService;
        $this->approvalService = $approvalService;
    }

    public function getHistory() {
        return view('__proses.history');
    }

    public function getAllData(Request $request, DataTables $dataTables)
    {
        $authEntity = new AuthEntity();

        $state = ['ApprovedByPrincipal', 'ApprovedByKpst', 'ApproveByPrincipal'];
        $view = 'dms_list_aprkpsthist_pgview';
        $linkPdf = 'historypdf';
        $linkTodo = 'historytodo';

        $data = $this->service->getAllDataOverview($state, $view);

        return $this->datatableService->datatableOverviewHistory($dataTables, $data, $linkPdf, $linkTodo);
    }

    public function getHistoryToDo($id)
    {
        $idd = base64_decode($id);
        $dmsNo = $idd;

        $data = $this->todoService->todoHistory($dmsNo);

        return view('__proses.history_todo', $data);
    }

    public function getHistorypdf(string $dms_no, string $state)
    {

        $DmsNo = base64_decode($dms_no);
        $view = 'dms_list_aprkpsthist_pgview';

        $pdf = new OverviewPdfService($DmsNo, $state, $view);

        $pdf->handle();
    }

    /**
     * Close DMS CASE
     * @param Request $request
     */
    public function CloseDmsCase(Request $request)
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

        $doApprove = $this->approvalService->doApproval($data, 'close');

        if(!$doApprove['error'])
        {
            $this->sentClosedEmailApproval($request, 'closed');
        }

        // $closeDms = GeneralHelper::closeDms($request->dms_no, $request->principal);
        // if(!$closeDms['error']){
        //     $this->sentClosedEmailApproval($request, 'closed');
        // }
        return response()->json($doApprove, 200);
    }

    private function sentClosedEmailApproval($request, $action)
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
