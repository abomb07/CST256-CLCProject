<?php
/* CLC Project version 3.0
 * Process Skill Delete version 2.0
 * Adam Bender and Jim Nguyen
 * February 23, 2020
 * Delete Skill Confirmation Form
 */
?>
@extends('layouts.appmaster')
@section('title','Process Skill Delete Page')

@section('content')
@if(Session::get('principal')== true) 

<h2>Are you sure you want to delete this skill?</h2>
<form action='removeSkill' method='POST'>
{{ csrf_field() }}
<input type='hidden' name='id' value="{{ $skill->getId() }}">
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