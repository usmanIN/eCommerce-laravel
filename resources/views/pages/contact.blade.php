@extends('layouts.master')
@section('title','Home')
@section('content')

<div class="container">  
  <form method="POST" action="/contact" class="form">
    <div class="form-method">
      <label>Email </label>
      <input type="text" name="email" class="form-control">
    </div>  
    <div class="form-method">
      <label> Details</label>
      <textarea name="query" class="form-control"></textarea>
    </div>  
    <div class="form-method">
      <input type="submit" class="btn btn-primary">
    </div>
  </form>
</div>  


@endsection
