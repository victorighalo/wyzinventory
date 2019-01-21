@extends('layouts.main')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">

            <div class="row">
                <div class="col-12 grid-margin mt-5">

                        <div class="row">
                            <h2 class="text-center">
                               </h2>
                            <div class="col-md-12">
                                <div class="bd-example" data-example-id="">
                                    <div id="accordion" role="tablist" aria-multiselectable="true">
                                        @foreach($data as $index => $item)
                                        <div class="card">
                                            <div class="card-header" role="tab" id="headingTwo">
                                                <div class="mb-0">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="collapsed">
                                                        <h4>Action: <span class="font-weight-bold">{{ucfirst($item['event'])}}</span></h4>
                                                        <p>Date: <span class="font-weight-bold">{{$item['created_at']}}</span></p>
                                                    </a>
                                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                            <div id="collapseTwo" class="collapse" role="tabpanel">
                                                <div class="card-block">
                                                    <h5>Former</h5>
                                                    <table class="table table-sm ">
                                                        <thead>
                                                        <tr>
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
                                                   <tbody>
                                                   @foreach($item['old_values'] as $old_value)
                                                   <tr>
                                                       <td>{{$old_value['description']}}</td>
                                                       <td>{{$old_value['qtyreceived']}}</td>
                                                       <td>{{$old_value['qtyout']}}</td>
                                                       <td>{{$old_value['currentbalance']}}</td>
                                                       <td>{{$old_value['invoiceno']}}</td>
                                                       <td>{{$old_value['bacthno']}}</td>
                                                       <td>{{$old_value['mfd_date']}}</td>
                                                       <td>{{$old_value['exp_date']}}</td>
                                                       <td>{{$old_value['remark']}}</td>
                                                   </tr>
                                                   @endforeach
                                                   </tbody>
                                                    </table>
                                                      </div>

                                                <div class="card-block">
                                                    <h4>Later</h4>
                                                    <table class="table table-sm table-dark">
                                                        <thead>
                                                        <tr>
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
                                                        <tbody>
                                                            <tr>
                                                                <td>{{$item['new_values']['description']}}</td>
                                                                <td>{{$item['new_values']['qtyreceived']}}</td>
                                                                <td>{{$item['new_values']['qtyout']}}</td>
                                                                <td>{{$item['new_values']['currentbalance']}}</td>
                                                                <td>{{$item['new_values']['invoiceno']}}</td>
                                                                <td>{{$item['new_values']['bacthno']}}</td>
                                                                <td>{{$item['new_values']['mfd_date']}}</td>
                                                                <td>{{$item['new_values']['exp_date']}}</td>
                                                                <td>{{$item['new_values']['remark']}}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                            @endforeach
                                    </div>
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
            ajax: '{!! route('get_storekeepers_data_audit') !!}',
            columns: [
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'active', name: 'active' },
                { data: 'created_at', name: 'created_at' },
                { data: 'updated_at', name: 'updated_at' },
                {data: 'action', name: 'action', orderable: false, searchable: false}
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

@push('style')
    <style>
        .card {
            -moz-box-direction: normal;
            -moz-box-orient: vertical;
            background-color: #fff;
            border-radius: 0.25rem;
            display: flex;
            flex-direction: column;
            position: relative;
            margin-bottom:1px;
            border:none;
        }
        .card-header:first-child {
            border-radius: 0;
        }
        .card-header {
            background-color: #f7f7f9;
            margin-bottom: 0;
            padding: 20px 1.25rem;
            border:none;

        }
        .card-header a i{
            float:left;
            font-size:25px;
            padding:5px 0;
            margin:0 25px 0 0px;
            color:#195C9D;
        }
        .card-header i{
            float:right;
            font-size:30px;
            width:1%;
            margin-top:8px;
            margin-right:10px;
        }
        .card-header a{
            width:97%;
            float:left;
            color:#565656;
        }
        .card-header p{
            margin:0;
        }

        .card-block {
            -moz-box-flex: 1;
            flex: 1 1 auto;
            padding: 20px;
            color:#232323;
            box-shadow:inset 0px 4px 5px rgba(0,0,0,0.1);
            border-top:1px soild #000;
            border-radius:0;
        }
    </style>
    @endpush