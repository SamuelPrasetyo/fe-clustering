@extends('layouts.app')

@section('title', 'Nilai Siswa')

@section('content')
<link href="{{ asset('assets/data_tables/datatables.min.css') }}" rel="stylesheet">

<style>
    #button {
        width: 200px;
    }

    #thead {
        text-align: center;
    }

    #myTable tbody td {
        text-align: center;
        /* Mengatur teks ke tengah */
        vertical-align: middle;
        /* Memastikan teks berada di tengah secara vertikal */
    }

    table.table th,
    table.table td {
        min-width: 150px;
    }

    table.table th:first-child,
    table.table td:first-child {
        min-width: 50px;
        /* Lebar untuk kolom No */
    }
</style>

<div class="container">
    <div class="card mt-2">
        <div class="card-header text-center">
            <h3>Data Nilai Siswa</h3>
        </div>
        <div class="card-body">
            <div class="row justify-content-between">
                <div class="col-5">
                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#importExcelModal" id="button">
                        Import
                    </button>
                    <a href="export-nilai-siswa" class="btn btn-light mb-3" id="button">Export</a>
                </div>
                <div class="col-4 text-end">
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" id="button">
                        Hapus Semua Data
                    </button>
                </div>
            </div>

            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Terjadi kesalahan!</strong>
                <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ session('error') }}</strong>
                <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif


            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session('success') }}</strong>
                <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div style="overflow-x: auto; white-space: nowrap;">
                <table class="table table-bordered table-hover" id="myTable">
                    <thead class="text-center">
                        <th id="thead">No.</th>
                        <th id="thead">Semester</th>
                        <th id="thead">Tahun Ajar</th>
                        <th id="thead">NIS</th>
                        <th id="thead">Kelas</th>
                        <th id="thead">Nama Siswa</th>
                        <th id="thead">Agama</th>
                        <th id="thead">PKN</th>
                        <th id="thead">Bahasa Indonesia</th>
                        <th id="thead">Matematika</th>
                        <th id="thead">IPA</th>
                        <th id="thead">IPS</th>
                        <th id="thead">Bahasa Inggris</th>
                        <th id="thead">Seni Budaya</th>
                        <th id="thead">PJOK</th>
                        <th id="thead">Prakarya</th>
                        <th id="thead">TIK</th>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($nilaisiswa as $index => $n)
                        <tr>
                            <!-- <td>{{ $loop->iteration }}</td> -->
                            <td>{{ $n->idnilai }}</td>
                            <td>{{ $n->semester }}</td>
                            <td>{{ substr($n->tahunajar, 0, 4) . ' / ' . substr($n->tahunajar, 4) }}</td>
                            <td>{{ $n->nis }}</td>
                            <td>{{ $n->kelas }}</td>
                            <td>{{ $n->nama_siswa }}</td>
                            <td>{{ $n->nagama }}</td>
                            <td>{{ $n->npkn }}</td>
                            <td>{{ $n->nbindo }}</td>
                            <td>{{ $n->nmatematika }}</td>
                            <td>{{ $n->nipa }}</td>
                            <td>{{ $n->nips }}</td>
                            <td>{{ $n->nbinggris }}</td>
                            <td>{{ $n->nsenibudaya }}</td>
                            <td>{{ $n->npjok }}</td>
                            <td>{{ $n->nprakarya }}</td>
                            <td>{{ $n->ntik }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Delete Data Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Yakin ingin menghapus semua data?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <form action="/delete-nilai-siswa" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div

    <!-- Import Excel Modal -->
<div class="modal fade" id="importExcelModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="importExcelModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importExcelModalLabel">Import Excel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" ariaa-label="Close"></button>
            </div>
            <form action="import-nilai-siswa" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="file">Pilih file Excel :</label>
                        <input type="file" class="form-control" id="file" name="file" accept=".xls,.xlsx" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/jquery/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/data_tables/datatables.min.js') }}"></script>

<script>
    let table = new DataTable('#myTable', {
        scrollX: true
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const importForm = document.querySelector('#importExcelModal form');
        const importButton = importForm.querySelector('button[type="submit"]');

        importForm.addEventListener('submit', function(e) {
            importButton.disabled = true;
            importButton.textContent = "Proses...";
            importButton.insertAdjacentHTML(
                "beforeend",
                " <span class='spinner-border spinner-border-sm'></span>"
            );
        });
    });
</script>

<Script>
    document.addEventListener("DOMContentLoaded", function() {
        const deleteForm = document.querySelector('#confirmDeleteModal form');
        const deleteButton = deleteForm.querySelector('button[type="submit"]');

        deleteForm.addEventListener('submit', function(e) {
            deleteButton.disabled = true;
            deleteButton.textContent = "Proses...";
            deleteButton.insertAdjacentHTML(
                "beforeend",
                " <span class='spinner-border spinner-border-sm'></span>"
            );
        });
    });
</Script>
@endsection