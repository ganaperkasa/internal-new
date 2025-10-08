<div class="app-sidebar__inner">
    <ul class="vertical-nav-menu">
      <li>
          <a href="{{ url('home') }}">
              <i class="metismenu-icon pe-7s-graph2">
              </i>Beranda
          </a>
      </li>
      <!-- <li>
          <a href="{{ url('calendar') }}">
              <i class="metismenu-icon pe-7s-airplay">
              </i>Kalender Markgov
          </a>
      </li> -->
      <li>
          <a href="{{ url('daily') }}">
              <i class="metismenu-icon pe-7s-note2">
              </i>Laporan Harian
          </a>
      </li>
      <li>
          <a href="{{ route('daily.report') }}">
              <i class="metismenu-icon pe-7s-note2">
              </i>Rekap Harian
          </a>
      </li>

      <li>
          <a href="{{ route('cuti.index') }}">
              <i class="metismenu-icon pe-7s-note2">
              </i>Cuti
          </a>
      </li>

      <li class="app-sidebar__heading">Admin</li>
      <li>
          <a href="{{ url('admin/surat') }}">
              <i class="metismenu-icon pe-7s-note2">
              </i>Surat
          </a>
      </li>
      <li>
          <a href="{{ url('admin/aset') }}">
              <i class="metismenu-icon pe-7s-note2">
              </i>Aset
          </a>
      </li>
      <li>
          <a href="">
              <i class="metismenu-icon pe-7s-note2">
              </i>Pekerjaan
          </a>
      </li>
      <li class="app-sidebar__heading">Marketing</li>
      <li>
            <a href="{{ url('marketing/visit/create') }}">
                <i class="metismenu-icon pe-7s-car">
                </i>Kunjungan Pelanggan
            </a>
            <a href="{{ url('marketing/visit') }}">
                <i class="metismenu-icon pe-7s-display1">
                </i>Hasil Kunjungan
            </a>
            <a href="{{ url('marketing/contact') }}">
                <i class="metismenu-icon pe-7s-users">
                </i>Daftar Kontak
            </a>

        </li>
        <!-- <li class="app-sidebar__heading">Laporan</li>
        <li class="">
            <a href="#" aria-expanded="false">
                <i class="metismenu-icon pe-7s-graph1"></i>
                Rekap
                <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
            </a>
            <ul class="mm-collapse" style="height: 7.04px;">
                <li>
                    <a href="{{ url('report/daily') }}">
                        <i class="metismenu-icon pe-7s-graph1">
                        </i>Rekap Laporan Harian
                    </a>
                </li>
                <li>
                    <a href="{{ url('report/visit') }}">
                        <i class="metismenu-icon pe-7s-graph1">
                        </i>Rekap Kunjungan
                    </a>
                </li>
            </ul>
        </li> -->
        <!-- <li class="">
            <a href="#" aria-expanded="false">
                <i class="metismenu-icon pe-7s-graph2"></i>
                Grafik
                <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
            </a>
            <ul class="mm-collapse" style="height: 7.04px;">
                <li>
                    <a href="{{ url('chart/daily') }}">
                        <i class="metismenu-icon pe-7s-graph2">
                        </i>Grafik Laporan Harian
                    </a>
                </li>
                <li>
                    <a href="{{ url('chart/visit') }}">
                        <i class="metismenu-icon pe-7s-graph2">
                        </i>Grafik Kunjungan
                    </a>
                </li>
            </ul>
        </li>
         -->



        <li class="app-sidebar__heading">Master</li>
        <li>
            <a href="{{ url('master/barang') }}">
                <i class="metismenu-icon pe-7s-ribbon">
                </i>Barang
            </a>
        </li>
        <li>
            <a href="{{ url('master/instansi') }}">
                <i class="metismenu-icon pe-7s-ribbon">
                </i>Instansi
            </a>
        </li>
        <li>
            <a href="{{ url('master/jabatan') }}">
                <i class="metismenu-icon pe-7s-ribbon">
                </i>Jabatan
            </a>
        </li>
        <li>
            <a href="{{ url('master/setting') }}">
                <i class="metismenu-icon pe-7s-ribbon">
                </i>Pengaturan
            </a>
        </li>
        <li>
            <a href="{{ url('master/divisi') }}">
                <i class="metismenu-icon pe-7s-ribbon">
                </i>Divisi
            </a>
        </li>
        <li>
            <a href="{{ url('master/user') }}">
                <i class="metismenu-icon pe-7s-users">
                </i>User
            </a>
        </li>
    </ul>
</div>
