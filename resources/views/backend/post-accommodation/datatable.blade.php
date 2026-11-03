@extends('layouts.backend')
@section('title', 'Manage Accommodations')

@section('content')
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ url('dashboard') }}">Dashboard</a>
            <span class="breadcrumb-item active">Accommodations</span>
        </nav>
    </div>

    <div class="br-pagetitle">
        <i class="icon ion-ios-home-outline"></i>
        <div>
            <h4>Accommodations</h4>
            <p class="mg-b-0">List of Posts & Accommodation Data</p>
        </div>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            @php $cat = \App\Models\PostCategory::where('seotitle', 'akomodasi')->first(); @endphp
            @if($cat)
            <div class="text-right pd-b-20">
                <a href="{{ url('dashboard/post/create?category_id='.$cat->id) }}" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Post Akomodasi</a>
            </div>
            @endif
            <div class="table-wrapper">
                <table class="table display responsive nowrap" id="post-acc-table">
                    <thead>
                    <tr>
                        <th width="50">Post ID</th>
                        <th>Kategori</th>
                        <th>Judul Post</th>
                        <th>Tipe</th>
                        <th>Status Data</th>
                        <th width="120">Actions</th>
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
            $('#post-acc-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ url("dashboard/post-accommodation/data") }}',
                autoWidth: false,
                order: [[0, 'desc']],
                columns: [
                    {data: 'id', name: 'posts.id'},
                    {data: 'cat_title', name: 'post_categorys.title'},
                    {data: 'title', name: 'posts.title'},
                    {data: 'accommodation_type', name: 'post_accommodations.accommodation_type'},
                    {data: 'status_acc', name: 'status_acc', orderable: false, searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
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
