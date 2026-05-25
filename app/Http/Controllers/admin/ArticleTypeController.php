<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\ArticleTypeModel;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use DataTables;

class ArticleTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return admin_view('article_type/list');
    }
    public function article_type_list(Request $request){
        $data = ArticleTypeModel::orderBy('name', 'asc')->get();
        return DataTables::of($data)->addColumn('status', function($row) {
            $ch_status = ($row->status=='active')?'inactive':'active';
            $ch_label  = ($row->status=='active')?'badge-success':'badge-danger';
            $ch_status = "'".$ch_status."'";
            $status = '<a href="javascript:void(0);" onclick="change_status('.$row->id.','.$ch_status.')"><label  style="cursor:pointer">'.ucfirst($row->status).'</label>';
            return $status;
        })->addColumn('action', function($row) {
            $edit_issue = 'article_type/'.$row->id.'/edit';
            $action  = "<div class='d-flex'>";
            $action .= "<a href='".get_admin_url($edit_issue)."' class='mt-2 ms-3' ><i class='mdi fa fa-edit' title='".__('message.edit')."'></i></a>";           
            $action .= "</div>";
            return $action;
        })->rawColumns(['status','action']) // This will ensure HTML is rendered correctly
        ->make(true); 
    }
    public function change_status(Request $request){
        $type_id                = $request->id;
        $article_type           = ArticleTypeModel::find($type_id);
        $article_type->status   = $request->status;
        $article_type->save();
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return admin_view('article_type/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required','min:3','max:150','unique:article_type,name'],
            'status' => ['required'],
        ]);
        if($validator->fails()){
            $validation_error = validation_errors_message($validator->errors()->messages());
            echo json_encode($validation_error);
            exit;
        }
        else{
            $article_type                 =   new ArticleTypeModel();
            $article_type->name           =   $request->name;
            $article_type->status         =   $request->status;
            $article_type->save();
            $validation_success = array('success'=>1,'message'=>__('message.create_article_type'),'redirect'=>route('article_type.index'));
            echo json_encode($validation_success);
            exit;
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
         $datas      = ArticleTypeModel::findorFail($id);
        return admin_view('article_type/edit',array('formAction' => route('article_type.update', ['article_type' => $id]),'data'=>$datas));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
             'name' => ['required',Rule::unique('article_type','name')->where(function ($query) use ($id) {
                $query->where('id','<>', $id);
                })],
            'status' => ['required'],
        ]);
        if($validator->fails()){
            $validation_error = validation_errors_message($validator->errors()->messages());
            echo json_encode($validation_error);
            exit;
        }
        else{
            $article_type                  =   ArticleTypeModel::find($id);
            $article_type->name            =   $request->name;
            $article_type->status          =   $request->status;
            $article_type->save();
            $validation_success = array('success'=>1,'message'=>__('message.upd_article_type'),'redirect'=>route('article_type.index'));
            echo json_encode($validation_success);
            exit;
        }
    }
}
