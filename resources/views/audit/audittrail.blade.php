@extends('layouts.main')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">

            <div class="row">
                <div class="col-12 grid-margin mt-5">

                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="text-center pl-2">
                                    Audit trail for {{$product->name}} - {{$user->firstname}}
                                </h4>
                                <div class="bd-example" data-example-id="">
                                    <div class="accordion" id="accordionExample">
                                        @foreach($data as $index => $item)
                                            <div class="card">
                                                <div class="card-header" id="heading{{$index}}">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#{{$index}}" aria-expanded="true" aria-controls="collapseOne">
                                                            <h4>Event: {{ucfirst($item->event)}}</h4>
                                                        </button>
                                                    </h5>
                                                </div>
                                                <div id="{{$index}}" class="collapse" aria-labelledby="heading{{$index}}" data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        <h5>Before</h5>
                                                        <hr>
                                                @foreach($item['old_values'] as $key => $old_value)
                                                <p>{{$key}} : {{$old_value}}</p>
                                                @endforeach
                                            <h5>After</h5>
                                                        <hr>
                                            @foreach($item['new_values'] as $key => $new_value)
                                                <p>{{$key}} : {{$new_value}}</p>
                                                @endforeach
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

