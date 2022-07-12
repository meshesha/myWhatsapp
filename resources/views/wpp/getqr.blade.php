@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('QRCODE image') }}</div>

                <div class="card-body">
                    <div class="m-1" id="qrcode-container">
                        <img src="" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="overlay"></div>
</div>
@endsection

@section('head_style')
<style>
    /* .overlay{
        display: none;
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 999;
        background: rgba(255,255,255,0.8) url("/images/loader.gif") center no-repeat;
    }
    body.loading{
        overflow: hidden;   
    }
    body.loading .overlay{
        display: block;
    } */
</style>
@endsection

@section('foot_script')
<script type="text/javascript">
    var qrcodehash = "-1";
    // $(document).on({
    //     ajaxStart: function(){
    //         $("body").addClass("loading"); 
    //     },
    //     ajaxStop: function(){ 
    //         $("body").removeClass("loading"); 
    //     }    
    // });

    getQrCode();
    setInterval(function () {
        getQrCode();
    }, 1000);

    function getQrCode() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type:'POST',
            url:'/wpp/getqrcode',
            // data:'_token = <?php echo csrf_token() ?>',
            success:function(data) {
                //$("#msg").html(data.msg);
                //console.log(data);
                if(data != "" && data !== null){
                    try{
                        var jsonData = data.response;//JSON.parse(data)
                        var data_status = jsonData.status;
                        var qrcode = jsonData.qrcode;
                        var newcrcodehash = data.hash;
                        //console.log("conn_status: ", data.conn_status);
                        if(data.conn_status && data.conn_status.status == true){
                            window.location.href = "/home";
                        }else{
                            if(data_status == "QRCODE" && qrcodehash != newcrcodehash){
                                $("#qrcode-container img").attr("src", qrcode)
                                qrcodehash = newcrcodehash;
                            }
                        }
                    }catch(e){
                        console.log("error parsing data: ", JSON.stringify(e));
                    }
                }
            }
        });
    }
</script>
@endsection