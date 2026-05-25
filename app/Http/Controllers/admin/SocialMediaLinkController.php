<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\SocialMediaLinkModel;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use DataTables;
class SocialMediaLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return admin_view('social_media/list');
    }
    public function social_media_list(Request $request){
        $data = SocialMediaLinkModel::orderBy('sort', 'asc')->get();
        return DataTables::of($data)->addColumn('status', function($row) {
            $ch_status = ($row->status=='active')?'inactive':'active';
            $ch_label  = ($row->status=='active')?'badge-success':'badge-danger';
            $ch_status = "'".$ch_status."'";
            $status = '<a href="javascript:void(0);" onclick="change_status('.$row->id.','.$ch_status.')"><label  style="cursor:pointer">'.ucfirst($row->status).'</label>';
            return $status;
        })->addColumn('image', function($row) {
            $status = '<img src="'.asset($row->image).'" style="width:75px;height:75px;">';
            return $status;
        })->addColumn('action', function($row) {
            $edit_job = 'social_media/'.$row->id.'/edit';
            $action  = "<div class='d-flex'>";
            $action .= "<a href='".get_admin_url($edit_job)."' class='mt-2 ms-3' ><i class='mdi fa fa-edit' title='".__('message.edit')."'></i></a>";           
            $action .= "</div>";
            return $action;
        })->rawColumns(['status','action','image']) // This will ensure HTML is rendered correctly
        ->make(true); 
    }
    public function change_status(Request $request){
        $social_media_id        = $request->id;
        $social_media           = SocialMediaLinkModel::find($social_media_id);
        $social_media->status   = $request->status;
        $social_media->save();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return admin_view('social_media/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required','min:3','max:150','unique:social_media_link,name'],
            'sort' => ['required','integer'],
            'link' => ['required','url'],
            'image' => ['required','image'],
            'status' => ['required'],
        ]);
        if($validator->fails()){
            $validation_error = validation_errors_message($validator->errors()->messages());
            echo json_encode($validation_error);
            exit;
        }
        else{
            $social_media             =   new SocialMediaLinkModel();
            $social_media->name       =   $request->name;
            $social_media->status     =   $request->status;
            $social_media->sort       =   $request->sort;
            $social_media->link       =   $request->link;
            $image                    =   $request->file('image');
            $image_url                =   upload_img($image,'img/social_media_link/');
            $social_media->image      =   $image_url;
            $social_media->save();
            $validation_success = array('success'=>1,'message'=>__('message.create_social_media_link'),'redirect'=>route('social_media.index'));
            echo json_encode($validation_success);
            exit;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $datas      =   SocialMediaLinkModel::findorFail($id);
        return admin_view('social_media/edit',array('formAction' => route('social_media.update', ['social_media' => $id]),'data'=>$datas));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required','min:3','max:200',Rule::unique('social_media_link','name')->where(function ($query) use ($id) {
                $query->where('id','<>', $id);
                })],
            'sort' => ['required','integer'],
            'link' => ['required','url'],
            'image' => ['nullable','image'],
            'status' => ['required']
        ]);
        if($validator->fails()){
            $validation_error = validation_errors_message($validator->errors()->messages());
            echo json_encode($validation_error);
            exit;
        }
        else{
            $social_media             =   SocialMediaLinkModel::find($id);
            $social_media->name       =   $request->name;
            $social_media->status     =   $request->status;
            $social_media->sort       =   $request->sort;
            $social_media->link       =   $request->link;
            if(!empty($request->file('image'))){
                remove_img($social_media->image);
                $image                =   $request->file('image');
                $imageurl             =   upload_img($image,'img/social_media_link/');
                $social_media->image  =   $imageurl;
            }
            $social_media->save();
            $validation_success = array('success'=>1,'message'=>__('message.upd_social_media_link'),'redirect'=>route('social_media.index'));
            echo json_encode($validation_success);
            exit;
        }
    }
}
