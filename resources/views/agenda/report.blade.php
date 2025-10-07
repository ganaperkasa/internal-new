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
    <div class="card-body">
        <h5 class="card-title">Filter</h5>
        <form id="filterForm" class="form-inline">

            {{-- Pegawai --}}
            <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group">
                <label for="user" class="mr-sm-2">Pegawai</label>
                <select name="user" id="user" class="form-control select2" style="min-width:200px;">
                    <option value="">-- Semua Pegawai --</option>
                    @foreach ($user as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Bulan --}}
            <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group">
                <label for="bulan" class="mr-sm-2">Bulan</label>
                <input type="number" name="bulan" id="bulan" value="{{ date('m') }}" class="form-control" min="1" max="12">
            </div>

            {{-- Tahun --}}
            <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group">
                <label for="tahun" class="mr-sm-2">Tahun</label>
                <input type="number" name="tahun" id="tahun" value="{{ date('Y') }}" class="form-control">
            </div>

            <button type="button" class="btn btn-secondary" id="search">Search</button>
        </form>
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
