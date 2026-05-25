<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\FooterCategoryModel;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use DataTables;
class FooterCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return admin_view('footer_category/list');
    }
    public function footer_category_list(Request $request){
        $data = FooterCategoryModel::orderBy('name', 'asc')->get();
        return DataTables::of($data)->addColumn('status', function($row) {
            $ch_status = ($row->status=='active')?'inactive':'active';
            $ch_label  = ($row->status=='active')?'badge-success':'badge-danger';
            $ch_status = "'".$ch_status."'";
            $status = '<a href="javascript:void(0);" onclick="change_status('.$row->id.','.$ch_status.')"><label  style="cursor:pointer">'.ucfirst($row->status).'</label>';
            return $status;
        })->addColumn('action', function($row) {
            $edit_footer_category = 'footer_category/'.$row->id.'/edit';
            $action  = "<div class='d-flex'>";
            $action .= "<a href='".get_admin_url($edit_footer_category)."' class='mt-2 ms-3' ><i class='mdi fa fa-edit' title='".__('message.edit')."'></i></a>";           
            $action .= "</div>";
            return $action;
        })->rawColumns(['status','action']) // This will ensure HTML is rendered correctly
        ->make(true); 
    }
    public function change_status(Request $request){
        $category_id        = $request->id;
        $category           = FooterCategoryModel::find($category_id);
        $category->status   = $request->status;
        $category->save();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return admin_view('footer_category/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required','min:3','max:150','unique:footer_category,name'],
            'status' => ['required'],
            'sort' => ['required','integer'],
        ]);
        if($validator->fails()){
            $validation_error = validation_errors_message($validator->errors()->messages());
            echo json_encode($validation_error);
            exit;
        }
        else{
            $footer_category            =   new FooterCategoryModel();
            $footer_category->name      =   $request->name;
            $footer_category->sort      =   $request->sort;
            $footer_category->status    =   $request->status;
            $footer_category->save();
            $validation_success = array('success'=>1,'message'=>__('message.create_footer_category'),'redirect'=>route('footer_category.index'));
            echo json_encode($validation_success);
            exit;
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $datas      = FooterCategoryModel::findorFail($id);
        return admin_view('footer_category/edit',array('formAction' => route('footer_category.update', ['footer_category' => $id]),'data'=>$datas));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
             'name' => ['required','min:3','max:150',Rule::unique('footer_category','name')->where(function ($query) use ($id) {
                $query->where('id','<>', $id);
                })],
            'status' => ['required'],
            'sort' => ['required','integer'],
        ]);
        if($validator->fails()){
            $validation_error = validation_errors_message($validator->errors()->messages());
            echo json_encode($validation_error);
            exit;
        }
        else{
            $footer_category            =   FooterCategoryModel::find($id);
            $footer_category->name      =   $request->name;
            $footer_category->sort      =   $request->sort;
            $footer_category->status    =   $request->status;
            $footer_category->save();
            $validation_success = array('success'=>1,'message'=>__('message.upd_footer_category'),'redirect'=>route('footer_category.index'));
            echo json_encode($validation_success);
            exit;
        }
    }
}
