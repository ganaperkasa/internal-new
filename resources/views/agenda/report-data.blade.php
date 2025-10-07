<div class="main-card mb-3 card">
    <div class="card-header-tab card-header">
        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
            <i class="header-icon lnr-charts icon-gradient bg-happy-green"> </i>
            Data Laporan Harian
        </div>
    </div>
    <div class="card-body">
       
        <table class="table table-hover table-striped table-bordered" id="table1">
        <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Jam Mulai</th>
            <th>Jam Selesai</th>
            <th>Pegawai</th>
            <th>Aktifitas</th>
            
            
        </tr>
        </thead>
        <tbody>
        
            @foreach($data as $item)
            
                <tr>
                    <td align="center">{{ $loop->iteration }}</td>
                    <td>{{ tglIndo($item->tanggal) }}</td>
                    <td align="center">{{$item->jam1}}</td>
                    <td align="center">{{$item->jam2}}</td>
                    <td align="left">{{$item->pegawai}}</td>
                    <td align="left">{{$item->perihal}}</td>
                  
                    
                </tr>
            
            @endforeach
        </tbody>
        </table>
    
    </div>
</div>