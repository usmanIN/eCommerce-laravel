@extends('layouts.master')
@section('title','Home')
@section('content')

<form method="post" action="register">
  {{@csrf_field()}}
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
    @error('username')
      <span class="alert alert-danger">{{ $message }}</span>
    @enderror
    
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" name="password">
    @error('password')
      <span class="alert alert-danger">{{ $message }}</span>
    @enderror
  </div>
  <div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>

  {{ session('error') }}
  
</form>

@endsection

