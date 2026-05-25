<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\FooterCategoryModel;
use App\Models\FooterLinkModel;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use DataTables;
class FooterLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return admin_view('footer_link/list');
    }
    public function footer_link_list(Request $request){
        $data = FooterLinkModel::with('Category')->orderBy('name', 'asc')->get();
        return DataTables::of($data)->addColumn('status', function($row) {
            $ch_status = ($row->status=='active')?'inactive':'active';
            $ch_label  = ($row->status=='active')?'badge-success':'badge-danger';
            $ch_status = "'".$ch_status."'";
            $status = '<a href="javascript:void(0);" onclick="change_status('.$row->id.','.$ch_status.')"><label  style="cursor:pointer">'.ucfirst($row->status).'</label>';
            return $status;
        })->addColumn('footer_category', function($row) {
            return $row->Category->name;
        })->addColumn('action', function($row) {
            $edit_footer_link = 'footer_link/'.$row->id.'/edit';
            $action  = "<div class='d-flex'>";
            $action .= "<a href='".get_admin_url($edit_footer_link)."' class='mt-2 ms-3' ><i class='mdi fa fa-edit' title='".__('message.edit')."'></i></a>";           
            $action .= "</div>";
            return $action;
        })->rawColumns(['status','action']) // This will ensure HTML is rendered correctly
        ->make(true); 
    }
    public function change_status(Request $request){
        $link_id        = $request->id;
        $link           = FooterLinkModel::find($link_id);
        $link->status   = $request->status;
        $link->save();
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['categories'] =   FooterCategoryModel::where('status','active')->orderBy('sort','asc')->get();
        return admin_view('footer_link/create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required','min:3','max:150','unique:footer_link,name'],
            'footer_category' => ['required'],
            'footer_link' => ['nullable','url'],
            'status' => ['required'],
            'sort' => ['required','integer'],
        ]);
        if($validator->fails()){
            $validation_error = validation_errors_message($validator->errors()->messages());
            echo json_encode($validation_error);
            exit;
        }
        else{
            $link                   =   new FooterLinkModel();
            $link->name             =   $request->name;
            $link->footer_category  =   $request->footer_category;
            if(!empty($request->footer_link)){
                $link->footer_link  =   $request->footer_link;
            }
            $link->sort             =   $request->sort;
            $link->status           =   $request->status;
            $link->save();
            $validation_success = array('success'=>1,'message'=>__('message.create_footer_link'),'redirect'=>route('footer_link.index'));
            echo json_encode($validation_success);
            exit;
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $datas      = FooterLinkModel::findorFail($id);
        $categories = FooterCategoryModel::where('status','active')->orderBy('sort','asc')->get();
        return admin_view('footer_link/edit',array('formAction' => route('footer_link.update', ['footer_link' => $id]),'data'=>$datas,'categories'=>$categories));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
             'name' => ['required','min:3','max:150',Rule::unique('footer_link','name')->where(function ($query) use ($id) {
                $query->where('id','<>', $id);
                })],
            'footer_category' => ['required'],
            'footer_link' => ['nullable','url'],
            'status' => ['required'],
            'sort' => ['required','integer'],
        ]);
        if($validator->fails()){
            $validation_error = validation_errors_message($validator->errors()->messages());
            echo json_encode($validation_error);
            exit;
        }
        else{
            $link                   =   FooterLinkModel::find($id);
            $link->name             =   $request->name;
            $link->footer_category  =   $request->footer_category;
            if(!empty($request->footer_link))
                $link->footer_link  =   $request->footer_link;
            $link->sort             =   $request->sort;
            $link->status           =   $request->status;
            $link->save();
            $validation_success = array('success'=>1,'message'=>__('message.upd_footer_link'),'redirect'=>route('footer_link.index'));
            echo json_encode($validation_success);
            exit;
        }
    }
}
