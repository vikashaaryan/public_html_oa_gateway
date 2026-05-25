<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\TopicModel;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Str;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return admin_view('topic/list');
    }
    public function topic_list(Request $request){
        $data = TopicModel::orderBy('name', 'asc')->get();
        return DataTables::of($data)->addColumn('status', function($row) {
            $ch_status = ($row->status=='active')?'inactive':'active';
            $ch_label  = ($row->status=='active')?'badge-success':'badge-danger';
            $ch_status = "'".$ch_status."'";
            $status = '<a href="javascript:void(0);" onclick="change_status('.$row->id.','.$ch_status.')"><label  style="cursor:pointer">'.ucfirst($row->status).'</label>';
            return $status;
        })->addColumn('action', function($row) {
            $edit_topic = 'topic/'.$row->id.'/edit';
            $action  = "<div class='d-flex'>";
            $action .= "<a href='".get_admin_url($edit_topic)."' class='mt-2 ms-3' ><i class='mdi fa fa-edit' title='".__('message.edit')."'></i></a>";           
            $action .= "</div>";
            return $action;
        })->rawColumns(['status','action']) // This will ensure HTML is rendered correctly
        ->make(true); 
    }
    public function change_status(Request $request){
        $topic_id        = $request->id;
        $topic           = TopicModel::find($topic_id);
        $topic->status   = $request->status;
        $topic->save();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return admin_view('topic/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required','min:3','max:150','unique:topic,name'],
            'description' => ['required'],
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
            $topic             =   new TopicModel();
            $topic->name       =   $request->name;
            $slug_url          =   Str::slug($request->name);
            $topic->slug_url   =   $slug_url;
            $topic->status     =   $request->status;
            $description       =   $request->description;
            $description       =   editor_img($description,'topic');
            $topic->description=   $description;
            $topic->meta_title =   $request->meta_title;
            $topic->meta_description=   $request->meta_description;
            $topic->meta_keywords   =   $request->meta_keyword;
            $topic->save();
            $validation_success = array('success'=>1,'message'=>__('message.create_topic'),'redirect'=>route('topic.index'));
            echo json_encode($validation_success);
            exit;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $datas      =   TopicModel::findorFail($id);
        return admin_view('topic/edit',array('formAction' => route('topic.update', ['topic' => $id]),'data'=>$datas));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required','min:3','max:200',Rule::unique('topic','name')->where(function ($query) use ($id) {
                $query->where('id','<>', $id);
                })],
            'description' => ['required'],
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
            $topic             =   TopicModel::find($id);
            $topic->name       =   $request->name;
            $slug_url          =   Str::slug($request->name);
            $topic->slug_url   =   $slug_url;
            $description       =   $request->description;
            $description       =   editor_img($description,'topic');
            $topic->description=   $description;
            $topic->status     =   $request->status;
            $topic->meta_title =   $request->meta_title;
            $topic->meta_description=   $request->meta_description;
            $topic->meta_keywords   =   $request->meta_keyword;
            $topic->save();
            $validation_success = array('success'=>1,'message'=>__('message.upd_topic'),'redirect'=>route('topic.index'));
            echo json_encode($validation_success);
            exit;
        }
    }
}
