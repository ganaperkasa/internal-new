@foreach($data as $value)
<li class="nav-item listItem" data-kode="{{ $value->project_id }}" data-pd="{{ $value->perangkat_daerah }}" data-paket="{{ $value->paket_pekerjaan }}">
    <button type="button" tabindex="0" class="dropdown-item">
        <div class="widget-content p-0">
            <div class="widget-content-wrapper">
                
                <div class="widget-content-left">
                    <div class="widget-heading">{{ $value->perangkat_daerah }}</div>
                    <div class="widget-subheading">{{ $value->paket_pekerjaan }}</div>
                </div>
            </div>
        </div>
    </button>
</li>
@endforeach
<input type="hidden" id="project_id">
<script>
var kode = "";
$( ".listItem" ).click(function() {
    
  kode = $(this).data("kode");
  var pd = $(this).data("pd");
  var paket = $(this).data("paket");
  
    $("#labelPD").html(pd);
    $("#labelPekerjaan").html(paket);
    $("#project_id").val(kode);
    $.ajax({
        type: "get",
        url: "{{ url('chat/detail') }}?project="+kode,
        dataType: "html",
        success:function(data){

            $("#listChat").html(data);
           
        },
        error: function(xhr){
            
        }
    });  
});

$( "#informasiAplikasi" ).click(function() {
    if(kode != ""){
        location.href = "{{url('project')}}/"+kode;
    }
});
</script>
