<?php
/* CLC Project version 4.0
 * Process Job History Delete version 4.0
 * Adam Bender and Jim Nguyen
 * March 8, 2020
 * Delete Job History Confirmation Form
 */
?>
@extends('layouts.appmaster')
@section('title','Process Job History Delete Page')

@section('content')
@if(Session::get('principal')== true) 

<h2>Are you sure you want to delete this job history?</h2>
<form action='removeJobHistory' method='POST'>
{{ csrf_field() }}
<input type='hidden' name='id' value="{{ $jobhistory->getId() }}">
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