@extends('layouts.backend')

@push('custom-css')

@endpush

@section('content')
<div class="app-inner-layout chat-layout">
    <div class="app-inner-layout__header text-white bg-premium-dark">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon"><i class="pe-7s-chat icon-gradient bg-sunny-morning"></i></div>
                    <div>
                        Forum
                        <div class="page-title-subheading">Forum diskusi tentang aplikasi antara Dinas Kominfo dan Perangkat Daerah</div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="app-inner-layout__wrapper">
        <div class="app-inner-layout__content card">
            <div class="table-responsive">
                <div class="app-inner-layout__top-pane">
                    <div class="pane-left" >
                        <div class="mobile-app-menu-btn">
                            <button type="button" class="hamburger hamburger--elastic">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                            </button>
                        </div>
                        <h4 class="mb-0 text-nowrap">
                            <span id="labelPD"></span>
                        </h4>
                        
                       
                    </div>
                    <div class="pane-right">
                        <div class="btn-group dropdown">
                            <button type="button" class="ml-2 btn btn-primary" id="informasiAplikasi">
                                Informasi Aplikasi
                            </button>
                        </div>
                    </div>
                </div>
                
                <div style="margin-left:20px;">
                    <span class="opacity-7" id="labelPekerjaan"></span>
                </div>
                <hr>
                <div class="card-hover-shadow-2x mb-3 card">
                    <div class="scroll-area-lg">
                        <div class="scrollbar-container ps ps--active-y" id="divScroll">
                            <div class="p-2">
                                <div id="listChat"></div>
                            </div>
                            <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;">
                                </div>
                            </div>
                            <div class="ps__rail-y" style="top: 0px; height: 400px; right: 0px;">
                                <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 250px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <input placeholder="Write here and hit enter to send..." type="text" class="form-control-sm form-control" id="sendChat">
                    </div>
                </div>
                
            </div>
        </div>
        <div class="app-inner-layout__sidebar card">
            <div class="app-inner-layout__sidebar-header">
                <ul class="nav flex-column">
                    <li class="pt-4 pl-3 pr-3 pb-3 nav-item">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fa fa-search"></i>
                                </div>
                            </div>
                            <input placeholder="Search..." type="text" class="form-control"></div>
                    </li>
                    <li class="nav-item-header nav-item">Daftar Aplikasi</li>
                </ul>
            </div>
            <ul class="nav flex-column" id="leftChat">
                
            </ul>

        </div>
    </div>
</div>
@endsection



@push('custom-scripts')

<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

    $.ajax({
        type: "get",
        url: "{{ url('chat') }}",
        dataType: "html",
        success:function(data){
            $("#leftChat").html(data);
        },
        error: function(xhr){
            
        }
    });



$('#sendChat').on('keypress', function (e) {
    if(e.which === 13){

        var message = $(this).val();
        var project = $("#project_id").val();
        $.ajax({
    		type: "POST",
    		url: "{{ url('chat/send') }}",
            data:{message:message, project:project},
    		dataType: "html",
    		success:function(data){
                $("#sendChat").val("");
                getDetailChat();
                var objDiv = document.getElementById("listChat");
                objDiv.scrollTop = objDiv.scrollHeight;
                $('#divScroll').animate({
                    scrollTop: $('#divScroll').get(0).scrollHeight
                }, 1500);
    		},
    		error: function(xhr){
                $("#sendChat").val("");
    		}
    	});
       
    }
});



function getDetailChat(){
    var project = $("#project_id").val();
    $.ajax({
        type: "get",
        url: "{{ url('chat/detail') }}?project="+project,
        dataType: "html",
        success:function(data){

            $("#listChat").html(data);
           
        },
        error: function(xhr){
            
        }
    });
}
</script>
@endpush
