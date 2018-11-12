@extends('layouts.app')

@section('content')
    <div class="row bg-title">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">DIARY</h4>
        </div>
        <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li>Admin</li>
                <li class="active">Diary</li>
            </ol>
        </div>
    </div>
    <div class="white-box">
        <form action="{{url('admin/diary')}}" method="GET">
            <div class="form-group row ">
                {!! Form::label('date', 'Date', ['class' => 'col-md-1 col-form-label', 'style' =>'padding-top:9px']) !!}

                {!! Form::text('date', null, ['class' => 'form-control birthday-datepicker col-md-2 text-center', 'onkeydown' => 'return false;']) !!}

                {!! Form::submit('FIND', ['class' => 'btn btn-info col-md-1']) !!}

            </div>
        </form>
        @if($date)
            <form action="{{url('admin/diary')}}" method="POST">
                <div class="form-group row ">
                    {!! Form::token() !!}
                    <input type="hidden" name="date" value="{{Request::get('date')}}">
                    <div class="col-md-12">
                        <textarea name="content" class='form-control summernote'>{{$content}}</textarea>
                    </div>
                    <div class="col-md-12">
                        {!! Form::submit('SUBMIT', ['class' => 'btn btn-info col-md-1 pull-right']) !!}
                    </div>
                </div>
            </form>
        @endif
    </div>
@endsection