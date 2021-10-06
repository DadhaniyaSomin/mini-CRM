@extends('layouts.app')

@section('content')
    <div tabindex="-1" class="modal pmd-modal fade" id="form-dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header pmd-modal-border text-white bg-dark ">
                    <h2 class="modal-title">ADD SOMETHING AMAZING</h2>
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                </div>
                <div class="modal-body bg-light">
                    <div class="alert alert-danger print-error-msg" style="display:none">

                        <ul></ul>
                
                    </div>
                    <form id="add_company" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="Product name" class="form-label">Company Name : </label>
                            <input type="text" class="form-control rounded-3 name" name="name" id="name" autocomplete="off"
                                placeholder="Enter the name" require>
                            <p id="name_error"></p>
                            @if ($errors->has('name'))
                                <div class="text-danger" id="">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">company id : </label>
                            <input type="email" class="form-control  rounded-3  email" name="email" id="email" >
                            <p id="email_error"></p>
                            @if ($errors->has('email'))
                                <div class="text-danger">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Select company logo : </label>
                            <input class="form-control icon" name="icon" id="icon" type="file" >
                            <p id="icon_error"></p>
                            @if ($errors->has('logo'))
                                <div class="text-danger">{{ $errors->first('logo') }}</div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="Product price" class="form-label">website</label>
                            <input type="url" class="form-control  rounded-3 website" id="website" autocomplete="off"
                                name="website" placeholder="Enter the price" require>
                            <p id="websites_error"> </p>
                            @if ($errors->has('website'))
                                <div class="text-danger">{{ $errors->first('website') }}</div>
                            @endif
                        </div>
                        <div class="modal-footer">

                            <button class="btn pmd-ripple-effect btn-dark pmd-btn-flat submit" type="submit">ADD</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--Modal: modalConfirmDelete-->
    <div class="modal fade" id="modalConfirmDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm modal-notify modal-danger" role="document">
            <!--Content-->
            <div class="modal-content text-center">
                <!--Header-->
                <div class="modal-header d-flex justify-content-center">
                    <p class="heading">Are you sure?</p>
                </div>
                <!--Body-->
                <div class="modal-body">
                    <i class="fa fa-times fa-4x animated rotateIn"></i>
                    <p>Are you sure you want to delte this Product .This can not be undone</p>
                </div>
                <!--Footer-->
                <div class="modal-footer flex-center">
                    <button data-dismiss="modal" class="btn pmd-ripple-effect btn-danger pmd-btn-flat" id="delete"
                        type="button">yes</button>
                    <a type="button" class="btn  btn-danger waves-effect" data-dismiss="modal">No</a>
                </div>
            </div>
            <!--/.Content-->
        </div>
    </div>
    <!--Modal: modalConfirmDelete-->
    <div class="container-fluid ">
        <div class="col-5 mb-3 ">
            <button data-target="#form-dialog" data-toggle="modal" class="btn pmd-ripple-effect btn-primary pmd-btn-raised"
                type="button">ADD COMPANY</button>
        </div>
        <table class="table table-striped table-hover data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>name</th>
                    <th>email</th>
                    <th>website</th>
                    <th>icon</th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    @endsection
    @push('scripts')
        <script>
            $(document).ready(function() {

                var table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('company.index') }}",
                    columns: [{
                            data: 'id',
                            name: 'id',
                        },
                        {
                            data: 'name',
                            name: 'name',
                        },
                        {
                            data: 'email',
                            name: 'email',
                        },
                        {
                            data: 'website',
                            name: 'website',
                        },
                        {
                            data: "logo",
                            "render": function(data, type, row) {
                                return '<img src="/icon/' + data + '" width="100px" />';
                            },
                            name: 'logo'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            searchable: false,
                        },
                    ]
                });



                //insert data into database 
                $(document).on('click', '.submit', (function(e) {

                    e.preventDefault();
                    //var id = $('#id').val();
                    var name = $('#name').val();
                    var email = $('#email').val();
                    var icon = $('#icon').val();
                    var website = $('#website').val();
                    console.log(name, email, icon, website);
                    var formData = new FormData(document.querySelector("#add_company"));
                    $.ajax({
                        url: "{{ route('company.store') }}",
                        data: formData,
                        type: 'POST',
                        datatype: 'json',
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            //console.log(data);
                            if ($.isEmptyObject(data.error)) {
                              
                            
                               $("#form-dialog").modal("hide"); 
                               $(".data-table").DataTable().ajax.reload();
                               $('#name').val("");
                        $('#email').val("");
                        $('#website').val("");
                        $('#icon').val(""); 
                            } else {
                                printErrorMsg(data.error);
                            }
                 
                        }
                    });
                }));
            
            
                function printErrorMsg(msg) {

                    $(".print-error-msg").find("ul").html('');
                    $(".print-error-msg").css('display', 'block');
                    $.each(msg, function(key, value) {
                        $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
                    });

                }
                //delete data from database
                $(document).on('click', '.product_delete', function(e) {
                    var id = $(this).data('id');
                    console.log(id);
                    $('#delete').click(function(e) {
                        e.preventDefault();
                        $.ajax({
                            url: "{{ url('company') }}" + '/' + id,
                            type: 'POST',
                            dataType: 'JSON',
                            data: {
                                'id': id,
                                _token: "{{ csrf_token() }}",
                                _method: "DELETE"
                            },
                            success: function(data) {
                                table.draw();
                            },
                        });
                    });
                });

                $('#name_error #icon_error #website_error #email_error ').hide();
                $('alert alert-danger').reomove
                var name_error, email_error, icon_error, website_error = true;
                $('#name').keyup(function() {
                    nameCheck();
                });
                $('#email').keyup(function() {
                    emailCheck();
                });
                $('#website').keyup(function() {
                    websiteCheck();
                });

                function nameCheck() {
                    var name_val = $('#name').val();
                    if (name_val.length == 0) {
                        $('#name_error').show();
                        $('#name_error').html('Please enter tha name');
                        $('#name_error').focus();
                        $('#name_error').css('color', 'red');
                        name_error = false;
                        return false;
                    } else {
                        $('#name_error').hide();

                    }
                    if (name_val.length < 3 || name_val.length > 10) {
                        $('#name_error').show();
                        $('#name_error').html('Please enter the name bwtween 3 to 10');
                        $('#name_error').focus();
                        $('#name_error').css('color', 'red');
                        name_error = false;
                        return false;
                    } else {
                        $('#name_error').hide();
                    }
                };

                function emailCheck() {
                    var email_val = $('#email').val();
                    if (email_val.length == 0) {
                        $('#email_error').show();
                        $('#email_error').html('Please enter tha email');
                        $('#email_error').focus();
                        $('#email_error').css('color', 'red');
                        email_error = false;
                        return false;
                    } else {
                        $('#email_error').hide();

                    }
                    const re =
                        /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
                    if (!re.test(email_val)) {
                        $('#email_error').show();
                        $('#email_error').html('Please enter the valid email');
                        $('#email_error').focus();
                        $('#email_error').css('color', 'red');
                        email_error = false;
                        return false;
                    } else {
                        $('#email_error').hide();
                    }
                };

                function websiteCheck() {
                    var site_val = $('#website').val();
                    if (site_val == '') {
                        // console.log(site_val);
                        $('#site_error').show();
                        $('#site_error').html('Please enter tha url');
                        $('#site_error').focus();
                        $('#site_error').css('color', 'red');
                        site_error = false;
                        return false;
                    } else {
                        $('#site_error').hide();

                    }
                };
            });
        </script>
    @endpush()
