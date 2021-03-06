<?php
/* CLC Project version 5.0
 * Process Education Delete version 5.0
 * Adam Bender and Jim Nguyen
 * March 15, 2020
 * Delete Education Confirmation Form
 */
?>
@extends('layouts.appmaster')
@section('title','Process Education Delete Page')

@section('content')
@if(Session::get('principal')== true) 

<h2>Are you sure you want to delete this education?</h2>
<form action='removeEducation' method='POST'>
{{ csrf_field() }}
<input type='hidden' name='id' value="{{ $education->getId() }}">
<input type='hidden' name='user_id' value="{{ Session::get('id') }}"> 
<input type='submit' value='YES'>
</form>

<form action='portfolio' method='post'>
{{ csrf_field() }}
<input type='hidden' name='user_id' value="{{Session::get('id')}}">
<input type='submit' value='NO'>
</form>

@endif
@endsection