@extends('layouts.app')

@section('content')
    <div class="row bg-title">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">IMPORT</h4>
        </div>
        <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li class="active">API DATA</li>
            </ol>
        </div>
    </div>
    <div class="white-box">
        {{--<div style="font-size: 20px; padding-bottom: 20px">--}}
        {{--Total Price: {{\App\Services\CommonService::formatPrice($totalPrice)}}--}}
        {{--</div>--}}
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Path</th>
                <th scope="col">Num Of Uses</th>
                <th scope="col">Last Time Called</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $element)
                <tr>
                    <td>{{$element->path}}</td>
                    <td>{{$element->number_of_uses}}</td>
                    <td>{{$element->last_time_called}}</td>
                    <td>
                        <span data-toggle="tooltip" title="Switch Lock"
                              data-animation="false" class="data-lock" id="{{'lock-'. $element->id}}">
                            <i class="fa {{$element->is_locked ? 'fa-unlock' : 'fa-lock'}} text-inverse m-l-5 m-r-5"></i>
                        </span>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('extra_scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.data-lock').click(function () {
                let id = $(this).attr('id').substr(5);
                $.post("{{url('/internal-apis/switch-lock')}}" + '/' + id,
                    {
                        _token: "{{ csrf_token() }}"
                    },
                    (data) => {

                        if (data.success) {
                            if (data.isLocked) {
                                $(this).find('i').removeClass('fa-lock');
                                $(this).find('i').addClass('fa-unlock');
                            } else {
                                $(this).find('i').removeClass('fa-unlock');
                                $(this).find('i').addClass('fa-lock');
                            }
                        } else {
                            $.alert({
                                backgroundDismiss: true,
                                title: 'Fail',
                                content: data.massage,
                            });
                        }

                    });
            })
        });
    </script>
@endsection

