<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\FaqModel;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use DataTables;
class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return admin_view('faq/list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function faq_list()
    {
        $data = FaqModel::orderBy('sort', 'asc')->get();
        return DataTables::of($data)->addColumn('status', function($row) {
            $ch_status = ($row->status=='active')?'inactive':'active';
            $ch_label  = ($row->status=='active')?'badge-success':'badge-danger';
            $ch_status = "'".$ch_status."'";
            $status = '<a href="javascript:void(0);" onclick="change_status('.$row->id.','.$ch_status.')"><label  style="cursor:pointer">'.ucfirst($row->status).'</label>';
            return $status;
        })->addColumn('action', function($row) {
            $edit_page = 'faq/'.$row->id.'/edit';
            $action  = "<div class='d-flex'>";
            $action .= "<a href='".get_admin_url($edit_page)."' class='mt-2 ms-3' ><i class='mdi fa fa-edit' title='".__('message.edit')."'></i></a>";           
            $action .= "</div>";
            return $action;
        })->rawColumns(['status','slug_url','action']) // This will ensure HTML is rendered correctly
        ->make(true); 
    }
    public function change_status(Request $request){
        $faq_id        = $request->id;
        $faq           = FaqModel::find($faq_id);
        $faq->status   = $request->status;
        $faq->save();
    }
    public function create()
    {
        return admin_view('faq/create');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $validator = Validator::make($request->all(), [
            'name' => ['required','min:3','max:150','unique:faq,name'],
            'description' => ['required'],
            'status' => ['required'],
            'sort' => ['required','integer'],
        ]);
        if($validator->fails()){
            $validation_error = validation_errors_message($validator->errors()->messages());
            echo json_encode($validation_error);
            exit;
        }
        else{
            $faq                   =   new FaqModel();
            $faq->name             =   $request->name;
            $faq->description      =   $request->description;
            $faq->status           =   $request->status;
            $faq->sort              =   $request->sort;
            $faq->save();
            $validation_success = array('success'=>1,'message'=>__('message.create_faq'),'redirect'=>route('faq.index'));
            echo json_encode($validation_success);
            exit;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $datas      = FaqModel::findorFail($id);
        return admin_view('faq/edit',array('formAction' => route('faq.update', ['faq' => $id]),'data'=>$datas));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
             'name' => ['required','min:3','max:150',Rule::unique('faq','name')->where(function ($query) use ($id) {
                $query->where('id','<>', $id);
                })],
            'description' => ['required'],
            'status' => ['required'],
            'sort' => ['required','integer'],
        ]);
        if($validator->fails()){
            $validation_error = validation_errors_message($validator->errors()->messages());
            echo json_encode($validation_error);
            exit;
        }
        else{ 
            $faq                   =   FaqModel::find($id);
            $faq->name             =   $request->name;
            $faq->description      =   $request->description;
            $faq->status           =   $request->status;
            $faq->sort             =   $request->sort;
            $faq->save();
            $validation_success = array('success'=>1,'message'=>__('message.upd_faq'),'redirect'=>route('faq.index'));
            echo json_encode($validation_success);
            exit;
        }
    }
}
