<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\ArticleModel;
use App\Models\BannerModel;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use DataTables;
class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return admin_view('banner/list');
    }
    public function banner_list(Request $request){
        $data = BannerModel::with('Articles')->get();
        return DataTables::of($data)->addColumn('status', function($row) {
            $ch_status = ($row->status=='active')?'inactive':'active';
            $ch_label  = ($row->status=='active')?'badge-success':'badge-danger';
            $ch_status = "'".$ch_status."'";
            $status = '<a href="javascript:void(0);" onclick="change_status('.$row->id.','.$ch_status.')"><label  style="cursor:pointer">'.ucfirst($row->status).'</label>';
            return $status;
        })->addColumn('action', function($row) {
            $edit_issue = 'banner/'.$row->id.'/edit';
            $action  = "<div class='d-flex'>";
            $action .= "<a href='".get_admin_url($edit_issue)."' class='mt-2 ms-3' ><i class='mdi fa fa-edit' title='".__('message.edit')."'></i></a>";           
            $action .= "</div>";
            return $action;
        })->rawColumns(['article','status','action']) // This will ensure HTML is rendered correctly
        ->make(true); 
    }
    public function change_status(Request $request){
        $banner_id        = $request->id;
        $banner           = BannerModel::find($banner_id);
        $banner->status   = $request->status;
        $banner->save();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['articles'] = ArticleModel::where('status','active')->get();
        return admin_view('banner/create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required'],
            'description' => ['required'],
            'link' => ['required'],
            'button_name' => ['required'],
            'status' => ['required'],
        ]);
        if($validator->fails()){
            $validation_error = validation_errors_message($validator->errors()->messages());
            echo json_encode($validation_error);
            exit;
        }
        else{
            $banner                 =   new BannerModel();
            $banner->title          =   $request->title;
            $banner->description    =   $request->description;
            $banner->link           =   $request->link;
            $banner->button_name    =   $request->button_name;
            $banner->status         =   $request->status;
            $banner->save();
            $validation_success = array('success'=>1,'message'=>__('message.create_banner'),'redirect'=>route('banner.index'));
            echo json_encode($validation_success);
            exit;
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $datas      = BannerModel::findorFail($id);
        $articles   = ArticleModel::where('status','active')->get();
        return admin_view('banner/edit',array('formAction' => route('banner.update', ['banner' => $id]),'data'=>$datas,'articles'=>$articles));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required'],
            'description' => ['required'],
            'link' => ['required'],
            'button_name' => ['required'],
            'status' => ['required'],
        ]);
        if($validator->fails()){
            $validation_error = validation_errors_message($validator->errors()->messages());
            echo json_encode($validation_error);
            exit;
        }
        else{
            $banner                  =   BannerModel::find($id);
            $banner->title          =   $request->title;
            $banner->description    =   $request->description;
            $banner->link           =   $request->link;
            $banner->button_name    =   $request->button_name;
            $banner->status          =   $request->status;
            $banner->save();
            $validation_success = array('success'=>1,'message'=>__('message.upd_banner'),'redirect'=>route('banner.index'));
            echo json_encode($validation_success);
            exit;
        }
    }
}
