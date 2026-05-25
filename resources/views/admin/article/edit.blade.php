@extends('admin.layouts.app')
@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="card ">
            <div class="card-body card-breadcrumb">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">{{__('message.article')}}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
      <div class="card" >
        <div class="card-header">
            <h4>{{__('message.edit_article')}}</h4>
        </div>
        <div class="card-body">
          <form id="quickForm" method="POST" action="{{ $formAction }}" autocomplete="off">
              @csrf
              @method('PUT')
              <div class="row">
                <h3>{{__('message.general')}}</h3>
                <div class="col-lg-6">
                  <div class="mb-3">
                      <label class="form-label">{{__('message.title')}}<span class="error">*</span></label>
                      <input type="text" id="title" name="title" placeholder="{{__('message.enter_title')}}" class="form-control"  value="{{$data->title}}" autofocus>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                      <label class="form-label">{{__('message.article_id')}}<span class="error">*</span></label>
                      <input type="text" id="article_id" name="article_id" placeholder="{{__('message.enter_article_id')}}" class="form-control" value="{{$data->article_id}}" autofocus>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                      <label class="form-label">{{__('message.article_type')}}<span class="error">*</span></label>
                      <select name="article_type" id="article_type" class="form-control" autofocus >
                        <option value="">{{__('message.select_article_type')}}</option>
                        @if($article_types->isNotEmpty())
                          @foreach ($article_types as $article_type_1)
                            <option value="{{$article_type_1->id}}" @if($data->article_type == $article_type_1->id) selected @endif>{{$article_type_1->name}}</option>
                          @endforeach
                        @endif
                      </select>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                      <label class="form-label">{{__('message.received_date')}}<span class="error">*</span></label>
                      <input type="text" id="received_date" name="received_date" class="form-control datepicker" readonly value="{{site_date_format($data->submit_date)}}">
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                      <label class="form-label">{{__('message.accepted_date')}}<span class="error">*</span></label>
                      <input type="text" id="accepted_date" name="accepted_date" class="form-control datepicker" readonly value="{{site_date_format($data->approve_date)}}">
                  </div>
                </div>
                 <div class="col-lg-6">
                  <div class="mb-3">
                      <label class="form-label">{{__('message.publish_date')}}<span class="error">*</span></label>
                      <input type="text" id="publish_date" name="publish_date" class="form-control datepicker" readonly value="{{site_date_format($data->publish_date)}}">
                  </div>
                </div>
                 <div class="col-lg-6">
                  <div class="mb-3">
                      <label class="form-label">{{__('message.pdf')}}</label>
                      <input type="file" id="pdf" name="pdf" class="form-control" >
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                      <label for="name" class="form-label">{{__('message.subject')}}<span class="error">*</span></label>
                      <select name="subject[]" id="subject" class="form-control" autofocus multiple>
                        <option value="">{{__('message.select_subject')}}</option>
                        @if($subjects->isNotEmpty())
                          @foreach ($subjects as $subject_1)
                            <option value="{{$subject_1->id}}" @if(in_array($subject_1->id,$article_subjects)) selected @endif>{{$subject_1->name}}</option>
                          @endforeach
                        @endif
                      </select>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                      <label for="name" class="form-label">{{__('message.university')}}<span class="error">*</span></label>
                      <select name="university" id="university" class="form-control" autofocus>
                        <option value="">{{__('message.select_university')}}</option>
                        @if($universities->isNotEmpty())
                          @foreach ($universities as $university_1)
                            <option value="{{$university_1->id}}" @if($data->university== $university_1->id) selected @endif>{{$university_1->name}}</option>
                          @endforeach
                        @endif
                      </select>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                      <label for="name" class="form-label">{{__('message.topic')}}<span class="error">*</span></label>
                      <select name="topic[]" id="topic" class="form-control" autofocus multiple>
                        <option value="">{{__('message.select_topic')}}</option>
                        @if($topics->isNotEmpty())
                          @foreach ($topics as $topic1)
                            <option value="{{$topic1->id}}" @if(in_array($topic1->id,$article_topics)) selected @endif>{{$topic1->name}}</option>
                          @endforeach
                        @endif
                      </select>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                      <label for="name" class="form-label">{{__('message.doi')}}</label>
                      <textarea type="text" id="doi" name="doi" placeholder="{{__('message.enter_doi')}}" class="form-control" autofocus>{{$data->doi}}</textarea>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                      <label for="name" class="form-label">{{__('message.doi_link')}}</label>
                      <input type="text" id="doi_link" name="doi_link" placeholder="{{__('message.enter_doi_link')}}" class="form-control" autofocus>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                      <label for="name" class="form-label">{{__('message.volume')}}<span class="error">*</span></label>
                      <select name="volume" id="volume" class="form-control" autofocus>
                        <option value="">{{__('message.select_volume')}}</option>
                         @if($volumes->isNotEmpty())
                          @foreach ($volumes as $volume_1)
                            <option value="{{$volume_1->id}}" @if($data->volume== $volume_1->id) selected @endif>{{$volume_1->name}}</option>
                          @endforeach
                        @endif
                      </select>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                      <label for="name" class="form-label">{{__('message.issue')}}<span class="error">*</span></label>
                      <select name="issue" id="issue" class="form-control" autofocus>
                        <option value="">{{__('message.select_issue')}}</option>
                        @if($issues->isNotEmpty())
                          @foreach ($issues as $issue_1)
                            <option value="{{$issue_1->id}}" @if($data->issue== $issue_1->id) selected @endif>{{$issue_1->name}}</option>
                          @endforeach
                        @endif
                      </select>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                      <label for="name" class="form-label">{{__('message.copy_right')}}<span class="error">*</span></label>
                       <textarea id="copy_right" name="copy_right" placeholder="{{__('message.enter_copy_right')}}" class="form-control" autofocus>{{$data->copy_rights}}</textarea>
                  </div>
                </div>
                <h3>{{__('message.author')}}</h3>
                <div class="col-lg-6">
                  <div class="mb-3">
                      <label for="name" class="form-label">{{__('message.no_author')}}<span class="error">*</span></label>
                      <input type="text" class="form-control" name="no_author" id="no_author" value="{{$data->no_author}}" placeholder="{{__('message.enter_no_author')}}">
                  </div>
                </div>
                <div id="dynamic_author">
                    @if($authors->isNotEmpty())
                      @php
                        $i =1;
                      @endphp
                        @foreach ($authors as $author_1)
                          <div class="row">
                            <div class="col-lg-6">
                              <div class="mb-3">
                                  <label class="form-label">{{__('message.author_name')}} {{$i}}</label>
                                  <input type="text" name="author_name[]" class="form-control" placeholder="{{__('message.enter_author_name')}} ${i}" value="{{$author_1->author_name}}">
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="mb-3">
                                <label class="form-label">{{__('message.sort')}} {{$i}}</label>
                                <input type="number" name="author_sort[]" class="form-control" placeholder="{{__('message.enter_sort')}} ${i}" value="{{$author_1->author_sort}}">
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="mb-3">
                                  <label class="form-label">{{__('message.about_author')}} {{$i}}</label>
                                  <textarea name="about_author[]" class="form-control" placeholder="{{__('message.enter_about_author')}} ${i}">{{$author_1->about_author}}</textarea>
                              </div>
                            </div>
                          </div>
                          @php
                            $i++;
                          @endphp
                        @endforeach
                    @endif
                </div>
                <h3>{{__('message.seo')}}</h3>
                
                <div class="col-lg-6">
                  <div class="mb-3">
                      <label for="name" class="form-label">{{__('message.meta_title')}}<span class="error">*</span></label>
                      <textarea name="meta_title" id="meta_title" class="form-control" placeholder="{{__('message.enter_meta_title')}}">{{$data->seo_title}}</textarea>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                      <label for="name" class="form-label">{{__('message.meta_description')}}<span class="error">*</span></label>
                      <textarea name="meta_description" id="meta_description" class="form-control" placeholder="{{__('message.enter_meta_description')}}">{{$data->seo_description}}</textarea>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                      <label for="name" class="form-label">{{__('message.meta_keywords')}}<span class="error">*</span></label>
                      <textarea name="meta_keyword" id="meta_keyword" class="form-control" placeholder="{{__('message.enter_meta_keyword')}}">{{$data->seo_keywords}}</textarea>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                      <label for="name" class="form-label">{{__('message.no_table_content')}}<span class="error">*</span></label>
                      <input type="text" name="no_content" id="no_content" class="form-control" placeholder="{{__('message.no_table_content')}}" value="{{$data->no_contents}}">
                  </div>
                </div>
                <div id="dynamic_content_fields">
                     @if($contents->isNotEmpty())
                     @php
                       $i =1;
                     @endphp
                      @foreach ($contents as $content_1)
                        <div class="mb-3">
                            <label class="form-label">{{__('message.content_title')}} {{$i}}</label>
                            <input type="text" name="content_title[]" class="form-control" placeholder="{{__('message.enter_content_title')}} {{$i}}" value="{{$content_1->title}}">
                        </div>
                        <div class="mb-3">
                          <label class="form-label">{{__('message.sort')}} {{$i}}</label>
                          <input type="number" name="content_sort[]" class="form-control" placeholder="{{__('message.enter_sort')}} ${i}" value="{{$content_1->content_sort}}">
                      </div>
                        <div class="mb-3">
                            <label class="form-label">{{__('message.content_description')}} {{$i}}</label>
                            <textarea id="description_{{$i}}" name="content_description[]" class="quill-editor" style="height:150px;">{{ $content_1->description }}</textarea>
                        </div>
                        @php
                          $i++;
                        @endphp
                      @endforeach
                    @endif
                </div>
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label for="name" class="form-label">{{__('message.status')}}<span class="error">*</span></label>
                      <select class="form-select" name="status" id="status">
                        <option value="">{{__('message.select_status')}}</option>
                        <option value="active" @if($data->status == 'active') selected @endif>{{__('message.active')}}</option>
                        <option value="inactive" @if($data->status == 'inactive') selected @endif>{{__('message.inactive')}}</option>
                      </select>
                  </div>
                </div>
                <div class="col-lg-12">
                  <a href="{{route('article.index')}}"  class="btn btn-secondary">{{__('message.back')}}</a>
                  <button type="submit" class="btn btn-primary">{{__('message.submit')}}</button>
                </div>
              </div>
          </form>
        </div>
      </div>
  </div>
</div>
@php
	$rules = 'title: {required: true,minlength: 3,maxlength: 150},article_type:{required:true},publish_date:{required:true},received_date:{required:true},accepted_date:{required:true},author:{required:true},pdf:{required:false},"subject[]":{required:true,minlength:1},"topic[]":{required:true,minlength:1},university:{required:true},doi:{required:false,minlength: 3,maxlength: 150},issue:{required:true},volume:{required:true},meta_title:{required:true,minlength: 3,maxlength: 150},meta_description:{required:true,minlength: 3,maxlength: 150},meta_keyword:{required:true,minlength: 3,maxlength: 150},no_content:{required:true,min:1, digits: true},no_author:{required:true,min:1,digits:true},status:{required:true}';
	$submit_url = $formAction;
	$redirect_url = '';
	echo validation($rules,'quickForm',$submit_url,$redirect_url,'');
  echo date_picker();
@endphp
<link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
<script>
  let quillEditors = [];

  generateDynamicFields = (count) => {
      const container = $('#dynamic_content_fields');
      container.empty();  // Clear existing fields
      quillEditors = [];  // Reset editors array

      for (let i = 1; i <= count; i++) {
          const fieldId = `description_${i}`;
          const hiddenFieldId = `hidden_description_${i}`;

          const fieldHtml = `
              <div class="mb-3">
                  <label class="form-label">{{__('message.content_title')}} ${i}</label>
                  <input type="text" name="content_title[]" class="form-control" placeholder="{{__('message.enter_content_title')}} ${i}">
              </div>
              <div class="mb-3">
                  <label class="form-label">{{__('message.sort')}} ${i}</label>
                  <input type="number" name="content_sort[]" class="form-control" placeholder="{{__('message.enter_sort')}} ${i}">
              </div>
              <div class="mb-3">
                  <label class="form-label">{{__('message.content_description')}} ${i}</label>
                  <textarea name="content_description[]" id="${fieldId}" class="form-control" placeholder="{{__('message.enter_about_author')}} ${i}"></textarea>
              </div>
          `;

          container.append(fieldHtml);

          $('#'+fieldId).summernote({
            height: 300,
            toolbar: [
              ['style', ['style']],
              ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
              ['fontname', ['fontname']],
              ['fontsize', ['fontsize']],
              ['color', ['color']],
              ['para', ['ul', 'ol', 'paragraph']],
              ['height', ['height']],
              ['table', ['table']],
              ['insert', ['link', 'picture', 'video', 'hr']],
              ['view', ['fullscreen', 'codeview', 'help']],
              ['misc', ['undo', 'redo']]
            ]
          });
      }
  }
  generateDynamicAuthors = (count) => {
      const container = $('#dynamic_author');
      container.empty();  // Clear existing fields
      quillEditors = [];  // Reset editors array

      for (let i = 1; i <= count; i++) {
          const fieldId = `description_${i}`;
          const hiddenFieldId = `hidden_description_${i}`;

          const fieldHtml = ` <div class="row">
              <div class="col-lg-6"><div class="mb-3">
                  <label class="form-label">{{__('message.author_name')}} ${i}</label>
                  <input type="text" name="author_name[]" class="form-control" placeholder="{{__('message.enter_author_name')}} ${i}">
              </div></div>
              <div class="col-lg-6"><div class="mb-3">
                  <label class="form-label">{{__('message.sort')}} ${i}</label>
                  <input type="number" name="author_sort[]" class="form-control" placeholder="{{__('message.enter_sort')}} ${i}">
              </div></div>
              <div class="col-lg-6">
              <div class="mb-3">
                  <label class="form-label">{{__('message.about_author')}} ${i}</label>
                  <textarea name="about_author[]" class="form-control" placeholder="{{__('message.enter_about_author')}} ${i}"></textarea>
              </div>
              </div>
              <div>
              
          `;

          container.append(fieldHtml);
      }
  }

    $('#no_author').on('input', function () {
        const count = parseInt($(this).val());
        if (!isNaN(count) && count > 0 ) {
            generateDynamicAuthors(count);
        } else {
            $('#dynamic_author').empty();
        }
    });

    $('#no_content').on('input', function () {
        const count = parseInt($(this).val());
        if (!isNaN(count) && count > 0 ) {
            generateDynamicFields(count);
        } else {
            $('#dynamic_content_fields').empty();
        }
    });
    $('#volume').on('change', function () {
        var issue = this.value;
        $('#issue').html('<option>{{__('message.select_issue')}}</option>');

        $.ajax({
            url: "{{route('get_issue')}}" ,
            data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            'issue':issue
            },
            type: "POST",
            success: function (res) {
                $.each(res, function (key, value) {
                    $('#issue').append('<option value="' + key + '">' + value + '</option>');
                });
            }
        });
    });
    function summer_note_editor(count){
      for (let i = 1; i <= count; i++) {
        const fieldId = `description_${i}`;
        const hiddenFieldId = `hidden_description_${i}`;
        $('#'+fieldId).summernote({
          height: 300,
          toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video', 'hr']],
            ['view', ['fullscreen', 'codeview', 'help']],
            ['misc', ['undo', 'redo']]
          ]
        });
          
    }
  }

    summer_note_editor({{$i}});
</script>

<link href="{{asset('css/backend/select2.css')}}" rel="stylesheet" />

<!-- Include Select2 JS -->
<script src="{{asset('js/backend/select2.js')}}"></script>
<script>
  $(document).ready(function() {
    $('#subject').select2({
        placeholder: "Select options",
        allowClear: true,
    });
    $('#topic').select2({
        placeholder: "Select options",
        allowClear: true,
    });
  });
</script>
@endsection