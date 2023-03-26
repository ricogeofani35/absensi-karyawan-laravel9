@extends('layouts.admin')

@section('header', 'absensi')
@section('content')
<div id="container">
    <div class="card text-center mx-auto px-2 py-2" style="width: 18rem">
        <h1><span class="jam"></span>:<span class="menit"></span>:<span class="detik"></span></h1>
        <div class="btn-absen d-flex mt-3 mx-auto gap-2" v-if='!statusIjin'>
            <form action="{{ url('/absensi') }}" method="POST">
                @csrf

                <input type="hidden" name="absen_masuk" value="{{ date('h:i:s') }}">
                <button type="submit" class="btn btn-success btn-sm" onclick="return confirm(`Absen Masuk: ${ new Date().getHours() }-${ new Date().getMinutes()}-${new Date().getSeconds()}`)">Masuk</button>
            </form>
            <button type="button" class="btn btn-warning btn-sm" class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Tidak Masuk</button>
        </div>
        <div class="submit_file" v-if='statusIjin'>
            @if($absensi)
                <form action="{{ url('/absensi'.'/'.$absensi->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <input type="file" name="file_ijin">
                    <button type="submit" class="btn btn-primary" @click='submitFile()'>Submit</button>
                </form>
            @endif
            <p class="text-danger fw-bold"><strong>Ket: Input File akan otomatis hilang saat 3x24 jam</strong></p>
        </div>
    </div>

    <div class="collapse" id="collapseExample">
        <div class="card card-body">
            <div class="mx-auto d-flex">
                <div class="sakit">
                    <form action="{{ url('/absensi') }}" method="POST">
                        @csrf
                        
                        <input type="hidden" name="tidak_masuk" value="1">
                        <button type="submit" class="btn btn-primary" @click='ijinSakit()'  v-if='!statusIjin'>Ijin Sakit</button>
                    </form>
                </div>
                <div class="cuti">
                    <form action="{{ url('/absensi') }}" method="POST">
                        @csrf
                        
                        <input type="hidden" name="tidak_masuk" value="0">
                        <button onclick="return alert('Ijin Cuti Akan diproses max: 3x24 jam')" type="submit" class="btn btn-warning"  v-if='!statusIjin'>Ijin Cuti</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@push('js')
    <script>
        const app = new Vue({
            el: '#container',
            data: {
                statusIjin: localStorage.getItem('status'),
            },
            mounted: function () {
                this.getTime();
            },
            methods: {
                getTime() {
                    setInterval(() => {
                        const date = new Date();
                        let jam = date.getHours();
                        let menit = date.getMinutes();
                        let detik = date.getSeconds();
    
                        const dJam = document.querySelector('.jam');
                        const dMenit = document.querySelector('.menit');
                        const dDetik  = document.querySelector('.detik');
                        dJam.innerHTML = jam;
                        dMenit.innerHTML = menit;
                        dDetik.innerHTML = detik;
                    }, 1000);

                    const status = localStorage.getItem('status');
                    if(status) {
                        setTimeout(() => {
                            localStorage.removeItem('status');
                            location.reload();
                        }, 30000);
                    }
                },
                ijinSakit() {
                    alert('Submit Surat Ijin Sakit, Surat Ijin Bisa Disubmit Max: 3x24 Jam');
                    localStorage.setItem('status', 'true');
                },
                submitFile() {
                    localStorage.removeItem('status');
                }

            }
        })
    </script>
@endpush