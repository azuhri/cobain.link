@extends('template.main')

@section('title')
    Random
@endsection

@section('content')
<form class="row" action="{{route('link.generate')}}" method="POST">
    @csrf
    <input type="hidden" value="0" name="type_link">
    <div class="col-md-12 d-flex justify-content-center">
        <span class="title-text c-main">cobain.link</span><br>
    </div>
    <div class="col-md-12 mb-3 d-flex justify-content-center">
        <span id="defaultMode">( Default Mode )</span>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-11 d-flex mb-2">
                <input id="inputLink" name="real_link" type="text" class="w-100" required>
            </div>
            <div class="col-md-1 d-flex justify-content-center mb-2">
                <button data-toggle="tooltip" data-placement="bottom" title="Shorten link" id="btnShorten" class="px-4">Shorten</button>
            </div>
            <div class="col-md-4 t-small">Try to <a href="{{route('link.custom')}}">custom link</a></div>
            <div class="col-md-8"></div>
        </div>
    </div>
</form>
@endsection

@section('js')

@endsection
