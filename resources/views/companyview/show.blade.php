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
                <form id="add_product" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="Product name" class="form-label">first name : </label>
                        <input type="text" class="form-control rounded-3 n" name="first_name" id="first_name" autocomplete="off"
                            placeholder="Enter the name">
                        <p id="fname_error"></p>
                       
                    </div>
                    <div class="mb-3">
                        <label for="Product name" class="form-label">last name : </label>
                        <input type="text" class="form-control rounded-3 " name="last_name" id="last_name" autocomplete="off"
                            placeholder="Enter the name">
                        <p id="lname_error"></p>
                       
                    </div>
                    <div class="mb-3">
                        
                        <input type="text" class="form-control  rounded-3  cid" name="cid" id="cid" value="{{$company->id}}" hidden >
                        <p id="cid_error"></p>
                     
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Email : </label>
                        <input type="email" class="form-control  rounded-3  email" name="email" id="email">
                        <p id="email_error"></p>
                     
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">phone : </label>
                        <input type="text" class="form-control  rounded-3  phone" name="phone" id="phone">
                        <p id="phone_error"></p>
                    </div>
                    
                    <div class="modal-footer">

                        <button data-dismiss="modal" class="btn pmd-ripple-effect btn-dark pmd-btn-flat submit"
                            type="submit">ADD</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    <div class="container-fluid ">
        <div class=" p-3 bg-dark text-white rounded-pill text-uppercase text-center">
            <p class="display-4 pl-4">{{ $company->name }}</p>
        </div>

        <div class="d-flex flex-row bd-highlight mb-3 ">
            <div class="p-2 bd-highlight">
                <div class="p-4">
                    <img src="/icon/{{ $company->logo }}" width="250" height="250" alt="company logo">
                </div>
            </div>
            <div class="p-2 bd-highlight">
                <div class="p-4">
                    <p class="fs-4"> Email : {{ $company->email }} </p>
                    <p class="fs-4"> website : {{ $company->website }} </p>
                </div>   
            </div>
        </div>
        <div class="col-5 mb-3 ">
            <button data-target="#form-dialog" data-toggle="modal" class="btn pmd-ripple-effect btn-primary pmd-btn-raised"
                type="button">ADD employee</button>
        </div>
        <table class="table table-striped table-hover data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>first_name</th>
                    <th>last_name</th>
                    <th>company_id</th>
                    <th>email</th>
                    <th>phone</th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody>

        </table>
        </tbody>
    @endsection
    @push('scripts')
        <script>
            $(document).ready(function() {
                var url = window.location.href;
                var id = url.substring(url.lastIndexOf('/') + 1);
                var table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ url('companyview') }}" + "/" + id,
                    columns: [{
                            data: 'id',
                            name: 'id',
                        },
                        {
                            data: 'first_name',
                            name: 'first_name',
                        },
                        {
                            data: 'last_name',
                            name: 'last_name',
                        },
                        {
                            data: 'company_id',
                            name: 'company_id',
                        },
                        {
                            data: 'email',
                            name: 'email',
                        },
                        {
                            data: 'phone',
                            name: 'phone',
                        },
                        {
                            data: 'action',
                            name: 'action',
                            searchable: false,
                        },

                    ]
                });

                $(document).on('click', '.submit', (function(e) {
                  
                  e.preventDefault();
                  //var id = $('#id').val();
                  var first_name = $('#first_name').val();
                  var last_name = $('#last_name').val();
                  var email = $('#email').val();
                  var phone = $('#phone').val();
                  var company_id = $('#cid').val();
                  console.log(email, phone, company_id);
                  var formData = new FormData(document.querySelector("#add_product"));
                  $.ajax({
                      url: "{{ route('employee.store') }}",
                      data: formData,
                      type: 'POST',
                      datatype: 'json',
                      cache: false,
                      contentType: false,
                      processData: false,
                      success: function(data) {
                          
                              $('#add_product').trigger('reset');
                              $(".data-table").DataTable().ajax.reload();
                          
                      },
                  });
              }));

              $('#fname_error #lname_error #phone_error #email_error ').hide();
                $('alert alert-danger').reomove 
                var fname_error, email_error, lname_error, phone_error= true;
                $('#first_name').keyup(function() {
                    fnameCheck();
                });
                $('#email').keyup(function() {
                    emailCheck();
                });
                $('#last_name').keyup(function() {
                    lastCheck();
                });
                $('#phone').keyup(function() {
                    phoneCheck();
                });
                
                
                function fnameCheck() {
                    var name_val = $('#first_name').val();
                    if (name_val.length == 0) {
                        $('#fname_error').show();
                        $('#fname_error').html('Please enter tha name');
                        $('#fname_error').focus();
                        $('#fname_error').css('color', 'red');
                        fname_error = false;
                        return false;
                    } else {
                        $('#fname_error').hide();
                        
                    }
                    if (name_val.length < 3 || name_val.length > 10) {
                        $('#fname_error').show();
                        $('#fname_error').html('Please enter the name bwtween 3 to 10');
                        $('#fname_error').focus();
                        $('#fname_error').css('color', 'red');
                        fname_error = false;
                        return false;
                    } else {
                        $('#fname_error').hide();
                    }
                };

                function lastCheck() {
                    var name_val = $('#last_name').val();
                    if (name_val.length == 0) {
                        $('#lname_error').show();
                        $('#lname_error').html('Please enter tha name');
                        $('#lname_error').focus();
                        $('#lname_error').css('color', 'red');
                        lname_error = false;
                        return false;
                    } else {
                        $('#lname_error').hide();
                        
                    }
                    if (name_val.length < 3 || name_val.length > 10) {
                        $('#lname_error').show();
                        $('#lname_error').html('Please enter the name bwtween 3 to 10');
                        $('#lname_error').focus();
                        $('#lname_error').css('color', 'red');
                        lname_error = false;
                        return false;
                    } else {
                        $('#lname_error').hide();
                    }

                    var firstname = $('#first_name').val();
                    var lastname = $('#last_name').val();

                    if (firstname == lastname) {
                        $('#lname_error').show();
                        $('#lname_error').html('first and last name should   diffrent');
                        $('#lname_error').focus();
                        $('#lname_error').css('color', 'red');
                        lname_error = false;
                        return false;
                    } else {
                        $('#lname_error').hide();
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
                    const re = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
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

                function phoneCheck() {
                    var phone_val = $('#phone').val();
                    if (phone_val.length == 0) {
                        $('#phone_error').show();
                        $('#phone_error').html('Please enter tha name');
                        $('#phone_error').focus();
                        $('#phone_error').css('color', 'red');
                        phone_error = false;
                        return false;
                    } else {
                        $('#phone_error').hide();    
                    }

                   const re = /^(?:(?:\+|0{0,2})91(\s*[\ -]\s*)?|[0]?)?[789]\d{9}|(\d[ -]?){10}\d$/;

                   if (!re.test(phone_val)) {
                        $('#phone_error').show();
                        $('#phone_error').html('Please enter the phone no');
                        $('#phone_error').focus();
                        $('#phone_error').css('color', 'red');
                        phone_error = false;
                        return false;
                    } else {
                        $('#phone_error').hide();
                    }

                };

            });
        </script>
    @endpush()