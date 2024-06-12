@extends('app')
@section('title', 'Dashboard')
@section('css')
<style>
  .vertical-timeline {
      width: 100%;
      position: relative;
      padding: 1.5rem 0 1rem;
  }

  .vertical-timeline::before {
      content: '';
      position: absolute;
      top: 0;
      left: 67px;
      height: 100%;
      width: 4px;
      background: #e9ecef;
      border-radius: .25rem;
  }

  .vertical-timeline-element {
      position: relative;
      margin: 0 0 1rem;
  }

  .vertical-timeline--animate .vertical-timeline-element-icon.bounce-in {
      visibility: visible;
      animation: cd-bounce-1 .8s;
  }
  .vertical-timeline-element-icon {
      position: absolute;
      top: 0;
      left: 60px;
  }

  .vertical-timeline-element-icon .badge-dot-xl {
      box-shadow: 0 0 0 5px #fff;
  }

  .badge-dot-xl {
      width: 18px;
      height: 18px;
      position: relative;
  }

  .badge:empty {
      display: none;
  }

  .badge-dot-xl::before {
      content: '';
      width: 10px;
      height: 10px;
      border-radius: .25rem;
      position: absolute;
      left: 50%;
      top: 50%;
      margin: -5px 0 0 -5px;
      background: #fff;
  }

  .vertical-timeline-element-content {
      position: relative;
      margin-left: 90px;
      font-size: .8rem;
  }

  .vertical-timeline-element-content .timeline-title {
      font-size: .8rem;
      text-transform: uppercase;
      margin: 0 0 .5rem;
      padding: 2px 0 0;
      font-weight: bold;
  }

  .vertical-timeline-element-content .vertical-timeline-element-date {
      display: block;
      position: absolute;
      left: -90px;
      top: 0;
      padding-right: 10px;
      text-align: right;
      color: #adb5bd;
      font-size: .7619rem;
      white-space: nowrap;
  }

  .vertical-timeline-element-content:after {
      content: "";
      display: table;
      clear: both;
  }
</style>
@endsection
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

{{-- modal Create --}}
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

{{-- modal bukti transfer  --}}
<div class="modal fade" id="uploadBuktiBayar">
  <div class="modal-dialog modal-m">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="judulForm">Form Bukti Bayar</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formBuktiBayar" method="POST" enctype="multipart/form-data"> @csrf
        <input type="hidden" name="id" id="id">
      <div class="modal-body">
          <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
          <div class="row">
              <div class="col-md-12">
                  <div class="form-group">
                      <input class="form-control" id="bukti" name="bukti" type="file" required>
                      <a data-fancybox href="#preview">
                        <img id="preview" src="#" alt="Preview" style="display: none; max-width: 100%; margin-top: 10px;">
                      </a>
                  </div>
              </div>
          </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Upload</button>
      </div>
      </form>
    </div>
  </div>
</div>

{{-- modal Detail --}}
<div class="modal fade" id="detailPengajuan">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="judulForm">Tracking Pengajuan Barang</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" id="id">
        <div class="row">
          <div class="col-md-10 ml-auto">
            <div id="detailTracking">

            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script type="text/javascript">

  $(document).ready( function () {
      $.ajaxSetup({
        headers:{
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
      });

      $(document).ready(function(){
        // data card 
        let table =  $('#tableMaster').DataTable({
            processing: true,
            serverSide: true,
            lengthMenu: [5, 10, 25, 50, 75, 100],
            ajax: "{{url('/data')}}",
            order:[['id','DESC']],
            columns: [{data: 'nama_barang'},
              {data: 'alasan_pengajuan'},
              {data: 'qty'},
              {data: 'harga_satuan'},
              {data: 'total_harga'},
              {data: 'updated_at'},
              {data: 'data', "defaultContent": ""}
            ],
              language: {
              emptyTable: "Beluam Ada Data Pengajuan",
              search: "Cari Data Pengajuan : ",
              lengthMenu: " _MENU_ Data Pengajuan",
              zeroRecords:    "Tidak Ada Data Yang Ditemukan",
            },
            columnDefs: [
                { target: 0, visible: false},
                { target: 1, visible: false},
                { target: 2, visible: false},
                { target: 3, visible: false},
                { target: 4, visible: false},
                { target: 5, visible: false},
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

        // reject manager 
        $(document).on("click", "#reject-manager", function(e) {
          e.preventDefault();
          id = $(this).data('id');
              Swal.fire({
              title: "Berikan Alasan",
              input: "textarea",
              inputValidator: (value) => {
                return !value && 'Anda perlu memberikan alasan penolakan'
              },
              inputAttributes: {
                name: "alasan_manager",
              },
              showCancelButton: true,
              confirmButtonText: "Submit",
            }).then((result) => {
              if (result.value) {
                $.ajax({
                    url: "reject/"+id,
                    type: "POST",
                    data: {
                      id, 
                      alasan_manager: result.value
                    },
                    success: function(response) {
                      Swal.fire({
                        title: "Rejected",
                        text: "Anda berhasil menolak pengajuan ini.",
                        icon: "success"
                      });
                      table.ajax.reload();
                      console.log(response);
                    },
                      error: function(data){
                      console.log(data);
                    }
                })
              }
            });

        });

        //approve manager
        $(document).on("click", "#approve-manager", function(e) {
          e.preventDefault();
          id = $(this).data('id');
          Swal.fire({
            title: "Apakah anda yakin?",
            text: "Anda akan menyetujui pengajuan ini",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#67c725",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Setujui",
            showLoaderOnConfirm: true,
            cancelButtonText: "Batalkan"
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                      url: "approve/"+id,
                      type: "POST",
                      data: {id},
                      success: function(response) {
                      Swal.fire({
                        title: "Menyetujui",
                        text: "Anda telah menyetujui pengajuan ini.",
                        icon: "success"
                      });
                      table.ajax.reload();
                      console.log(response);
                    },
                      error: function(data){
                      console.log(data);
                    }
              });
            }
          });
        });

        // reject finance 
        $(document).on("click", "#reject-finance", function(e) {
          e.preventDefault();
          id = $(this).data('id');
              Swal.fire({
              title: "Berikan Alasan",
              input: "textarea",
              inputValidator: (value) => {
                return !value && 'Anda perlu memberikan alasan penolakan'
              },
              inputAttributes: {
                name: "alasan_finance",
              },
              showCancelButton: true,
              confirmButtonText: "Submit",
            }).then((result) => {
              if (result.value) {
                $.ajax({
                    url: "finance-reject/"+id,
                    type: "POST",
                    data: {
                      id, 
                      alasan_finance: result.value
                    },
                    success: function(response) {
                      Swal.fire({
                        title: "Rejected",
                        text: "Anda berhasil menolak pengajuan ini.",
                        icon: "success"
                      });
                      table.ajax.reload();
                      console.log(response);
                    },
                      error: function(data){
                      console.log(data);
                    }
                })
              }
            });

        });

        //approve finance
        $(document).on("click", "#approve-finance", function(e) {
          e.preventDefault();
          id = $(this).data('id');
          Swal.fire({
            title: "Apakah anda yakin?",
            text: "Anda akan menyetujui pengajuan ini",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#67c725",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Setujui",
            showLoaderOnConfirm: true,
            cancelButtonText: "Batalkan"
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                      url: "finance-approve/"+id,
                      type: "POST",
                      data: {id},
                      success: function(response) {
                      Swal.fire({
                        title: "Menyetujui",
                        text: "Anda telah menyetujui pengajuan ini.",
                        icon: "success"
                      });
                      table.ajax.reload();
                      console.log(response);
                    },
                      error: function(data){
                      console.log(data);
                    }
              });
            }
          });
        });

        // Upload bukti bayar 
        $('body').on('click', '#bukti-finance', function () {
          id = $(this).data('id');
          $('#formBuktiBayar').submit(function(e){
            e.preventDefault();
              let form = $('#formBuktiBayar')[0];
              let dataForm = new FormData(form);
            $.ajax({
              type:'POST',
              url: "finance-upload/"+id,
              data: dataForm,
              processData : false,
              contentType:false,
              success: function(response) {
                $("#uploadBuktiBayar").modal('hide');
                Swal.fire({ type: 'success',
                            icon: 'success',
                            title: `${response.message}`,
                            showConfirmButton: true,
                            // timer: 2000
                });
                $("#formBuktiBayar")[0].reset();
                table.ajax.reload();
              },
              error: function(data){
                console.log(data);
              }
            });
          });
        });

        $(function () {
            $('input[type=file]').change(function () {
                var val = $(this).val().toLowerCase(),
                    regex = new RegExp("(.*?)\.(jpg|jpeg|pdf|png)$");

                if (!(regex.test(val))) {
                    $(this).val('');
                    Swal.fire({
                      icon: "error",
                      title: "Oops...",
                      text: "Hanya dapat memasukan file jenis .jpg .jpeg .png .pdf ",
                    });
                }
            });
        });

        //preview image
        $(document).ready(function() {
          $('#bukti').change(function() {
              previewImage(this);
                
          });
        });
  
          function previewImage(input) {
              var preview = $('#preview')[0];
              if (input.files && input.files[0]) {
                  var reader = new FileReader();
                  reader.onload = function (e) {
                      preview.src = e.target.result;
                      preview.style.display = 'block';
                  }
                  reader.readAsDataURL(input.files[0]);
              }
          }

        $('body').on('click', '#btn-detail', function(e) {
          e.preventDefault();
          id = $(this).data('id');
          $.ajax({
          url: "detail/"+id,
          type: "GET",
          processData : false,
          contentType:false,
          success: function(response) {
              console.log(response);
              $('#detailTracking').html(response.html);
            }
          });
        })
        
        
      });

  });

Fancybox.bind("[data-fancybox]", {

});
</script>    
@endsection
