<?php
/* CLC Project version 5.0
 * Admin Process Delete version 5.0
 * Adam Bender and Jim Nguyen
 * March 15, 2020
 * Admin Delete User Confirmation Form
 */
?>
@extends('layouts.appmaster')
@section('title','Admin Process Delete Page')

@section('content')
@if(Session::get('principal')== true and Session::get('role') == "admin") 

<h2>Are you sure you want to delete this user?</h2>
<form action='adminDelete' method='POST'>
{{ csrf_field() }}
<input type='hidden' name='id' value="{{ $user->getId() }}">
<input type='submit' value='YES'>
</form>

<form action='admin'>
<input type='submit' value='NO'>
</form>

@endif
@endsection