@extends('layouts.app')
@section('content')
<div class="container">
<form   action="{{route('company.update' , $company1->id)}}"  method="post" >
    {{-- @csrf --}}
    <input type="hidden" name="_method" value="PUT">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="text" name="id" value="{{ $company1->id }}" hidden>
    <div class="mb-3">
        <label for="Product name" class="form-label">Company Name : </label>
        <input type="text" class="form-control rounded-3 name" name="name" id="name" autocomplete="off"
            placeholder="Enter the name" value = "{{$company1->name}}">
        <p id="name_error"></p>
        @if ($errors->has('name'))
        <div class="text-danger">{{ $errors->first('name') }}</div>
    @endif
    </div>
    <div class="mb-3">
        <label for="" class="form-label">company id : </label>
        <input type="email" class="form-control  rounded-3  email" name="email" id="email"  value = "{{$company1->email}}">
        <p id="email_error"></p>
        @if ($errors->has('email'))
        <div class="text-danger">{{ $errors->first('email') }}</div>
    @endif
    </div>
    <div class="mb-3">
        <label for="Product price" class="form-label">website</label>
        <input type="url" class="form-control  rounded-3 website" id="website" autocomplete="off"
            name="website" placeholder="Enter the price"  value = "{{$company1->website}}">
        <p id="price_error"> </p>
        @if ($errors->has('website'))
        <div class="text-danger">{{ $errors->first('website') }}</div>
    @endif
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-outline-success">SUBMIT</button>
    </div>
</form>
</div>
@endsection()