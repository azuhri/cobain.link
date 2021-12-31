@extends('template.main')

@section('title')
    Generate
@endsection

@section('content')
<form class="row" action="javascript:void(0)" method="POST">
    @csrf
    <input type="hidden" value="0" name="type_link">
    <div class="col-md-12 d-flex justify-content-center">
        <span class="title-text c-main">Simple.link</span><br>
    </div>
    <div class="col-md-12 mb-3 d-flex justify-content-center">
        <span id="defaultMode">( Generate Link )</span>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-11 d-flex mb-2">
                {{-- Check type link random or custom link --}}
                @if ($sourceLink->type_link == 0)
                    <input id="inputLink" name="real_link" value="{{url('/')."/".$link->random_code}}" type="text" class="w-100">
                @else
                    <input id="inputLink" name="real_link" value="{{url('/')."/".$link->alias}}" type="text" class="w-100">
                @endif
            </div>
            <div class="col-md-1 d-flex justify-content-center mb-2">
                {{-- Check type link random or custom link --}}
                @if ($sourceLink->type_link == 0)
                    <button onclick="copyLink('{{url('/').'/'.$link->random_code}}')" data-toggle="tooltip" data-placement="bottom" title="Copy link" id="btnCopylink" class="px-4"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg></button>
                    <a href="javascript:void(0)" onclick="downloadQR('qrcode','{{str_replace(' ','-','qrcode-link-'.$link->random_code)}}')" data-toggle="tooltip" data-placement="bottom" title="Download QR code" id="btnDownloadQR" class="px-4"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg></a>
                @else
                    <button onclick="copyLink('{{url('/').'/'.$link->alias}}')" data-toggle="tooltip" data-placement="bottom" title="Copy link" id="btnCopylink" class="px-4"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg></button>
                    <a href="javascript:void(0)" onclick="downloadQR('qrcode','{{str_replace(' ','-','qrcode-link-'.$link->alias)}}')" data-toggle="tooltip" data-placement="bottom" title="Download QR code" id="btnDownloadQR" class="px-4"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg></a>
                @endif
            </div>
            <div class="col-md-3 t-small">Back to <a href="{{url('/')}}">default mode</a></div>
            <div class="col-md-12">
                <div class="text-center t-small">Scan this barcode or click icon download</div>
            </div>
            <div class="col-md-12 d-flex justify-content-center">
                <div id="qrcode" class="my-2">
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('js')
<script>
    // Function to generate qrcode link
    var qrcode = new QRCode(document.getElementById("qrcode"), {
        text: "{{url('/')."/".$link->random_code}}",
        width: 128,
        height: 128,
        colorDark : "#c91c4a",
        colorLight : "transparent",
        correctLevel : QRCode.CorrectLevel.H
    });

    // Function to download qrcode link
    let downloadQR = (id_tag, filename) => {
        let element = document.getElementById(id_tag);
        html2canvas(element).then((canvas) => {
            const bas64Image = canvas.toDataURL('image/png');
            var anchor = document.createElement('a');
            anchor.setAttribute('href', bas64Image);
            anchor.setAttribute('download',filename+".png");
            anchor.click();
            anchor.remove();
        }).catch(e => console.log(e))

    }

</script>
@endsection
