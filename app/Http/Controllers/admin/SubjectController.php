<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\SubjectModel;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Str;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return admin_view('subject/list');
    }
    public function subject_list(Request $request){
        $data = SubjectModel::orderBy('name', 'asc')->get();
        return DataTables::of($data)->addColumn('status', function($row) {
            $ch_status = ($row->status=='active')?'inactive':'active';
            $ch_label  = ($row->status=='active')?'badge-success':'badge-danger';
            $ch_status = "'".$ch_status."'";
            $status = '<a href="javascript:void(0);" onclick="change_status('.$row->id.','.$ch_status.')"><label  style="cursor:pointer">'.ucfirst($row->status).'</label>';
            return $status;
        })->addColumn('action', function($row) {
            $edit_subject = 'subject/'.$row->id.'/edit';
            $action  = "<div class='d-flex'>";
            $action .= "<a href='".get_admin_url($edit_subject)."' class='mt-2 ms-3' ><i class='mdi fa fa-edit' title='".__('message.edit')."'></i></a>";           
            $action .= "</div>";
            return $action;
        })->rawColumns(['status','action']) // This will ensure HTML is rendered correctly
        ->make(true); 
    }
    public function change_status(Request $request){
        $subject_id        = $request->id;
        $subject           = SubjectModel::find($subject_id);
        $subject->status   = $request->status;
        $subject->save();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return admin_view('subject/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required','min:3','max:150','unique:subject,name'],
            'description' => ['required'],
            'longdescription' => ['required'],
            'meta_title' => ['required','min:3','max:150'],
            'meta_description' => ['required','min:3','max:150'],
            'meta_keyword' => ['required','min:3','max:150'],
            'status' => ['required'],
        ]);
        if($validator->fails()){
            $validation_error = validation_errors_message($validator->errors()->messages());
            echo json_encode($validation_error);
            exit;
        }
        else{
            $subject             =   new SubjectModel();
            $subject->name       =   $request->name;
            $slug_url            =   Str::slug($request->name);
            $subject->slug_url   =   $slug_url;
            $subject->description=   $request->description;
            $subject->long_description=   $request->longdescription;
            $subject->meta_title =   $request->meta_title;
            $subject->meta_description=   $request->meta_description;
            $subject->meta_keywords   =   $request->meta_keyword;
            $subject->status     =   $request->status;
            $subject->save();
            $validation_success = array('success'=>1,'message'=>__('message.create_subject'),'redirect'=>route('subject.index'));
            echo json_encode($validation_success);
            exit;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $datas      =   SubjectModel::findorFail($id);
        return admin_view('subject/edit',array('formAction' => route('subject.update', ['subject' => $id]),'data'=>$datas));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required','min:3','max:200',Rule::unique('subject','name')->where(function ($query) use ($id) {
                $query->where('id','<>', $id);
                })],
            'description' => ['required'],
            'longdescription' => ['required'],
            'meta_title' => ['required','min:3','max:150'],
            'meta_description' => ['required','min:3','max:150'],
            'meta_keyword' => ['required','min:3','max:150'],
            'status' => ['required']
        ]);
        if($validator->fails()){
            $validation_error = validation_errors_message($validator->errors()->messages());
            echo json_encode($validation_error);
            exit;
        }
        else{
            $subject             =   SubjectModel::find($id);
            $subject->name       =   $request->name;
            $slug_url            =   Str::slug($request->name);
            $subject->slug_url   =   $slug_url;
            $subject->description=   $request->description;
            $subject->long_description=   $request->longdescription;
            $subject->status     =   $request->status;
            $subject->meta_title =   $request->meta_title;
            $subject->meta_description=   $request->meta_description;
            $subject->meta_keywords   =   $request->meta_keyword;
            $subject->save();
            $validation_success = array('success'=>1,'message'=>__('message.upd_subject'),'redirect'=>route('subject.index'));
            echo json_encode($validation_success);
            exit;
        }
    }
}
