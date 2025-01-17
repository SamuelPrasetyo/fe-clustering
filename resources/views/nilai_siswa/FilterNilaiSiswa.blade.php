@extends('layouts.app')

@section('title', 'Nilai Siswa')

@section('content')
<!-- <link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css"> -->
<link href="{{ asset('assets/data_tables/datatables.min.css') }}" rel="stylesheet">

<style>
    #myTable thead th,
    #myTable tbody td {
        text-align: center;
        /* Mengatur teks ke tengah */
        vertical-align: middle;
        /* Memastikan teks berada di tengah secara vertikal */
    }

    #button {
        width: 200px;
    }

    table.table th,
    table.table td {
        min-width: 150px;
    }

    #thead {
        text-align: center;
    }

    table.table th:first-child,
    table.table td:first-child {
        min-width: 50px;
        /* Lebar untuk kolom No */
    }
</style>

<div class="container">
    <h1>Data Nilai Siswa</h1>

    <table>
        <tr>
            <td>Tahun Ajar</td>
            <td style="padding: 0 10px;">:</td>
            <td>{{ substr($result[0]->tahunajar, 0, 4) . ' / ' . substr($result[0]->tahunajar, 4) }}</td>
        </tr>
        <tr>
            <td>Semester</td>
            <td style="padding: 0 10px;">:</td>
            <td>{{ $result[0]->semester }}</td>
        </tr>
    </table>

    <form action="{{ route('process-clustering') }}" method="POST" target="_blank">
        @csrf
        <input type="hidden" name="tahunajar" id="tahunajar" value="{{ json_encode($result[0]->tahunajar) }}">
        <input type="hidden" name="semester" id="semester" value="{{ json_encode($result[0]->semester) }}">
        <div class="mt-3 mb-3">
            <div class="d-flex flex-row flex-wrap">
                <div class="card" style="width: 24rem; margin-right: 1rem;">
                    <div class="card-body">
                        <h5 class="card-title">K-Means</h5>
                        <h6 class="card-subtitle mb-2 text-body-secondary">Algoritma K-Means</h6>
                        <p class="card-text">K-Means adalah algoritma clustering yang membagi data ke dalam sejumlah cluster berdasarkan jarak terdekat ke centroid.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <button class="btn btn-link" type="submit" name="algoritma" value="elbow-method">Elbow Method</button>
                            <button class="btn btn-primary" type="button" name="algoritma" value="kmeans" data-bs-toggle="modal" data-bs-target="#inputKModal">Proses K-Means</button>
                        </div>
                    </div>
                </div>
                <div class="card" style="width: 24rem; margin-right: 1rem;">
                    <div class="card-body">
                        <h5 class="card-title">DBSCAN</h5>
                        <h6 class="card-subtitle mb-2 text-body-secondary">Algoritma DBSCAN</h6>
                        <p class="card-text">DBSCAN adalah algoritma clustering berbasis kepadatan yang mampu mengidentifikasi noise dan cluster dengan bentuk tidak beraturan.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <button class="btn btn-link" type="submit" name="algoritma" value="kdgraph">K-Distance Graph</button>
                            <button class="btn btn-primary" type="button" name="algoritma" value="dbscan" data-bs-toggle="modal" data-bs-target="#inputHyperModal">Proses DBSCAN</button>
                        </div>
                    </div>
                </div>
                <div class="card" style="width: 24rem; margin-right: 1rem;">
                    <div class="card-body">
                        <h5 class="card-title">Agglomerative</h5>
                        <h6 class="card-subtitle mb-2 text-body-secondary">Algoritma Agglomerative</h6>
                        <p class="card-text">Agglomerative adalah algoritma hierarchical clustering yang menggabungkan data secara bertahap berdasarkan kedekatan hingga membentuk satu cluster besar.</p>
                        <div class="d-flex flex-row-reverse">
                            <button class="btn btn-success" type="submit" name="algoritma" value="agglomerative">Proses Agglomerative</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </form>

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
            <th id="thead">B.Indonesia</th>
            <th id="thead">Matematika</th>
            <th id="thead">IPA</th>
            <th id="thead">IPS</th>
            <th id="thead">B.Inggris</th>
            <th id="thead">Seni Budaya</th>
            <th id="thead">PJOK</th>
            <th id="thead">Prakarya</th>
            <th id="thead">TIK</th>
        </thead>
        <tbody class="text-center">
            @foreach ($result as $index => $n)
            <tr>
                <td>{{ $loop->iteration }}</td>
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



<!-- Input Jumlah K Modal (K-Means) -->
<div class="modal fade" id="inputKModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="inputKModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inputKModalLabel">Input Jumlah K</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('process-clustering') }}" method="POST" target="_blank">
                @csrf
                <input type="hidden" name="tahunajar" id="modal-tahunajar">
                <input type="hidden" name="semester" id="modal-semester">

                <div class="modal-body">
                    <div class="form-group">
                        <label for="file">Input Jumlah K :</label>
                        <input type="number" name="jumlah_k" class="form-control" min="2" max="10" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" name="algoritma" value="kmeans">Proses</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Input Eps dan Min Pts Modal (DBSCAN) -->
<div class="modal fade" id="inputHyperModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="inputHyperModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inputHyperModalLabel">Input Eps dan Min Pts</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('process-clustering') }}" method="POST" target="_blank">
                @csrf
                <input type="hidden" name="tahunajar" id="modal-tahunajar">
                <input type="hidden" name="semester" id="modal-semester">

                <div class="modal-body">
                    <div class="form-group">
                        <label for="file">Input Nilai Eps :</label>
                        <input type="number" name="eps" class="form-control" min="1" maxlength="2" step="0.5" required>
                    </div>
                    <div class="form-group" style="margin-top: 2%;">
                        <label for="file">Input Min. Samples :</label>
                        <input type="number" name="min_pts" class="form-control" min="2" maxlength="2" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" name="algoritma" value="dbscan">Proses</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script> -->
<!-- <script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script> -->

<script src="{{ asset('assets/jquery/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/data_tables/datatables.min.js') }}"></script>

<script>
    let table = new DataTable('#myTable', {
        scrollX: true
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const populateModalInputs = (modalId) => {
            const modal = document.getElementById(modalId);

            modal.addEventListener('show.bs.modal', () => {
                const tahunajar = document.getElementById('tahunajar').value;
                const semester = document.getElementById('semester').value;

                modal.querySelector('#modal-tahunajar').value = tahunajar;
                modal.querySelector('#modal-semester').value = semester;
            });
        };

        populateModalInputs('inputKModal');
        populateModalInputs('inputHyperModal');
    });
</script>
@endsection