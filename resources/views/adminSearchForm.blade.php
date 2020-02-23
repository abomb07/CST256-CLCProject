<?php
/* CLC Project version 3.0
 * Admin Search page version 1.0
 * Adam Bender and Jim Nguyen
 * February 23, 2020
 * Admin Search Page
 */
?>
@extends('layouts.appmaster')
@section('title','Admin Search Page')

@section('content')
@if(Session::get('principal') == true and Session::get('role') == "admin") 	
<div class="container">
<br>
  <form action="findByFirstName" method="POST">
  {{ csrf_field() }}
    <div class="input-group">
      <input type="text" class="form-control" placeholder="Search By First Name" name="firstname">
      <div class="input-group-btn">
        <input type='submit' value='Search'>{{$errors->first('firstname')}}
      </div>
    </div>
  </form>
</div>

<div class="container">
<br>
  <form action="findByLastName" method="POST">
  {{ csrf_field() }}
    <div class="input-group">
      <input type="text" class="form-control" placeholder="Search By Last Name" name="lastname">
      <div class="input-group-btn">
        <input type='submit' value='Search'>{{$errors->first('lastname')}}
      </div>
    </div>
  </form>
</div>
@else
<h2> User is not authorized!!!</h2>
@endif	

@endsection