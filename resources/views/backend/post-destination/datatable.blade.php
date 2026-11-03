@extends('layouts.backend')
@section('title', 'Manage Destinations')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <span class="breadcrumb-item active">Destinations</span>
        </nav>
    </div>

    <div class="br-pagetitle">
        <i class="icon ion-ios-location-outline"></i>
        <div>
            <h4>Destinations</h4>
            <p class="mg-b-0">List of Tourism Posts & Destination Data</p>
        </div>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            @php $cat = \App\Models\PostCategory::where('seotitle', 'pariwisata')->first(); @endphp
            @if($cat)
            <div class="text-right pd-b-20">
                <a href="{{ url('dashboard/post/create?category_id='.$cat->id) }}" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Post Destinasi</a>
            </div>
            @endif
            <div class="table-wrapper">
                <table class="table display responsive nowrap" id="post-dest-table">
                    <thead>
                    <tr>
                        <th width="50">Post ID</th>
                        <th>Kategori</th>
                        <th>Judul Post</th>
                        <th>Kota</th>
                        <th>Status Destinasi</th>
                        <th width="120">Actions</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(function () {
            $('#post-dest-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ url("dashboard/post-destination/data") }}',
                autoWidth: false,
                order: [[0, 'desc']],
                columns: [
                    {data: 'id', name: 'posts.id'},
                    {data: 'cat_title', name: 'post_categorys.title'},
                    {data: 'title', name: 'posts.title'},
                    {data: 'city', name: 'post_destinations.city'},
                    {data: 'status_dest', name: 'status_dest', orderable: false, searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                    {data: 'id', name: 'posts.id', visible: false}
                ],
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_ items/page',
                }
            });
        });
    </script>
@endpush
