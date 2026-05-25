<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\SubmitArticleModel;
use App\Models\SubjectModel;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use DataTables;

class SubmitArticle extends Controller
{
    public function index()
    {
        return admin_view('submit_article/list');
    }
    public function article_list(Request $request){
        $data = SubmitArticleModel::orderBy('id', 'desc')->get();
        return DataTables::of($data)->addColumn('document', function($row) {
            return '<a href="'.asset($row->document).'" target="_blank"><i class="bx bxs-file-pdf"></i></a>';
        })->addColumn('subject', function($row) {
           $subjects = SubjectModel::find($row->subject);
           return $subjects->name;
        })->rawColumns(['document']) // This will ensure HTML is rendered correctly
        ->make(true); 
    }
}
