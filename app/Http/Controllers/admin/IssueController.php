<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\IssueModel;
use App\Models\VolumeModel;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use DataTables;
class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return admin_view('issue/list');
    }
    public function issue_list(Request $request){
        $data = IssueModel::orderBy('name', 'asc')->get();
        return DataTables::of($data)->addColumn('status', function($row) {
            $ch_status = ($row->status=='active')?'inactive':'active';
            $ch_label  = ($row->status=='active')?'badge-success':'badge-danger';
            $ch_status = "'".$ch_status."'";
            $status = '<a href="javascript:void(0);" onclick="change_status('.$row->id.','.$ch_status.')"><label  style="cursor:pointer">'.ucfirst($row->status).'</label>';
            return $status;
        })->addColumn('action', function($row) {
            $edit_issue = 'issue/'.$row->id.'/edit';
            $action  = "<div class='d-flex'>";
            $action .= "<a href='".get_admin_url($edit_issue)."' class='mt-2 ms-3' ><i class='mdi fa fa-edit' title='".__('message.edit')."'></i></a>";           
            $action .= "</div>";
            return $action;
        })->rawColumns(['status','action']) // This will ensure HTML is rendered correctly
        ->make(true); 
    }
    public function change_status(Request $request){
        $issue_id        = $request->id;
        $issue           = IssueModel::find($issue_id);
        $issue->status   = $request->status;
        $issue->save();
    }
    public function get_issue(Request $request){
        $volume     =   $request->issue;
        $issues     =   IssueModel::where('volume', $volume)->where('status','active')->pluck('name', 'id');
        return response()->json($issues);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['volumes'] = VolumeModel::where('status','active')->get();
        return admin_view('issue/create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required','min:3','max:150','unique:issue,name'],
            //'title' => ['required','min:3','max:200'],
            'volume' => ['required'],
            'publish_date' => ['required'],
            //'description' => ['required'],
            'status' => ['required'],
        ]);
        if($validator->fails()){
            $validation_error = validation_errors_message($validator->errors()->messages());
            echo json_encode($validation_error);
            exit;
        }
        else{
            $issue                  =   new IssueModel();
            $issue->name            =   $request->name;
            $issue->volume          =   $request->volume;
            $issue->title           =   $request->title;
            $issue->publish_date    =   ins_date_format($request->publish_date);
            $issue->description     =   $request->description;
            $issue->status          =   $request->status;
            $issue->save();
            $validation_success = array('success'=>1,'message'=>__('message.create_issue'),'redirect'=>route('issue.index'));
            echo json_encode($validation_success);
            exit;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $datas      =   IssueModel::findorFail($id);
        $volumes    =   VolumeModel::where('status','active')->get();
        return admin_view('issue/edit',array('formAction' => route('issue.update', ['issue' => $id]),'data'=>$datas,'volumes'=>$volumes));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required','min:3','max:200',Rule::unique('issue','name')->where(function ($query) use ($id) {
                $query->where('id','<>', $id);
                })],
            //'title' => ['required','min:3','max:200'],
            'volume' => ['required'],
            'publish_date' => ['required'],
            //'description' => ['required'],
            'status' => ['required']
        ]);
        if($validator->fails()){
            $validation_error = validation_errors_message($validator->errors()->messages());
            echo json_encode($validation_error);
            exit;
        }
        else{
            $issue                  =   IssueModel::find($id);
            $issue->name            =   $request->name;
            $issue->volume          =   $request->volume;
            $issue->title           =   $request->title;
            $issue->publish_date   =   ins_date_format($request->publish_date);
            $issue->description     =   $request->description;
            $issue->status          =   $request->status;
            $issue->save();
            $validation_success = array('success'=>1,'message'=>__('message.upd_issue'),'redirect'=>route('issue.index'));
            echo json_encode($validation_success);
            exit;
        }
    }
}
