@extends('layouts.app')

@section('content')
    <div class="row bg-title">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">NOTES</h4>
        </div>
        <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li class="active">Notes</li>
            </ol>
        </div>
    </div>
    <div class="white-box">

        <div class="form-group row ">
            {!! Form::label('name', 'Name', ['class' => 'col-md-1 col-form-label', 'style' =>'padding-top:9px']) !!}
            <div class="col-md-5 col-sm-5">
                {!! Form::select('id', $names, null, ['id' => 'id','class' => 'form-control', 'required' => 'required']) !!}
            </div>
        </div>

        <form action="{{url('admin/notes')}}" method="POST">
            <div class="form-group row ">
                {!! Form::token() !!}
                <input type="hidden" name="id" value="{{$id}}">
                <div class="col-md-12">
                    <textarea name="content" class='form-control summernote'>{{$content}}</textarea>
                </div>
                <div class="col-md-12">
                    {!! Form::submit('SUBMIT', ['class' => 'btn btn-info col-md-1 pull-right']) !!}
                </div>
            </div>
        </form>

    </div>
@section('extra_scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $("#id option[value={!! $id !!}]").prop('selected', true);
            $("#id").change(function () {
                window.location.href = "{{url('/admin/notes?id=')}}" + this.value;
            });
        });
    </script>
@endsection
@endsection

