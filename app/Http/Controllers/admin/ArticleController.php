<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\ArticleAuthorModel;
use App\Models\ArticleContentModel;
use App\Models\ArticleModel;
use App\Models\ArticleSubjectModel;
use App\Models\ArticleTopicModel;
use App\Models\ArticleTypeModel;
use App\Models\AuthorModel;
use App\Models\IssueModel;
use App\Models\SubjectModel;
use App\Models\TopicModel;
use App\Models\UniversityModel;
use App\Models\VolumeModel;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return admin_view('article/list');
    }
    public function article_list(Request $request){
        $data = ArticleModel::orderBy('title', 'asc')->get();
        return DataTables::of($data)->addColumn('status', function($row) {
            $ch_status = ($row->status=='active')?'inactive':'active';
            $ch_label  = ($row->status=='active')?'badge-success':'badge-danger';
            $ch_status = "'".$ch_status."'";
            $status = '<a href="javascript:void(0);" onclick="change_status('.$row->id.','.$ch_status.')"><label  style="cursor:pointer">'.ucfirst($row->status).'</label>';
            return $status;
        })->addColumn('publish_date', function($row) {
            return site_date_format($row->publish_date);
        })->addColumn('action', function($row) {
            $edit_issue = 'article/'.$row->id.'/edit';
            $action  = "<div class='d-flex'>";
            $action .= "<a href='".get_admin_url($edit_issue)."' class='mt-2 ms-3' ><i class='mdi fa fa-edit' title='".__('message.edit')."'></i></a>";           
            $action .= "</div>";
            return $action;
        })->rawColumns(['status','action']) // This will ensure HTML is rendered correctly
        ->make(true); 
    }
    public function change_status(Request $request){
        $article_id        = $request->id;
        $article           = ArticleModel::find($article_id);
        $article->status   = $request->status;
        $article->save();

        $issue             = IssueModel::find($article->issue);
        $article_subjects  = ArticleSubjectModel::where('article',$article_id)->get();
        if($request->status=='active'){
            $count = 1;
        }
        else{
            $count = -1;
        }
        $issue->article_count       =   $issue->article_count + $count;
        $issue->save();
        if($article_subjects->isNotEmpty()){
            foreach($article_subjects as $article_subject_1){
                $subject                    =   SubjectModel::find($article_subject_1->subject);
                $subject->article_count     =   $subject->article_count + $count;
                $subject->save();
            }
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['article_types']  =   ArticleTypeModel::where('status','active')->get();
        $data['issues']         =   IssueModel::where('status','active')->get();
        $data['subjects']       =   SubjectModel::where('status','active')->get();
        $data['topics']         =   TopicModel::where('status','active')->get();
        $data['universities']   =   UniversityModel::where('status','active')->get();
        $data['volumes']        =   VolumeModel::where('status','active')->get();
        return admin_view('article/create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required','min:3','max:150'],
            'article_id' => ['required'],
            'article_type' => ['required'],
            'publish_date' => ['required'],
            'received_date' => ['required'],
            'accepted_date' => ['required'],
            'pdf' => ['nullable','mimes:pdf'],
            'subject' => ['required'],
            'university' => ['required'],
            'topic' => ['required'],
            'doi' => ['nullable','min:3','max:150'],
            'doi_link' => ['nullable','url'],
            'issue' => ['required'],
            'volume' => ['required'],
            'meta_title' => ['required','min:3','max:150'],
            'meta_description' => ['required','min:3','max:150'],
            'meta_keyword' => ['required','min:3','max:150'],
            'no_content' => ['required','integer','min:1'],
            'content_title.*'=>['required'],
            'content_sort.*'=>['required'],
            'content_description.*'=>['required'],
            'no_author' => ['required','integer','min:1'],
            'author_name.*'=>['required','min:3','max:150'],
            'about_author.*'=>['required'],
            'author_sort.*'=>['required','integer'],
            'copy_right' => ['required'],
            'status' => ['required'],
        ]);
        if($validator->fails()){
            $validation_error = validation_errors_message($validator->errors()->messages());
            echo json_encode($validation_error);
            exit;
        }
        else{
            $current_date            =   date('Y-m-d');
            $article                 =   new ArticleModel();
            if(!empty($request->file('pdf'))){
                $pdf                 =   $request->file('pdf');
                $pdfUrl              =   upload_img($pdf,'img/pdf/');
                $article->pdf        =   $pdfUrl;
            }
            $slug_url                =   Str::slug($request->title.''. $request->article_id);
            $slug_url                =   str_replace('-', '_', $slug_url); 
            $article->title          =   $request->title;
            $article->slug_url       =   $slug_url;
            $article->article_type   =   $request->article_type;
            $article->article_id     =   $request->article_id;
            $article->submit_date    =   ins_date_format($request->received_date);
            $article->approve_date   =   ins_date_format($request->accepted_date);
            $article->publish_date   =   ins_date_format($request->publish_date);
            $article->doi            =   (!empty($request->doi))?$request->doi:'';
            $article->doi_link       =   (!empty($request->doi_link))?$request->doi_link:'';
            $article->no_contents    =   $request->no_content;
            $article->no_author      =   $request->no_author;
            $article->university     =   $request->university;
            $article->seo_title      =   $request->meta_title;
            $article->seo_description=   $request->meta_description;
            $article->seo_keywords   =   $request->meta_keyword;
            $article->volume         =   $request->volume;
            $article->issue          =   $request->issue ;
            $article->copy_rights    =   $request->copy_right;
            $article->status         =   $request->status;
            $article->save();
            for($i=0;$i<$request->no_content;$i++){
                $description                    =   $request->content_description[$i];
                $description                    =   editor_img($description,'articles');
                $article_content                =   new ArticleContentModel();
                $article_content->article       =   $article->id;
                $article_content->title         =   $request->content_title[$i];
                $article_content->content_sort  =   $request->content_sort[$i];
                $article_content->description   =   $description;
                $article_content->save();
            }
            for($i=0;$i<$request->no_author;$i++){
                $article_author                =   new ArticleAuthorModel();
                $article_author->article_id    =   $article->id;
                $article_author->author_name   =   $request->author_name[$i];
                $article_author->about_author  =   $request->about_author[$i];
                $article_author->author_sort   =   $request->author_sort[$i];
                $article_author->save();
            }
            if(!empty($request->subject)){
                $all_subjects = $request->subject;
                foreach($all_subjects as $all_subject_1){
                    $article_subject            =   new ArticleSubjectModel();
                    $article_subject->article   =   $article->id;
                    $article_subject->subject   =   $all_subject_1;
                    $article_subject->save();
                    if($request->status=='active'){
                        $subject                    =   SubjectModel::find($all_subject_1);
                        $subject->article_count     =   $subject->article_count + 1;
                        $subject->save();
                    }
                }
            }
            if(!empty($request->topic)){
                $all_topics = $request->topic;
                foreach($all_topics as $all_topic_1){
                    $article_topic            =   new ArticleTopicModel();
                    $article_topic->article   =   $article->id;
                    $article_topic->topic     =   $all_topic_1;
                    $article_topic->save();
                }
            }
            
            if($request->status=='active'){
                $issue                      =   IssueModel::find($request->issue);
                $issue->article_count       =   $issue->article_count + 1;
                $issue->save();
            }
            $validation_success = array('success'=>1,'message'=>__('message.create_article'),'redirect'=>route('article.index'));
            echo json_encode($validation_success);
            exit;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $datas          =   ArticleModel::findorFail($id);
        $article_subjects = ArticleSubjectModel::where('article',$id)->get();
        $article_topics = ArticleTopicModel::where('article',$id)->get();
        $issues         =   IssueModel::where('status','active')->where('volume',$datas->volume)->get();
        $subjects       =   SubjectModel::where('status','active')->get();
        $topics         =   TopicModel::where('status','active')->get();
        $universities   =   UniversityModel::where('status','active')->get();
        $volumes        =   VolumeModel::where('status','active')->get();
        $article_types  =   ArticleTypeModel::where('status','active')->get();

        if($article_topics->isNotEmpty()){
            $article_topics = $article_topics->toArray();
            $article_topics = array_column($article_topics,'topic');
        }
        else{
            $article_topics = [];
        }
        if($article_subjects->isNotEmpty()){
            $article_subjects = $article_subjects->toArray();
            $article_subjects = array_column($article_subjects,'subject');

        }
         else{
            $article_subjects = [];
        }
        $contents       =   ArticleContentModel::where('article',$id)->get();
        $authors        =   ArticleAuthorModel::where('article_id',$id)->get();
        return admin_view('article/edit',array('formAction' => route('article.update', ['article' => $id]),'data'=>$datas,'issues'=>$issues,'subjects'=>$subjects,'topics'=>$topics,'universities'=>$universities,'volumes'=>$volumes,'contents'=>$contents,'article_subjects'=>$article_subjects,'article_topics'=>$article_topics,'article_types'=>$article_types,'authors'=>$authors));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required','min:3','max:150'],
            'article_id' => ['required'],
            'article_type' => ['required'],
            'publish_date' => ['required'],
            'received_date' => ['required'],
            'accepted_date' => ['required'],
            'pdf' => ['nullable','mimes:pdf'],
            'subject' => ['required'],
            'university' => ['required'],
            'topic' => ['required'],
            'doi' => ['nullable','min:3','max:150'],
            'doi_link' => ['nullable','url'],
            'issue' => ['required'],
            'volume' => ['required'],
            'meta_title' => ['required','min:3','max:150'],
            'meta_description' => ['required','min:3','max:150'],
            'meta_keyword' => ['required','min:3','max:150'],
            'no_content' => ['required','integer','min:1'],
            'content_title.*'=>['required'],
            'content_description.*'=>['required'],
            'no_author' => ['required','integer','min:1'],
            'author_name.*'=>['required','min:3','max:150'],
            'about_author.*'=>['required'],
            'author_sort.*'=>['required','integer'],
            'copy_right' => ['required'],
            'status' => ['required'],
        ]);
        if($validator->fails()){
            $validation_error = validation_errors_message($validator->errors()->messages());
            echo json_encode($validation_error);
            exit;
        }
        else{
            $current_date            =   date('Y-m-d');
            $article                 =   ArticleModel::findorFail($id);
            $cur_status              =   $article->status;
            $cur_issue               =   $article->issue;
            if(!empty($request->file('pdf'))){
                $pdf                 =   $request->file('pdf');
                $pdfUrl              =   upload_img($pdf,'img/pdf/');
                $article->pdf        =   $pdfUrl;
            }
            $slug_url                =   Str::slug($request->title.''. $request->article_id);
            $article->slug_url       =   $slug_url;
            $article->title          =   $request->title;
            $article->article_id     =   $request->article_id;
            $article->article_type   =   $request->article_type;
            $article->submit_date    =   ins_date_format($request->received_date);
            $article->approve_date   =   ins_date_format($request->accepted_date);
            $article->publish_date   =   ins_date_format($request->publish_date);
            $article->doi            =   (!empty($request->doi))?$request->doi:'';
            $article->doi_link       =   (!empty($request->doi_link))?$request->doi_link:'';
            $article->no_contents    =   $request->no_content;
            $article->no_author      =   $request->no_author;
            //$article->subject        =   $request->subject;
            $article->university     =   $request->university;
            //$article->topic          =   $request->topic;
            $article->seo_title      =   $request->meta_title;
            $article->seo_description=   $request->meta_description;
            $article->seo_keywords   =   $request->meta_keyword;
            $article->volume         =   $request->volume;
            $article->issue          =   $request->issue ;
            $article->copy_rights    =   $request->copy_right;
            $article->status         =   $request->status;
            $article->save();
           ArticleContentModel::where('article', $id)->delete();
            for($i=0;$i<$request->no_content;$i++){
                $description                    =   $request->content_description[$i];
                $description                    =   editor_img($description,'articles');
                $article_content                =   new ArticleContentModel();
                $article_content->article       =   $article->id;
                $article_content->title         =   $request->content_title[$i];
                $article_content->content_sort  =   $request->content_sort[$i];
                $article_content->description   =   $description;
                $article_content->save();
            }
           ArticleAuthorModel::where('article_id', $id)->delete();
            for($i=0;$i<$request->no_author;$i++){
                $article_author                =   new ArticleAuthorModel();
                $article_author->article_id    =   $article->id;
                $article_author->author_name   =   $request->author_name[$i];
                $article_author->about_author  =   $request->about_author[$i];
                $article_author->author_sort   =   $request->author_sort[$i];
                $article_author->save();
            }
            if(!empty($request->subject)){
                $all_subjects = $request->subject;
                $cur_subjects = ArticleSubjectModel::where('article',$id)->get();
                if($cur_subjects->isNotEmpty() && $cur_status  == 'active'){
                    foreach($cur_subjects as $cur_subject_1){
                        if(in_array($cur_subject_1->subject,$all_subjects)){
                            $subject_old                    =   SubjectModel::find($cur_subject_1->subject);
                            $subject_old->article_count     =   $subject_old->article_count - 1;
                            $subject_old->save();
                        }
                    }
                }
                ArticleSubjectModel::where('article', $id)->delete();
                foreach($all_subjects as $all_subject_1){
                    $article_subject            =   new ArticleSubjectModel();
                    $article_subject->article   =   $id;
                    $article_subject->subject   =   $all_subject_1;
                    $article_subject->save();
                    if($request->status == 'active'){
                        $subject                    =   SubjectModel::find($all_subject_1);
                        $subject->article_count     =   $subject->article_count + 1;
                        $subject->save();
                    }
                }
            }
            if(!empty($request->topic)){
                ArticleTopicModel::where('article', $id)->delete();
                $all_topics = $request->topic;
                foreach($all_topics as $all_topic_1){
                    $article_topic            =   new ArticleTopicModel();
                    $article_topic->article   =   $id;
                    $article_topic->topic     =   $all_topic_1;
                    $article_topic->save();
                }
            }
            
            if($cur_status == 'active'){
                $issue_old                  =   IssueModel::find($cur_issue);
                $issue_old->article_count   =   $issue_old->article_count - 1;
                $issue_old->save();
            }
            if($request->status == 'active'){
                $issue                      =   IssueModel::find($request->issue);
                $issue->article_count       =   $issue->article_count + 1;
                $issue->save();
            }
            $validation_success = array('success'=>1,'message'=>__('message.upd_article'),'redirect'=>route('article.index'));
            echo json_encode($validation_success);
            exit;
        }
    }
}
