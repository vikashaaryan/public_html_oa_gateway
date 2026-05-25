<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\JobModel;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use DataTables;
class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return admin_view('job/list');
    }
    public function job_list(Request $request){
        $data = JobModel::orderBy('sort', 'asc')->get();
        return DataTables::of($data)->addColumn('status', function($row) {
            $ch_status = ($row->status=='active')?'inactive':'active';
            $ch_label  = ($row->status=='active')?'badge-success':'badge-danger';
            $ch_status = "'".$ch_status."'";
            $status = '<a href="javascript:void(0);" onclick="change_status('.$row->id.','.$ch_status.')"><label  style="cursor:pointer">'.ucfirst($row->status).'</label>';
            return $status;
        })->addColumn('action', function($row) {
            $edit_job = 'job/'.$row->id.'/edit';
            $action  = "<div class='d-flex'>";
            $action .= "<a href='".get_admin_url($edit_job)."' class='mt-2 ms-3' ><i class='mdi fa fa-edit' title='".__('message.edit')."'></i></a>";           
            $action .= "</div>";
            return $action;
        })->rawColumns(['status','action']) // This will ensure HTML is rendered correctly
        ->make(true); 
    }
    public function change_status(Request $request){
        $job_id        = $request->id;
        $job           = JobModel::find($job_id);
        $job->status   = $request->status;
        $job->save();
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return admin_view('job/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required','min:3','max:150','unique:job,name'],
            'sort' => ['required','integer'],
            'status' => ['required'],
        ]);
        if($validator->fails()){
            $validation_error = validation_errors_message($validator->errors()->messages());
            echo json_encode($validation_error);
            exit;
        }
        else{
            $job             =   new JobModel();
            $job->name       =   $request->name;
            $job->status     =   $request->status;
            $job->sort       =   $request->sort;
            $job->save();
            $validation_success = array('success'=>1,'message'=>__('message.create_job'),'redirect'=>route('job.index'));
            echo json_encode($validation_success);
            exit;
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $datas      =   JobModel::findorFail($id);
        return admin_view('job/edit',array('formAction' => route('job.update', ['job' => $id]),'data'=>$datas));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required','min:3','max:200',Rule::unique('job','name')->where(function ($query) use ($id) {
                $query->where('id','<>', $id);
                })],
            'sort' => ['required','integer'],
            'status' => ['required']
        ]);
        if($validator->fails()){
            $validation_error = validation_errors_message($validator->errors()->messages());
            echo json_encode($validation_error);
            exit;
        }
        else{
            $job            =   JobModel::find($id);
            $job->name      =   $request->name;
            $job->status    =   $request->status;
            $job->sort      =   $request->sort;
            $job->save();
            $validation_success = array('success'=>1,'message'=>__('message.upd_job'),'redirect'=>route('job.index'));
            echo json_encode($validation_success);
            exit;
        }
    }
}
