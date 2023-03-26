@extends('layouts.admin')

@section('header', 'karyawan')
@section('content')
<div id="container">
    <div class="card">
        <div class="card-header">
          <h3 class="card-title">Data Karyawan</h3>
        </div>
        <div class="btn row d-flex justify-content-start">
            <a href="#" class="btn btn-primary col-md-3" @click='addData()'>Tambah Data</a>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="datatables1" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>Nama Lengkap</th>
              <th>TTL</th>
              <th>Email</th>
              <th>No Telp</th>
              <th>Alamat</th>
              <th>Jabatan</th>
              <th>Action</th>
            </tr>
            </thead>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>

   <!-- Modal -->
    <div class="modal fade" id="modal_karyawan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <form :action="actionUrl"  method="POST" @submit='submitForm($event)'>
            @csrf

            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambah Data Karyawan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="row mt-2">
                  <div class="col-md-4">
                    <h5>Nama Lengkap</h5>
                  </div>
                  <div class="col-md-8">
                    <input type="text" name="nama" class="form-control" required>
                    @error('nama')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
                </div>
                <div class="row mt-2">
                  <div class="col-md-4">
                    <h5>TTL</h5>
                  </div>
                  <div class="col-md-8">
                    <input type="date" name="ttl" class="form-control" required>
                    @error('ttl')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
                </div>
                <div class="row mt-2">
                  <div class="col-md-4">
                    <h5>Email</h5>
                  </div>
                  <div class="col-md-8">
                    <input type="email" name="email" class="form-control" required>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
                </div>
                <div class="row mt-2">
                  <div class="col-md-4">
                    <h5>No Telp</h5>
                  </div>
                  <div class="col-md-8">
                    <input type="number" name="no_telp" class="form-control" required>
                    @error('no_telp')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
                </div>
                <div class="row mt-2">
                  <div class="col-md-4">
                    <h5>Alamat</h5>
                  </div>
                  <div class="col-md-8">
                    <input type="text" name="alamat" class="form-control" required>
                    @error('alamat')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
                </div>
                <div class="row mt-2">
                  <div class="col-md-4">
                    <h5>Jabatan</h5>
                  </div>
                  <div class="col-md-8">
                    <input type="text" name="jabatan" class="form-control" required>
                    @error('jabatan')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
          </form>
        </div>
        </div>
    </div>

</div>
@endsection

@push('datatables')
<script>
    $(function () {
      $("#datatables1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
  </script>
@endpush

@push('js')
    <script>
      const _actionUrlApi = '{{ url('/api/karyawan') }}';
      const _actionUrl = '{{ url('/karyawan') }}';

      let columns = [
        {data: 'nama', orderable: true},
        {data: 'ttl', orderable: true},
        {data: 'email', orderable: true},
        {data: 'no_telp', orderable: true},
        {data: 'alamat', orderable: true},
        {data: 'jabatan', orderable: true},
        {render: function () {
          return ` <div class='d-flex'>
                          <a class='btn btn-sm btn-warning' onclick="app.editData(event, )">Edit</a>
                          <a class='btn btn-sm btn-danger' onclick="app.deleteData()">Delete</a>
                    </div>`;
        }, orderable: false}
      ];
    </script>
    <script>
        const app = new Vue({
            el: '#container',
            data: {
                actionUrl: _actionUrl,
                actionUrlApi: _actionUrlApi,
                data: {},
                datas: []
            },
            mounted: function() {
              this.getData();
            },
            methods: {
                getData() {
                  const _this = this;
                  _this.table = $('#datatables1').DataTable({
                      responsive: {
                        details: {
                          type: 'column'
                        }
                      },
                      ajax: {
                        url: _this.actionUrlApi,
                        type: 'get',
                      },
                      columns: columns
                  }).on('xhr', function () {
                    _this.datas = _this.table.ajax.json().data;
                  });
                },
                addData() {
                    $('#modal_karyawan').modal();
                },
                submitForm(event) {
                      event.preventDefault();
                      const _this = this;
                      let actionUrl = this.actionUrl;
                      axios.post(actionUrl, new FormData($(event.target)[0]))
                          .then(response => {
                              $('#modal-default').modal('hide');
                              _this.table.ajax.reload();
                          })
                },
            }
        })
    </script>
@endpush