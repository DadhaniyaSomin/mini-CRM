@extends('layouts.app')
@section('content')
    <div class="container">
        <form action="{{ route('employee.update', $employee->id) }}" method="POST">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="text" name="id" value="{{ $employee->id }}" hidden>
            <div class="mb-3">
                <label for="Product name" class="form-label">first name : </label>
                <input type="text" class="form-control rounded-3 n" name="first_name" id="first_name" autocomplete="off"
                    placeholder="Enter the first name" value="{{ $employee->first_name }}">
                <p id="fname_error"></p>
                @if ($errors->has('first_name'))
                    <div class="text-danger">{{ $errors->first('first_name') }}</div>
                @endif

            </div>
            <div class="mb-3">
                <label for="Product name" class="form-label">last name : </label>
                <input type="text" class="form-control rounded-3 " name="last_name" id="last_name" autocomplete="off"
                    placeholder="Enter the name" value="{{ $employee->last_name }}">
                <p id="lname_error"></p>
                @if ($errors->has('last_name'))
                    <div class="text-danger">{{ $errors->first('last_name') }}</div>
                @endif

            </div>
            <div class="mb-3">

                <input type="text" class="form-control  rounded-3  cid" name="cid" id="cid" value="
                    {{ $employee->company_id }}" hidden>
                <p id="cid_error"></p>


            </div>
            <div class="mb-3">
                <label for="" class="form-label">Email : </label>
                <input type="email" class="form-control  rounded-3  email" name="email" id="email"
                    value="{{ $employee->email }}">
                <p id="email_error"></p>
                @if ($errors->has('email'))
                    <div class="text-danger">{{ $errors->first('email') }}</div>
                @endif

            </div>
            <div class="mb-3">
                <label for="" class="form-label">phone : </label>
                <input type="text" class="form-control  rounded-3  phone" name="phone" id="phone"
                    value="{{ $employee->phone }}">
                <p id="email_error"></p>
            </div>
            @if ($errors->has('phone'))
                <div class="text-danger">{{ $errors->first('phone') }}</div>
            @endif

            <div class="modal-footer">

                <button data-dismiss="modal" class="btn pmd-ripple-effect btn-dark pmd-btn-flat submit"
                    type="submit">UPDATE</button>
            </div>
        </form>
    </div>
@endsection
