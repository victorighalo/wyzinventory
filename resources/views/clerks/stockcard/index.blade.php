@extends('layouts.main')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">

        <div class="row justify-content-center flex-grow mb-5 mt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Stock form for <span class="font-weight-bold"> {{$product->name}}</span>
                            <a class="btn btn-link float-right" data-toggle="collapse" href="#form_collapse" role="button" aria-expanded="false" aria-controls="collapseExample">
                                <i class="fas fa-ellipsis-v"></i>
                            </a></h4>
                        <p class="card-description">
                            Fill the form below to add a stock record
                        </p>
                        <div class="collapse" id="form_collapse">
                            <form id="create_super_agent">
                                @csrf
                                <input type="hidden" name="product_id" value="{{$product->id}}">
                                <div class="row form-group">
                                    <div class="col-sm-4">
                                        <label for="description">{{ __('Description') }}</label>
                                        <input type="text" id="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" value="{{ old('description') }}" required autofocus>
                                        @if ($errors->has('description'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                        @endif
                                        <span class="invalid-feedback errorshow" role="alert">
                                        </span>
                                    </div>

                                    <div class="col-sm-2">
                                        <label for="qtyreceived">{{ __('Qty Received In') }}</label>
                                        <input type="number" id="qtyreceived" class="form-control" name="qtyreceived" value="0" required>
                                        @if ($errors->has('qtyreceived'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('qtyreceived') }}</strong>
                                    </span>
                                        @endif
                                        <span class="invalid-feedback errorshow" role="alert">
                                        </span>
                                    </div>

                                    <div class="col-sm-2">
                                        <label for="qtyout">{{ __('Qty Issued Out') }}</label>
                                        <input type="number" id="qtyout" class="form-control" name="qtyout" value="0" required>
                                        @if ($errors->has('qtyout'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('qtyout') }}</strong>
                                    </span>
                                        @endif
                                        <span class="invalid-feedback errorshow" role="alert">
                                        </span>
                                    </div>

                                    <div class="col-sm-2">
                                        <label for="invoiceno">{{ __('Invoice no') }}</label>
                                        <input type="number" id="invoiceno" class="form-control" name="invoiceno" required>
                                        @if ($errors->has('invoiceno'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('invoiceno') }}</strong>
                                    </span>
                                        @endif
                                        <span class="invalid-feedback errorshow" role="alert">
                                        </span>
                                    </div>

                                    <div class="col-sm-2">
                                        <label for="bacthno">{{ __('Bacth no') }}</label>
                                        <input type="number" id="bacthno" class="form-control" name="bacthno" required>
                                        @if ($errors->has('bacthno'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('bacthno') }}</strong>
                                    </span>
                                        @endif
                                        <span class="invalid-feedback errorshow" role="alert">
                                        </span>
                                    </div>
                                </div>


                                <div class="row form-group">
                                    <div class="col-sm-3">
                                        <label for="mfd_date">{{ __('MFD date') }}</label>
                                        <input type="date" id="mfd_date" class="form-control" name="mfd_date">
                                        @if ($errors->has('mfd_date'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('mfd_date') }}</strong>
                                    </span>
                                        @endif
                                        <span class="invalid-feedback errorshow" role="alert">
                                        </span>
                                    </div>

                                    <div class="col-sm-3">
                                        <label for="exp_date">{{ __('EXP date') }}</label>
                                        <input type="date" id="exp_date" class="form-control" name="exp_date">
                                        @if ($errors->has('exp_date'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('exp_date') }}</strong>
                                    </span>
                                        @endif
                                        <span class="invalid-feedback errorshow" role="alert">
                                        </span>
                                    </div>

                                    <div class="col-sm-6">
                                        <label for="remark">{{ __('Remark') }}</label>
                                        <input type="text" id="remark" class="form-control" name="remark">
                                        @if ($errors->has('remark'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('remark') }}</strong>
                                    </span>
                                        @endif
                                        <span class="invalid-feedback errorshow" role="alert">
                                        </span>
                                    </div>

                                </div>



                                <div class="mt-5">
                                    <button class="btn float-right btn-warning btn-lg font-weight-medium submitformbtn" type="submit">
                                        <i class="fas fa-spinner fa-spin off process_indicator"></i>
                                        <span>{{ __('Add') }}</span>
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <div class="row">
            <div class="col-12 grid-margin mt-5">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Stock card for <span class="font-weight-bold"> {{$product->name}}</span></h5>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="users-table">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Qty Received</th>
                                    <th>Qty Issued Out</th>
                                    <th>Current balance</th>
                                    <th>Invoice no</th>
                                    <th>Bacth no</th>
                                    <th>MFD date</th>
                                    <th>EXP date</th>
                                    <th>Remark</th>

                                </tr>
                                </thead>
                            </table>
                        </div>
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
    var product_id = "<?php  $linkcount = count(explode('/',url()->current())); echo explode('/',url()->current())[$linkcount-2] ?>"
    $(document).ready(function () {
        $("form#create_super_agent").on('submit', function (e) {
            e.preventDefault();
            disableItem($(".submitformbtn"), true)
            $(".submitformbtn > .process_indicator").removeClass('off');
            $("span.errorshow").html("")
            $.ajax({
                type: "POST",
                url: baseurl+'product/stock/create',
                data: $(this).serialize()
            }).done(function (data) {
                superagentstable.ajax.reload();
                disableItem($(".submitformbtn"), false)
                $(".submitformbtn > .process_indicator").addClass('off');
                new PNotify({
                    title: 'Success!',
                    text: 'Stock record created.',
                    type: 'success'
                });
            }).fail(function (response) {
                disableItem($(".submitformbtn"), false)
                $(".submitformbtn > .process_indicator").addClass('off');
                if (response.status == 500) {
                    new PNotify({
                        title: 'Oops!',
                        text: 'An Error Occurred. Please try again.',
                        type: 'error'
                    });
                }
                if (response.status == 400) {
                    $.each(response.responseJSON.message, function (key, item) {
                        $("input[name="+key+"] + span.errorshow").html(item[0])
                        $("input[name="+key+"] + span.errorshow").slideDown("slow")
                    });
                    new PNotify({
                        title: 'Oops!',
                        text: 'Form validation error.',
                        type: 'error'
                    });
                }
                else {
                    new PNotify({
                        title: 'Oops!',
                        text: 'An Error Occurred. Please try again.',
                        type: 'error'
                    });
                }
            })
        });
    });

    var superagentstable = $('#users-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{!! route('product_stock_data') !!}/'+product_id,
    columns: [
    { data: 'created_at', name: 'created_at' },
    { data: 'description', name: 'description' },
    { data: 'qtyreceived', name: 'qtyreceived' },
    { data: 'qtyout', name: 'qtyout' },
    { data: 'currentbalance', name: 'currentbalance' },
    { data: 'invoiceno', name: 'invoiceno' },
    { data: 'bacthno', name: 'bacthno' },
    { data: 'mfd_date', name: 'mfd_date' },
    { data: 'exp_date', name: 'exp_date' },
    { data: 'remark', name: 'remark' }
    ]
    });


    // function deactivate (id) {
    //     PNotify.removeAll();
    //
    //     new PNotify({
    //         title: 'Confirm Deactivation',
    //         text: 'Are you sure?',
    //         icon: 'glyphicon glyphicon-question-sign',
    //         hide: false,
    //         confirm: {
    //             confirm: true,
    //             buttons: [{
    //                 text: 'Deactivate',
    //                 addClass: 'btn-primary',
    //                 click: function(notice) {
    //                     $.ajax({
    //                         type: "GET",
    //                         url: baseurl+'products/deactivate/'+id,
    //                     }).done(function (data) {
    //                         notice.update({
    //                             title: 'Product deactivated',
    //                             text: 'Deactivation successful.',
    //                             icon: true,
    //                             type: 'success',
    //                             hide: true,
    //                             confirm: {
    //                                 confirm: false
    //                             },
    //                             buttons: {
    //                                 closer: true,
    //                                 sticker: true
    //                             }
    //                         });
    //                         superagentstable.ajax.reload();
    //                     }).fail(function (response) {
    //                         PNotify.removeAll();
    //                         if (response.status == 500) {
    //                             new PNotify({
    //                                 title: 'Oops!',
    //                                 text: 'An Error Occurred. Please try again.',
    //                                 type: 'error'
    //                             });
    //                             return false
    //                         }
    //                         if (response.status == 400) {
    //                             new PNotify({
    //                                 title: 'Oops!',
    //                                 text: 'Failed to deactivate Super Agent.',
    //                                 type: 'error'
    //                             });
    //                             return false
    //                         }
    //                         else {
    //                             new PNotify({
    //                                 title: 'Oops!',
    //                                 text: 'An Error Occurred. Please try again.',
    //                                 type: 'error'
    //                             });
    //                             return false
    //                         }
    //                     })
    //                 }
    //             },
    //                 {
    //                     text: 'Cancel',
    //                     addClass: 'btn-primary',
    //                     click: function(notice) {
    //                         notice.update({
    //                             title: 'Action Cancelled',
    //                             text: 'That was close...',
    //                             icon: true,
    //                             type: 'danger',
    //                             hide: true,
    //                             confirm: {
    //                                 confirm: false
    //                             },
    //                             buttons: {
    //                                 closer: true,
    //                                 sticker: true
    //                             }
    //                         });
    //                     }
    //                 }]
    //         },
    //         buttons: {
    //             closer: true,
    //             sticker: true
    //         },
    //         history: {
    //             history: false
    //         }
    //     })
    // };
    //
    // function activate (id) {
    //     (new PNotify({
    //         title: 'Confirm Activation',
    //         text: 'Are you sure?',
    //         icon: 'glyphicon glyphicon-question-sign',
    //         hide: false,
    //         confirm: {
    //             confirm: true,
    //             buttons: [{
    //                 text: 'Activate',
    //                 addClass: 'btn-primary',
    //                 click: function(notice) {
    //                     $.ajax({
    //                         type: "GET",
    //                         url: baseurl+'products/activate/'+id,
    //                     }).done(function (data) {
    //                         superagentstable.ajax.reload();
    //                         notice.update({
    //                             title: 'Product Activated',
    //                             text: 'Activation successful.',
    //                             icon: true,
    //                             type: 'success',
    //                             hide: true,
    //                             confirm: {
    //                                 confirm: false
    //                             },
    //                             buttons: {
    //                                 closer: true,
    //                                 sticker: true
    //                             }
    //                         });
    //                     }).fail(function (response) {
    //                         superagentstable.ajax.reload();
    //                         PNotify.removeAll();
    //                         if (response.status == 500) {
    //                             new PNotify({
    //                                 title: 'Oops!',
    //                                 text: 'An Error Occurred. Please try again.',
    //                                 type: 'error'
    //                             });
    //                             return false
    //                         }
    //                         if (response.status == 400) {
    //                             new PNotify({
    //                                 title: 'Oops!',
    //                                 text: 'Failed to activate Super Agent.',
    //                                 type: 'error'
    //                             });
    //                             return false
    //                         }
    //                         else {
    //                             new PNotify({
    //                                 title: 'Oops!',
    //                                 text: 'An Error Occurred. Please try again.',
    //                                 type: 'error'
    //                             });
    //                             return false
    //                         }
    //                     })
    //                 }
    //             },
    //                 {
    //                     text: 'Cancel',
    //                     addClass: 'btn-primary',
    //                     click: function(notice) {
    //                         notice.update({
    //                             title: 'Action Cancelled',
    //                             text: 'That was close...',
    //                             icon: true,
    //                             type: 'danger',
    //                             hide: true,
    //                             confirm: {
    //                                 confirm: false
    //                             },
    //                             buttons: {
    //                                 closer: true,
    //                                 sticker: true
    //                             }
    //                         });
    //                     }
    //                 }]
    //         },
    //         buttons: {
    //             closer: true,
    //             sticker: true
    //         },
    //         history: {
    //             history: false
    //         }
    //     }))
    // };
    //
    // function remove (id){
    //     (new PNotify({
    //         title: 'Confirm Delete',
    //         text: 'Are you sure?',
    //         icon: 'glyphicon glyphicon-question-sign',
    //         hide: false,
    //         confirm: {
    //             confirm: true,
    //             buttons: [{
    //                 text: 'Delete',
    //                 addClass: 'btn-primary',
    //                 click: function(notice) {
    //                     $.ajax({
    //                         type: "GET",
    //                         url: baseurl+'products/delete/'+id,
    //                         data: $(this).serialize()
    //                     }).done(function (data) {
    //                         superagentstable.ajax.reload();
    //                         notice.update({
    //                             title: 'Product Deleted',
    //                             text: data,
    //                             icon: true,
    //                             type: 'success',
    //                             hide: true,
    //                             confirm: {
    //                                 confirm: false
    //                             },
    //                             buttons: {
    //                                 closer: true,
    //                                 sticker: true
    //                             }
    //                         });
    //                     }).fail(function (response) {
    //                         if (response.status == 500) {
    //                             new PNotify({
    //                                 title: 'Oops!',
    //                                 text: 'An Error Occurred. Please try again.',
    //                                 type: 'error'
    //                             });
    //                         }
    //                         if (response.status == 400) {
    //                             new PNotify({
    //                                 title: 'Oops!',
    //                                 text: 'Failed to delete Super Agent.',
    //                                 type: 'error'
    //                             });
    //                         }
    //                         else {
    //                             new PNotify({
    //                                 title: 'Oops!',
    //                                 text: 'An Error Occurred. Please try again.',
    //                                 type: 'error'
    //                             });
    //                         }
    //                     })
    //
    //                 }
    //             },
    //                 {
    //                     text: 'Cancel',
    //                     addClass: 'btn-primary',
    //                     click: function(notice) {
    //                         notice.update({
    //                             title: 'Action Cancelled',
    //                             text: 'That was close...',
    //                             icon: true,
    //                             type: 'danger',
    //                             hide: true,
    //                             confirm: {
    //                                 confirm: false
    //                             },
    //                             buttons: {
    //                                 closer: true,
    //                                 sticker: true
    //                             }
    //                         });
    //                     }
    //                 }]
    //         },
    //         buttons: {
    //             closer: true,
    //             sticker: true
    //         },
    //         history: {
    //             history: false
    //         }
    //     }))
    // };
</script>
@endpush
