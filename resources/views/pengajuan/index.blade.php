@extends('app')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-12">
          <h1 class="m-0">Halaman Pengajuan</h1>
        </div>
      </div>
    </div>
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">List Pengajuan</h5>
              </div>
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                      <tr>
                          <th>No</th>
                          <th>Nama Item</th>
                          <th>Deskripsi Item</th>
                          <th>Kuantiti</th>
                          <th>Harga /Unit</th>
                          <th>Total Harga</th>
                          <th>Status</th>
                          <th>Tanggal Pengajuan</th>
                      </tr>
                  </thead>
                </table>
              </div>
            </div>
        </div>
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('script')
    <script>
      
    </script>
@endsection

  