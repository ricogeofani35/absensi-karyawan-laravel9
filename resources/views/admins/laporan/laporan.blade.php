@extends('layouts.admin')

@section('header', 'laporan')
@section('content')
<div id="container">
    <div class="card">
        <div class="card-header">
          <h3 class="card-title">Data Laporan</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="datatables1" class="table table-bordered table-striped ">
            <thead>
            <tr>
              <th>Tanggal</th>
              <th>Nama Karyawan</th>
              <th>Absen</th>
              <th>Keterangan</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
            </thead>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
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
      const _actionUrlApi = '{{ url('/api/laporan') }}';
      const _actionUrl = '{{ url('/laporan') }}';

      let columns = [
        {data: 'tanggal_absen', orderable: true, class: 'text-center'},
        {data: 'user.name', orderable: true, class: 'text-center'},
        {render: function(index, row, data, meta) {
          return data.absen_masuk ? data.absen_masuk : 'tidak masuk'
        }, orderable: true, class: 'text-center'},
        {render: function(index, row, data, meta) {
          return data.absen_masuk ? '-' : data.tidak_masuk == 1 ? 'sakit' : 'ijin cuti'
        }, orderable: true, class: 'text-center'},
        {render: function(index, row, data, meta) {
          return data.absen_masuk ? '-' : data.status == 1 ? `<span class='text-success'>Disetujui</span>` : `<span class='text-danger'>Responding</span>`
        }, orderable: true, class: 'text-center'},
        {render: function (index, row, data, meta) {
          return ` <div class='d-flex gap-3'>
                          <a class='btn btn-sm btn-warning' onclick="app.editData(event, )">Edit</a>
                          <a class='btn btn-sm btn-danger' onclick="app.deleteData()">Delete</a>
                    </div>`;
        }, orderable: false, class: 'text-center'}
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