@extends('app')
@section('title', 'Dashboard')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
   <div class="container">
     <div class="row mb-3">
       <div class="col-sm-6">
         <h1 class="m-0">Data Pengajuan</h1>
       </div>
       <div class="col-sm-6">
           <button class="btn btn-outline-primary float-right" data-toggle="modal" data-target="#createPengajuan" data-keyboard="false" data-backdrop="static">
              Buat Pengajuan
           </button>
       </div>
     </div>
     <b><hr></b>
   </div>
 </div>
 <!-- /.content-header -->

 <!-- Main content -->
 <div class="content">
   <div class="container">
     <div class="row">
       <div class="col-12">
          
          <table class="table table-borderless" id="tableMaster"></table>
          
       </div>
     </div>
   </div>
 </div>

{{-- modal create --}}
<div class="modal fade" id="createPengajuan">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="judulForm">Form Pengajuan Barang</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="formPengajuan" method="POST"> @csrf
        <div class="modal-body">
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Barang</label>
                        <input class="form-control" name="nama_barang" type="text" required>
                    </div>
                    <div class="form-group">
                        <label>Harga Satuan</label>
                        <input class="form-control" name="harga_satuan" type="number" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Alasan Pengajuan</label>
                        <input class="form-control" name="alasan_pengajuan" type="text" required>
                    </div>
                    <div class="form-group">
                        <label>Jumlah Barang</label>
                        <input class="form-control" name="qty" type="number" required>
                    </div>
                </div>
            </div>
          
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Submit Pengajuan</button>
        </div>
        </form>
      </div>
    </div>
</div>

{{-- modal Edit --}}
<div class="modal fade" id="editPengajuan">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="judulForm">Form Edit Pengajuan Barang</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formeditPengajuan"> @csrf
        <input type="hidden" name="id" id="id">
      <div class="modal-body">
          <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
          <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                      <label>Nama Barang</label>
                      <input class="form-control" id="nama_barang" name="nama_barang" type="text" required>
                  </div>
                  <div class="form-group">
                      <label>Harga Satuan</label>
                      <input class="form-control" id="harga_satuan" type="number" required>
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                      <label>Alasan Pengajuan</label>
                      <input class="form-control" id="alasan_pengajuan" type="text" required>
                  </div>
                  <div class="form-group">
                      <label>Jumlah Barang</label>
                      <input class="form-control" id="qty" type="number" required>
                  </div>
              </div>
          </div>
        
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update Pengajuan</button>
      </div>
      </form>
    </div>
  </div>
</div>

@endsection

@section('script')
<script type="text/javascript">

$(document).ready( function () {
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function(){
      // data card 
      let table =  $('#tableMaster').DataTable({
          processing: true,
          serverSide: true,
          // responsive: true,
          ajax: "{{url('/data')}}",
          order:[['id','DESC']],
          columns: [{data: 'nama_barang'},
            {data: 'data', "defaultContent": ""}
          ],
            language: {
            emptyTable: "Beluam Ada Data Pengajuan",
            search: "Cari Data Pengajuan : ",
            lengthMenu: " _MENU_ Data Pengajuan",
            zeroRecords:    "Tidak Ada Data Yang Ditemukan",
          },
          columnDefs: [
              { target: 0, visible: false}
          ],
          // paging: false,
          // scrollCollapse: true,
          // scrollY: '65vh'
      })
        
      // create 
      $('#formPengajuan').submit(function(e) {
        e.preventDefault();
          let form = $('#formPengajuan')[0];
          let dataForm = new FormData(form);
        $.ajax({
          type:'POST',
          url: "{{ url('/ajukan')}}",
          data: dataForm,
          dataType:"JSON",
          processData : false,
          contentType:false,
          success: function(response) {
            $("#createPengajuan").modal('hide');
            Swal.fire({ type: 'success',
                        icon: 'success',
                        title: `${response.message}`,
                        showConfirmButton: false,
                        timer: 2000
            });
            $("#formPengajuan")[0].reset();
            table.ajax.reload();
          },
          error: function(data){
            console.log(data);
          }
        });
      });

      // edit 
      $('body').on('click', '#btn-edit', function () {
        id = $(this).data('id');
        $.ajax({
        url: "edit/"+id,
        type: "GET",
        success: function(response) {
            var data = response.data;
            console.log(data);
            $("#id").val(data.id);
            $("#nama_barang").val(data.nama_barang);
            $("#alasan_pengajuan").val(data.alasan_pengajuan);
            $("#qty").val(data.qty);
            $("#harga_satuan").val(data.harga_satuan);
          }
        });
      });

      // update 
      $('#formeditPengajuan').submit(function(e){
        e.preventDefault();
        $.ajax({
          url: "update/"+id,
          method: 'PUT',
          data: {
                  nama_barang: $('#nama_barang').val(),
                  alasan_pengajuan: $('#alasan_pengajuan').val(),
                  qty: $('#qty').val(),
                  harga_satuan: $('#harga_satuan').val(),
                },
          success: function(response) {
            $("#editPengajuan").modal('hide');
            Swal.fire({ type: 'success',
                        icon: 'success',
                        title: `${response.message}`,
                        showConfirmButton: false,
                        timer: 2000
            });
            table.ajax.reload();
          },
          error: function(data){
            console.log(data);
          }
        });
      });
      
      // delete
      $("body").on("click", "#btn-delete", function(e) {
          e.preventDefault();
          id = $(this).data('id');
            Swal.fire({
                title: "Apakah anda yakin?",
                text: "Data pengajuan anda akan dihapus!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus!",
                cancelButtonText: "Batalkan"
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "delete/"+id,
                    type: "DELETE",
                    data: {id},
                    success: function(response) {
                        Swal.fire({
                        title: "Terhapus!",
                        text: "Data pengajuan anda berhasil dihapus.",
                        icon: "success"
                        });
                        table.ajax.reload();
                    }
                });
            }
        });
      });

      // disable access 
      $(document).on("click", ".disabled", function() {
        Swal.fire({icon: "warning",
                    title:"Akses Terbatas",
                    text:"Hanya yang membuat pengajuan dan belum di Approved oleh Manager"});
        table.ajax.reload();
      });

      
    });

});
</script>    

@endsection
