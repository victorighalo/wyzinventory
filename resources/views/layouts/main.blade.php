<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>
    <!-- Styles -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/buttons.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/iziModal.min.css') }}" rel="stylesheet">
    <style>
        .navbar .navbar-brand-wrapper .navbar-brand img {
            width: calc(255px - 30px);
            height: 48px;
        }
        .navbar .navbar-brand-wrapper{
            background: transparent;
        }
    </style>
    @stack('style')
</head>
<body>
<div id="app">
    <div class="modal fade" id="emodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit card</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form name="editcardform">
                        <input type="hidden" name="product_id">
                        <div class="row form-group">
                            <div class="col-sm-12">
                                <label for="">Description</label>
                                <input type="text" name="edit_description" value="" class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label for="">Qty Received</label>
                                <input type="number" name="edit_qtyreceived" value="" class="form-control">
                            </div>
                            <div class="col-sm-3">
                                <label for="">Qty Issued Out</label>
                                <input type="number" name="edit_qtyout" value="" class="form-control">
                            </div>
                            <div class="col-sm-3">
                                <label for="">Invoice no</label>
                                <input type="number" name="edit_invoiceno" value="" class="form-control">
                            </div>
                            <div class="col-sm-3">
                                <label for="">Bacth no</label>
                                <input type="number" name="edit_bacthno" value="" class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-6">
                                <label for="">Exp date</label>
                                <input type="date" value="" name="edit_mfd_date" class="form-control">
                            </div>
                            <div class="col-sm-6">
                                <label for="">MFD date</label>
                                <input type="date" value="" name="edit_exp_date" class="form-control">
                            </div>
                            <div class="col-sm-12 mt-3">
                                <label for="">Remark</label>
                                <input type="text" value="" name="edit_remark" class="form-control">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary update_card"><i class="fas fa-spinner fa-spin off process_indicator"></i> Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
@include('partials.topnav')
        <!-- partial -->
        <div class="page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            @include('partials.sidebar')

        @yield('content')
</div>
</div>
</div>

<!-- Scripts -->



<script src="{{ asset('js/vendors/jquery-3.3.1.min.js') }}" ></script>
<script src="{{ asset('js/app.js') }}" ></script>
<script src="{{ asset('js/bootstrap.min.js') }}" ></script>
<script src="{{ asset('js/iziModal.min.js') }}" ></script>

{{--<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" ></script>--}}

@stack('script')
</body>
</html>
