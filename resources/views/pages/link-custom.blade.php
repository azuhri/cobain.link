@extends('template.main')

@section('title')
    Custom
@endsection

@section('content')
<form class="row" action="{{route('link.generate')}}" method="POST">
    @csrf
    <input type="hidden" value="1" name="type_link">
    <div class="col-md-12 d-flex justify-content-center">
        <span class="title-text c-main">cobain.link</span><br>
    </div>
    <div class="col-md-12 mb-3 d-flex justify-content-center">
        <span id="defaultMode">( Custom Link )</span>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-11 d-flex mb-2 p-0">
                <input id="inputLink" name="real_link" type="text" class="w-100" required>
            </div>
            <div class="p-0 col-md-1 d-flex justify-content-center mb-2">
                <button data-toggle="tooltip" data-placement="bottom" title="Shorten link" id="btnShorten" class="px-4">Shorten</button>
            </div>
            <div class="p-0 col-md-4 t-small">Back to <a href="{{route('link.random')}}">default mode</a></div>
            <div class="p-0 col-md-8"></div>

            <div class="p-0 col-md-10 t-small"><span class="mr-1">{{url('/')}}/</span><input class="w-80" type="text" id="alias_link" name="alias"></div>
        </div>
    </div>
</form>
@endsection

@section('js')

@endsection
