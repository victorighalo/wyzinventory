@extends('layouts.main')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">

            <div class="row">
                <div class="col-12 grid-margin mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Stock records for <span class="font-weight-bold">{{$data->firstname}}</span></h5>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="users-table">
                                    <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Product</th>
                                        <th>Description</th>
                                        <th>Qty Received</th>
                                        <th>Qty Issued Out</th>
                                        <th>Current balance</th>
                                        <th>Invoice no</th>
                                        <th>Bacth no</th>
                                        <th>MFD date</th>
                                        <th>EXP date</th>
                                        <th>Remark</th>
                                        <th>Audit</th>
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
    <div class="modal fade" id="emodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit card</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form name="editcardform">
                    <div class="modal-body">

                        <input type="hidden" name="product_id">
                        <input type="hidden" name="card_id">
                        <input type="hidden" name="user_id">
                        <div class="row form-group">
                            <div class="col-sm-12">
                                <label for="">Description</label>
                                <input type="text" name="edit_description" value="" class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-3">
                                <label for="">Qty Received</label>
                                <input type="number" name="edit_qtyreceived" min="0" value="" class="form-control">
                            </div>
                            <div class="col-sm-3">
                                <label for="">Qty Issued Out</label>
                                <input type="number" name="edit_qtyout" value="" min="0" class="form-control">
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

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary update_card"><i class="fas fa-spinner fa-spin off process_indicator"></i> Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('script')
    {{--<script src="{{asset('js/dataTables.buttons.min.js')}}"></script>--}}
    {{--<script type="text/javascript" src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js"></script>--}}

    <script>
        var baseurl = "<?php echo config('app.url') ?>"
        var stateid;
        var user_id = "<?php  $linkcount = count(explode('/',url()->current())); echo explode('/',url()->current())[$linkcount-1] ?>"

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#users-table').on( 'draw.dt', function () {
            $('.editcard').on('click', function (e) {
                // console.log($(this).data('user_id'))
                $('#emodal').modal()
                $("input[name='card_id']").val($(this).attr('id'))
                $("input[name='user_id']").val($(this).data('user_id'))
                $("input[name='product_id']").val($(this).data('product_id'))
                $.each($(this).parent().parent().children(), function(index, item){
                    // console.log(index, item)
                    if(index == 2){
                        $("input[name='edit_description']").val(item.innerText).html(item.innerText)
                    }if(index == 3){
                        $("input[name='edit_qtyreceived']").val(item.innerText).html(item.innerText)
                    }if(index == 4){
                        $("input[name='edit_qtyout']").val(item.innerText).html(item.innerText)
                    }if(index == 6){
                        $("input[name='edit_invoiceno']").val(item.innerText).html(item.innerText)
                    }if(index == 7){
                        $("input[name='edit_bacthno']").val(item.innerText).html(item.innerText)
                    }if(index == 8){
                        $("input[name='edit_mfd_date']").val(item.innerText).html(item.innerText)
                    }if(index == 9){
                        $("input[name='edit_exp_date']").val(item.innerText).html(item.innerText)
                    }if(index == 10){
                        $("input[name='edit_remark']").val(item.innerText).html(item.innerText)
                    }
                })
            });

        })

        $(document).ready(function () {
            $("form[name='editcardform']").on('submit', function (e) {
                e.preventDefault()
                var formdata = $("form[name='editcardform']").serialize();

                disableItem($(".update_card"), true)
                $(".update_card > .process_indicator").removeClass('off');
                $.ajax({
                    type: "POST",
                    url: baseurl+'product/stock/update',
                    data: formdata
                }).done(function (data) {
                    $('#emodal').modal('hide')
                    disableItem($(".update_card"), false)
                    $(".update_card > .process_indicator").addClass('off');
                    superagentstable.ajax.reload();
                    new PNotify({
                        title: 'Success!',
                        text: 'Stock record updated.',
                        type: 'success'
                    });
                }).fail(function (response) {
                    $('#emodal').modal('hide')
                    disableItem($(".update_card"), false)
                    $(".update_card > .process_indicator").addClass('off');
                    $(".submitformbtn > .process_indicator").addClass('off');
                    if (response.status == 500) {
                        new PNotify({
                            title: 'Oops!',
                            text: 'An Error Occurred. Please try again.',
                            type: 'error'
                        });
                        return false;
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
                        return false;
                    }
                    else {
                        new PNotify({
                            title: 'Oops!',
                            text: 'An Error Occurred. Please try again.',
                            type: 'error'
                        });
                        return false
                    }
                })
            });

        });

        $(document).ready(function () {
            $("form#create_super_agent").on('submit', function (e) {
                e.preventDefault();
                disableItem($(".submitformbtn"), true)
                $(".submitformbtn > .process_indicator").removeClass('off');
                $("span.errorshow").html("")
                $.ajax({
                    type: "POST",
                    url: baseurl+'products/create',
                    data: $(this).serialize()
                }).done(function (data) {
                    superagentstable.ajax.reload();
                    disableItem($(".submitformbtn"), false)
                    $(".submitformbtn > .process_indicator").addClass('off');
                    new PNotify({
                        title: 'Success!',
                        text: 'Product created.',
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
            ajax: '{!! route('get_storekeepers_stock_data_audit') !!}/'+user_id,
            columns: [
                { data: 'created_at', name: 'created_at' },
                { data: 'productname', name: 'productname' },
                { data: 'description', name: 'description' },
                { data: 'qtyreceived', name: 'qtyreceived' },
                { data: 'qtyout', name: 'qtyout' },
                { data: 'currentbalance', name: 'currentbalance' },
                { data: 'invoiceno', name: 'invoiceno' },
                { data: 'bacthno', name: 'bacthno' },
                { data: 'mfd_date', name: 'mfd_date' },
                { data: 'exp_date', name: 'exp_date' },
                { data: 'remark', name: 'remark' },
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            "dom": 'lBrtip',
            "buttons": [
                {
                    extend: 'collection',
                    text: 'Export',
                    buttons: [
                        'copy',
                        'excel'
                    ]
                }
            ]
        });


        function deactivate (id) {
            PNotify.removeAll();

            new PNotify({
                title: 'Confirm Deactivation',
                text: 'Are you sure?',
                icon: 'glyphicon glyphicon-question-sign',
                hide: false,
                confirm: {
                    confirm: true,
                    buttons: [{
                        text: 'Deactivate',
                        addClass: 'btn-primary',
                        click: function(notice) {
                            $.ajax({
                                type: "GET",
                                url: baseurl+'products/deactivate/'+id,
                            }).done(function (data) {
                                notice.update({
                                    title: 'Product deactivated',
                                    text: 'Deactivation successful.',
                                    icon: true,
                                    type: 'success',
                                    hide: true,
                                    confirm: {
                                        confirm: false
                                    },
                                    buttons: {
                                        closer: true,
                                        sticker: true
                                    }
                                });
                                superagentstable.ajax.reload();
                            }).fail(function (response) {
                                PNotify.removeAll();
                                if (response.status == 500) {
                                    new PNotify({
                                        title: 'Oops!',
                                        text: 'An Error Occurred. Please try again.',
                                        type: 'error'
                                    });
                                    return false
                                }
                                if (response.status == 400) {
                                    new PNotify({
                                        title: 'Oops!',
                                        text: 'Failed to deactivate Super Agent.',
                                        type: 'error'
                                    });
                                    return false
                                }
                                else {
                                    new PNotify({
                                        title: 'Oops!',
                                        text: 'An Error Occurred. Please try again.',
                                        type: 'error'
                                    });
                                    return false
                                }
                            })
                        }
                    },
                        {
                            text: 'Cancel',
                            addClass: 'btn-primary',
                            click: function(notice) {
                                notice.update({
                                    title: 'Action Cancelled',
                                    text: 'That was close...',
                                    icon: true,
                                    type: 'danger',
                                    hide: true,
                                    confirm: {
                                        confirm: false
                                    },
                                    buttons: {
                                        closer: true,
                                        sticker: true
                                    }
                                });
                            }
                        }]
                },
                buttons: {
                    closer: true,
                    sticker: true
                },
                history: {
                    history: false
                }
            })
        };

        function activate (id) {
            (new PNotify({
                title: 'Confirm Activation',
                text: 'Are you sure?',
                icon: 'glyphicon glyphicon-question-sign',
                hide: false,
                confirm: {
                    confirm: true,
                    buttons: [{
                        text: 'Activate',
                        addClass: 'btn-primary',
                        click: function(notice) {
                            $.ajax({
                                type: "GET",
                                url: baseurl+'products/activate/'+id,
                            }).done(function (data) {
                                superagentstable.ajax.reload();
                                notice.update({
                                    title: 'Product Activated',
                                    text: 'Activation successful.',
                                    icon: true,
                                    type: 'success',
                                    hide: true,
                                    confirm: {
                                        confirm: false
                                    },
                                    buttons: {
                                        closer: true,
                                        sticker: true
                                    }
                                });
                            }).fail(function (response) {
                                superagentstable.ajax.reload();
                                PNotify.removeAll();
                                if (response.status == 500) {
                                    new PNotify({
                                        title: 'Oops!',
                                        text: 'An Error Occurred. Please try again.',
                                        type: 'error'
                                    });
                                    return false
                                }
                                if (response.status == 400) {
                                    new PNotify({
                                        title: 'Oops!',
                                        text: 'Failed to activate Super Agent.',
                                        type: 'error'
                                    });
                                    return false
                                }
                                else {
                                    new PNotify({
                                        title: 'Oops!',
                                        text: 'An Error Occurred. Please try again.',
                                        type: 'error'
                                    });
                                    return false
                                }
                            })
                        }
                    },
                        {
                            text: 'Cancel',
                            addClass: 'btn-primary',
                            click: function(notice) {
                                notice.update({
                                    title: 'Action Cancelled',
                                    text: 'That was close...',
                                    icon: true,
                                    type: 'danger',
                                    hide: true,
                                    confirm: {
                                        confirm: false
                                    },
                                    buttons: {
                                        closer: true,
                                        sticker: true
                                    }
                                });
                            }
                        }]
                },
                buttons: {
                    closer: true,
                    sticker: true
                },
                history: {
                    history: false
                }
            }))
        };

        function remove (id){
            (new PNotify({
                title: 'Confirm Delete',
                text: 'Are you sure?',
                icon: 'glyphicon glyphicon-question-sign',
                hide: false,
                confirm: {
                    confirm: true,
                    buttons: [{
                        text: 'Delete',
                        addClass: 'btn-primary',
                        click: function(notice) {
                            $.ajax({
                                type: "GET",
                                url: baseurl+'products/delete/'+id,
                                data: $(this).serialize()
                            }).done(function (data) {
                                superagentstable.ajax.reload();
                                notice.update({
                                    title: 'Product Deleted',
                                    text: data,
                                    icon: true,
                                    type: 'success',
                                    hide: true,
                                    confirm: {
                                        confirm: false
                                    },
                                    buttons: {
                                        closer: true,
                                        sticker: true
                                    }
                                });
                            }).fail(function (response) {
                                if (response.status == 500) {
                                    new PNotify({
                                        title: 'Oops!',
                                        text: 'An Error Occurred. Please try again.',
                                        type: 'error'
                                    });
                                }
                                if (response.status == 400) {
                                    new PNotify({
                                        title: 'Oops!',
                                        text: 'Failed to delete Super Agent.',
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

                        }
                    },
                        {
                            text: 'Cancel',
                            addClass: 'btn-primary',
                            click: function(notice) {
                                notice.update({
                                    title: 'Action Cancelled',
                                    text: 'That was close...',
                                    icon: true,
                                    type: 'danger',
                                    hide: true,
                                    confirm: {
                                        confirm: false
                                    },
                                    buttons: {
                                        closer: true,
                                        sticker: true
                                    }
                                });
                            }
                        }]
                },
                buttons: {
                    closer: true,
                    sticker: true
                },
                history: {
                    history: false
                }
            }))
        };
    </script>
@endpush