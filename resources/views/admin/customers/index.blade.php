@extends('layouts.main')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Customers</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="users-table">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Active</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Setting</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    </div>
        </div>
        @include('partials.footer')
    </div>
@endsection
@push('script')
        <script>
            var baseurl = "<?php echo config('app.url') ?>"
            var stateid;

            $(document).ready(function () {


            });

            var superagentstable = $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('get_customers') !!}',
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'active', name: 'active' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'updated_at', name: 'updated_at' },
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
            </script>

        @endpush