@extends('app')
@section('title', 'Dashboard')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
   <div class="container">
     <div class="row mb-3">
       <div class="col-sm-6">
         <h1 class="m-0">Pengajuan</h1>
       </div>
       <div class="col-sm-6">
           <button class="btn btn-outline-primary float-right" data-toggle="modal" data-target="#createPengajuan" data-keyboard="false" data-backdrop="static">
              Buat Pengajuan
           </button>
       </div>
     </div>
   </div>
 </div>
 <!-- /.content-header -->
 
 <!-- Main content -->
 <div class="content">
   <div class="container">
     <div class="row">
       <div class="col-12">
           <div id="cardContent">
               <div class="card card-primary card-outline">
                   <div class="card-header">
                       <h5 class="card-title m-0">Pengajuan - </h5>
                       <div class="card-tools">
                           <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                               <i class="fas fa-bars"></i>
                           </button>
                           <div class="dropdown-menu dropdown-menu-right" role="menu">
                               <a href="" class="dropdown-item"><i class="fa fa-edit"></i> Edit</a>
                               <a href="" class="dropdown-item"><i class="fa fa-trash"></i> Delete</a>
                           </div>
                       </div>
                    </div>
                   <div class="card-body">
                   
                   <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                   
                   </div>
                   <div class="card-footer">
                       <a href="#" class="btn btn-primary float-right">Go somewhere</a>
                       <div>
                       </div>
                       <h6 class="text-success"><i class="far fa-check-circle"></i> Diajukan 12 Juni 2024</span>
                   </div>
                </div>
       
           </div>
       </div>
     </div>
   </div>
 </div>

{{-- modal  --}}
<div class="modal fade" id="createPengajuan">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="judulForm">Form Pengajuan Barang</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="formPengajuan"> @csrf
        <div class="modal-body">
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="user_id" id="id">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Barang</label>
                        <input class="form-control" id="item_name" type="text" required>
                    </div>
                    <div class="form-group">
                        <label>Harga Satuan</label>
                        <input class="form-control" id="unit_price" type="number" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Alasan Pengajuan</label>
                        <input class="form-control" id="item_description" type="text" required>
                    </div>
                    <div class="form-group">
                        <label>Jumlah Barang</label>
                        <input class="form-control" id="total_price" type="number" required>
                    </div>
                </div>
            </div>
          
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Ajukan</button>
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

    $('#formPengajuan').submit(function(e) {
     e.preventDefault();
  
     var formData = new FormData(this);
  
     $.ajax({
        type:'POST',
        url: "{{ url('ajukan')}}",
        data: formData,
        cache:false,
        contentType: false,
        processData: false,
        success: (data) => {
          $("#createPengajuan").modal('hide');
        
        },
        error: function(data){
           console.log(data);
         }
       });
    });
});
</script>    

@endsection
