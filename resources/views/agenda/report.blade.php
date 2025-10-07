@extends('layouts.backend')

@push('custom-css')

@endpush

@section('content')

<div class="app-page-title">
    <div class="page-title-wrapper">
      <div class="page-title-heading">
          <div class="page-title-icon">
              <i class="pe-7s-graph2 icon-gradient bg-night-fade">
              </i>
          </div>
          <div>Rekap Laporan Harian
            <div class="page-title-subheading"></div>
          </div>
      </div>
    </div>
</div>
<div class="main-card mb-3 card">
    <div class="card-body"><h5 class="card-title">Filter</h5>
        <div>
            <form class="form-inline">
                <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group">
                  <label for="exampleEmail22" class="mr-sm-2">Pegawai</label>
                  {{ Form::select('user_id', $user, null, ['class' => 'form-control select2','id'=>'user','placeholder'=>'--Semua Pegawai--']) }}
                  
                </div>
                <br>
                <br>
                <br>
                <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group">
                  <label for="exampleEmail22" class="mr-sm-2">Bulan</label>
                  <input name="bulan" id="bulan" value="{{ date('m') }}" type="number" name="bulan" class="form-control">
                </div>
                <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group">
                  <label for="exampleEmail22" class="mr-sm-2">Tahun</label>
                  <input name="tahun" id="tahun" value="{{ date('Y') }}" type="number" name="tahun" class="form-control">
                </div>
                <button type="button" class="btn btn-secondary" id="search">Search</button>
              
            </form>
        </div>
    </div>
</div>

<div id="listData"></div>
@endsection

@push('custom-scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('.app-container').addClass('closed-sidebar');
        $('.select2').select2();
    });
  
    $("#search").on("click", function(){

        var user = $("#user").val();
        var bulan = $("#bulan").val();
        var tahun = $("#tahun").val();
      
        $.ajax({
            type: "GET",
            url: "{{ url('daily/report') }}?user="+user+"&bulan="+bulan+"&tahun="+tahun,
            dataType: "html",
            success:function(data){
                $("#listData").html(data);
            },
            error: function(xhr){
                $("#listData").html("");
            }
        });
    });
    
    function load_data(id){
      console.log(id);
    }
  </script>
@endpush