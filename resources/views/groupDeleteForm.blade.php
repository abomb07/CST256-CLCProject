<?php
/* CLC Project version 4.0
 * Process Group Delete version 4.0
 * Adam Bender and Jim Nguyen
 * March 8, 2020
 * Delete Group Confirmation Form
 */
?>
@extends('layouts.appmaster')
@section('title','Process Group Delete Page')

@section('content')
@if(Session::get('principal')== true) 

<h2>Are you sure you want to delete this group?</h2>
<form action='removeGroup' method='POST'>
{{ csrf_field() }}
<input type='hidden' name='group_id' value="{{ $group->getId() }}">
<input type='submit' value='YES'>
</form>

<form action='groupPage'>
<input type='submit' value='NO'>
</form>

@endif
@endsection