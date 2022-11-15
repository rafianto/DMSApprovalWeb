<?php

namespace App\Http\Controllers;

use App\Http\Helpers\GeneralHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('non.active');
    }

    public function getAdmin(Request $request) {
        // if ( \Auth::user()->isadmin == 'Y' )
        $isadmin = trim(auth()->user()->isadmin) ;
        if ($isadmin=='Y') {
            return view('administrator.index');
        } else {
            return redirect()->route('home');
        }
    }

    public function getAllData(Request $request, DataTables $dataTables)
    {
        $data = DB::table('dms_users')
            ->select('id', 'name', 'email', 'principal', 'site', 'isactive',
                'isadmin', 'isbranc', 'isprinc', 'ishisto', 'isrept', 'grp_prod');

        if(isset($request->isactive)){
            if($request->isactive == "Y"){
                $data->where('isactive', 'Y');
            } else {
                $data->where('isactive', "N");
            }
        }

        return $dataTables->query($data)
        ->editColumn('principal', function($data){
            $arrayPrincipal = $data->principal ? explode(",", $data->principal) : [];
            $principals = DB::table("ifsapp.supplier_info")
            ->selectRaw("CONCAT(CONCAT(supplier_id, '-'), name) AS principal")
            ->whereIn('supplier_id', $arrayPrincipal)->get();
            $temp = [];
            $i = 0;
            foreach($principals as $row)
            {
                $temp[$i] = $row->principal;
                $i++;
            }
            return implode("<br />", $temp);
        })
        ->editColumn('site', function($data){
            $arraySite = $data->site ? explode(",", $data->site) : [];
            $sites = DB::table("ifsapp.site")
                ->selectRaw("CONCAT(CONCAT(contract, '-'), description) AS site")
                ->whereIn('contract', $arraySite)->get();
            $temp = [];
            $i = 0;
            foreach($sites as $row)
            {
                $temp[$i] = $row->site;
                $i++;
            }
            return implode("<br />", $temp);
        })
        ->editColumn('isactive', function($data){
            $icon = '';
            if($data->isactive == 'Y')
            {
                $icon = '<i class="fas fa-check text-success"></i>';
            } else {
                $icon = '<i class="fas fa-times text-danger"></i>';
            }
            return $icon;
        })
        ->editColumn('isadmin', function($data){
            $icon = '';
            if($data->isadmin == 'Y')
            {
                $icon = '<i class="fas fa-check text-success"></i>';
            } else {
                $icon = '<i class="fas fa-times text-danger"></i>';
            }
            return $icon;
        })
        ->editColumn('isbranc', function($data){
            $icon = '';
            if($data->isbranc == 'Y')
            {
                $icon = '<i class="fas fa-check text-success"></i>';
            } else {
                $icon = '<i class="fas fa-times text-danger"></i>';
            }
            return $icon;
        })
        ->editColumn('isprinc', function($data){
            $icon = '';
            if($data->isprinc == 'Y')
            {
                $icon = '<i class="fas fa-check text-success"></i>';
            } else {
                $icon = '<i class="fas fa-times text-danger"></i>';
            }
            return $icon;
        })
        ->editColumn('ishisto', function($data){
            $icon = '';
            if($data->ishisto == 'Y')
            {
                $icon = '<i class="fas fa-check text-success"></i>';
            } else {
                $icon = '<i class="fas fa-times text-danger"></i>';
            }
            return $icon;
        })
        ->editColumn('isrept', function($data){
            $icon = '';
            if($data->isrept == 'Y')
            {
                $icon = '<i class="fas fa-check text-success"></i>';
            } else {
                $icon = '<i class="fas fa-times text-danger"></i>';
            }
            return $icon;
        })
        ->addColumn('action', function($data) {
            $btn = "<a role='button' href='". route('admintodo', ['id' => $data->email]) ."'
                class='btn btn-block btn-success btn-xs'
            >
                Proccess
            </a>";
            $btn .= "<a role='button' class='btn btn-secondary btn-block btn-xs text-white btn-reset-password'
                data-id='$data->id' data-email='$data->email' onClick='resetPassword(". $data->id .")'
                >Reset Password</a>";
            $btn .= "<a role='button' class='btn btn-danger btn-block btn-xs text-white btn-reset-password'
                data-id='$data->id' data-status='$data->isactive' onClick='deleteUser(". $data->id .", `$data->isactive`)'
                >Delete</a>";
            return $btn;
        })->rawColumns([
            'action','isadmin', 'isbranc', 'isprinc', 'ishisto', 'isrept', 'principal', 'site', 'isactive'
        ])
        ->make(true);
    }

    public function getChangePassword() {
        return view('__proses.changepassword');
    }

    public function postChangePassword(Request $request) {
        $isemail =  trim(auth()->user()->email) ;

        $validated = $request->validate([
            "password" => "min:8|required|required_with:password_confirmation|same:password_confirmation",
            "password_confirmation" => "min:8|required",
            "terms" => "required",
        ]);

        if ( trim($request->password) <> trim($request->password_confirmation)) {
            return redirect()->back();
        } else {
            DB::table('mbs.dms_users')
            ->where('email', $isemail)
            ->update(['password' => bcrypt($request->password)]);
            //relogin//
            Auth::logout();
            return redirect()->route('login')->with('messages','');
        }
    }

    public function getAdmintodo($id)
    {
        $req = request();
        $iduser = str_replace('.','/',$id);
        $this->data['idd'] = $id;
        $this->data['isdata'] = DB::table("MBS.dms_users")->where("email",$this->data['idd'])->first();

        // generate id
        if(is_null($this->data['isdata']->id))
        {
            $date = date("Yms");
            $numberGenerate = rand(0, 999);
            $idGen = $date . $numberGenerate;
        }

        $id = $this->data['isdata']->id ? $this->data['isdata']->id : $idGen;
        $this->data['isdata']->id = $id;
        $this->data['sites'] = DB::table('IFSAPP.SITE')->select('contract', 'description')->get();
        $this->data['principals'] = DB::table("IFSAPP.SUPPLIER_INFO")->select('supplier_id', 'name')->get();

        $this->data['user_sites'] = $this->data['isdata']->site ?
            explode(",", $this->data['isdata']->site) : [];
        $this->data['user_principals'] = $this->data['isdata']->principal ?
            explode(",", $this->data['isdata']->principal) : [];
        $this->data['user_group_parts'] = $this->data['isdata']->grp_prod ?
            explode(",", $this->data['isdata']->grp_prod) : [];

        $this->data['divisions'] = GeneralHelper::getDvision();

        // get product by user sites and user principal
        // return array
        $this->data['group_parts'] = $data = DB::table("bn_product")
        ->select("catalog_group", "group_name")->distinct()
        ->whereIn('supplier_id', $this->data['user_principals'])->get();

        return view('administrator.edit', $this->data );
    }

    public function updateAdmintodo(Request $request) {

        $site = isset($request->site) ? implode(",", $request->site) : null ;
        $principal = isset($request->principal) ? implode(",", $request->principal) : null;
        $grp_prod = isset($request->product) ? implode(",", $request->product) : null;

        $data = [
            "id" => $request->id,
            "name" => $request->name,
            "email" => $request->email,
            "site" => $site,
            "principal" => $principal,
            "grp_prod" => $grp_prod,
            "isadmin" => $request->overview_admin,
            "isbranc" => $request->overview_branch,
            "isprinc" => $request->overview_sent,
            "ishisto" => $request->overview_history,
            "isrept" => $request->overview_report,
            // "ischart" => $request->ischart,
            "isactive" => $request->isactive,
            "divisi" => $request->division,
            "pemindisc" => $request->pemindisc,
            "pemaxdisc" =>  $request->pemaxdisc,
            "wemail" => $request->wemail,
            "wccmail" => $request->wccemail,
            "internal_user" => $request->internal_user,
        ];

        $id = $request->id;

        $validated = Validator::make($data,[
            "id" => "required|unique:dms_users,id,$id",
            "name" => "required|max:50",
            "email" => "email|required",
        ]);

        if($validated->fails()){
            return redirect()->back()->withErrors($validated)->withInput();
        }

        // uppdate data
        $save = User::where('email', $data['email'])->update($data);

        // ambil data buat ngecek not active
        $user = User::where('email', $data['email'])->first();


        // jika gagal save
        if(!$save) {
            return redirect('admin')->with(['error' => 'Failed To saved data.<br>Please try again later.']);
        }

        if($request->isactive == "N")
        {
            if($user->email == auth()->user()->email)
            {
                if(($user->isactive == "N") && (auth()->user()->isactive == "N"))
                {
                    Auth::logout();
                    Auth::session()->invalidate();
                    Auth::session()->regenerateToken();
                    return redirect('login');
                }
            }
        }

        return redirect('admin')->with(['message' => 'Data has beend saved.']);

    }

    public function getProductGroupByPrincipal(Request $request)
    {
        $principal = !is_null($request->principal) ?  $request->principal : [];

        $data = GeneralHelper::getGroupProductByPrincipal($principal);
        return response()->json([
            "error" => false,
            "code" => 200,
            "data" => $data,
        ], 200);
    }

    public function resetPassword(Request $request)
    {
        $user = User::findOrFail($request->id);
        $passwordBaru = Hash::make("12345678");

        $user->password = $passwordBaru;
        $save = $user->save();

        if(!$save)
        {
            return response()->json([
                "error" => true,
                "message" => "Something went wrong, please try again later.",
            ],500);
        }

        return response()->json([
            "error" => false,
            "message" => "Password was reset.",
        ],200);

    }

    public function deleteUser(Request $request)
    {
        // find user
        $user = User::find($request->id);

        if(is_null($user))
        {
            return response()->json([
                "error" => true,
                "code" => 404,
                "message" => "User not found"
            ], 404);
        }

        $delete = $user->delete();
        if(!$delete)
        {
            return response()->json([
                "error" => true,
                "code" => 500,
                "message" => "Something went wrong, please try again later"
            ], 500);
        }
        return response()->json([
            "error" => false,
            "code" => 200,
            "message" => "Data has been deleted"
        ], 200);
    }
}
