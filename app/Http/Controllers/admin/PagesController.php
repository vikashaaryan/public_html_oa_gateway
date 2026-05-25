<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\PagesModel;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use DataTables;
class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return admin_view('page/list');
    }
    public function page_list(Request $request){
        $data = PagesModel::orderBy('name', 'asc')->get();
        return DataTables::of($data)->addColumn('status', function($row) {
            $ch_status = ($row->status=='active')?'inactive':'active';
            $ch_label  = ($row->status=='active')?'badge-success':'badge-danger';
            $ch_status = "'".$ch_status."'";
            $status = '<a href="javascript:void(0);" onclick="change_status('.$row->id.','.$ch_status.')"><label  style="cursor:pointer">'.ucfirst($row->status).'</label>';
            return $status;
        })->addColumn('slug_url', function($row) {
            $status = '<a href="'.url('/').'#'.$row->slug_url.'" target="_blank"><label  style="cursor:pointer">'.url('/').'#'.$row->slug_url.'</label>';
            return $status;
        })->addColumn('action', function($row) {
            $edit_page = 'page/'.$row->id.'/edit';
            $action  = "<div class='d-flex'>";
            $action .= "<a href='".get_admin_url($edit_page)."' class='mt-2 ms-3' ><i class='mdi fa fa-edit' title='".__('message.edit')."'></i></a>";           
            $action .= "</div>";
            return $action;
        })->rawColumns(['status','slug_url','action']) // This will ensure HTML is rendered correctly
        ->make(true); 
    }
    public function change_status(Request $request){
        $page_id        = $request->id;
        $page           = PagesModel::find($page_id);
        $page->status   = $request->status;
        $page->save();
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return admin_view('page/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required','min:3','max:150','unique:pages,name'],
            'slug_title' => ['required','min:3','max:150','unique:pages,slug_title'],
            'description' => ['required'],
            'status' => ['required'],
        ]);
        if($validator->fails()){
            $validation_error = validation_errors_message($validator->errors()->messages());
            echo json_encode($validation_error);
            exit;
        }
        else{
            $description            =   $request->description;
            $description            =   editor_img($description,'pages');
            $slug_url               =   Str::slug($request->slug_title);
            $slug_url               =   str_replace('-', '_', $slug_url); 
            $page                   =   new PagesModel();
            $page->name             =   $request->name;
            $page->slug_title       =   $request->slug_title;
            $page->slug_url         =   $slug_url;
            $page->description      =   $description;
            $page->status           =   $request->status;
            $page->save();
            $validation_success = array('success'=>1,'message'=>__('message.create_page'),'redirect'=>route('page.index'));
            echo json_encode($validation_success);
            exit;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $datas      = PagesModel::findorFail($id);
        return admin_view('page/edit',array('formAction' => route('page.update', ['page' => $id]),'data'=>$datas));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
             'name' => ['required','min:3','max:150',Rule::unique('pages','name')->where(function ($query) use ($id) {
                $query->where('id','<>', $id);
                })],
            'slug_title' => ['required','min:3','max:150',Rule::unique('pages','slug_title')->where(function ($query) use ($id) {
                $query->where('id','<>', $id);
                })],
            
            'description' => ['required'],
            'status' => ['required'],
        ]);
        if($validator->fails()){
            $validation_error = validation_errors_message($validator->errors()->messages());
            echo json_encode($validation_error);
            exit;
        }
        else{
            $description            =   $request->description;            $description            =   editor_img($description,'pages');
            $slug_url               =   Str::slug($request->slug_title);
            $slug_url               =   str_replace('-', '_', $slug_url); 
            $page                   =   PagesModel::find($id);
            $page->name             =   $request->name;
            $page->slug_title       =   $request->slug_title;
            $page->slug_url         =   $slug_url;
            $page->description      =   $description;
            $page->status           =   $request->status;
            $page->save();
            $validation_success = array('success'=>1,'message'=>__('message.upd_page'),'redirect'=>route('page.index'));
            echo json_encode($validation_success);
            exit;
        }
    }
}
