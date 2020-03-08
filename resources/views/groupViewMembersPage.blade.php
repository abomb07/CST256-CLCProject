<?php
/*
 * CLC Project version 4.0
 * View group page version 4.0
 * Adam Bender and Jim Nguyen
 * March 8, 2020
 * View group Page
 */
?>
@extends('layouts.appmaster')
@section('title','View Group Page')

@section('content')
@if(Session::get('principal'))

<table id="groupinfo" class="table table-hover">
	<tr>
		<tH>NAME</tH>
		<tH>DESCRIPTION</tH>
		<tH>GROUP OWNER</tH>
	</tr>
	
	<tr>
		<td>{{$group->getName()}}</td>
		<td>{{$group->getDescription()}}</td>
		<td>{{$owner->getUsername()}}</td>
	</tr> 
</table>

<h2 align="center">MEMBERS</h2>

@if($users)

	@foreach($users as $user)
	<h5 align="center" style="display: inline-block">
	{{ $user->getFirstname() }} {{ $user->getLastname() }} ({{ $user->getUsername() }})
	</h5>
	
	<form action='profile' method='POST' style="display: inline-block">
        {{ csrf_field() }}
        <input type='hidden' name='id' value="{{ $user->getId() }}">
        <button type="submit" class="btn btn-default">View Profile</button>
    </form>
	<br>
	@endforeach
		
	@if($memberExists)
	<form action='leaveGroup' method='POST'>
		{{ csrf_field() }}
    	<input type='hidden' name='user_id' value="{{ Session::get('id') }}">
    	<input type='hidden' name='group_id' value="{{ $group->getId() }}"> 
    	<input type='submit' value='Leave'>
	</form>
	
	@else
	
	<form action='joinGroup' method='POST'>
		{{ csrf_field() }}
    	<input type='hidden' name='user_id' value="{{ Session::get('id') }}">
    	<input type='hidden' name='group_id' value="{{ $group->getId() }}"> 
    	<input type='submit' value='Join'>
	</form>
		
	@endif

@else
<div align="center">NO MEMBERS YET</div>
<br>
<form action='joinGroup' method='POST'>
	{{ csrf_field() }}
	<input type='hidden' name='user_id' value="{{ Session::get('id') }}">
	<input type='hidden' name='group_id' value="{{ $group->getId() }}"> 
	<input type='submit' value='Join'>
</form>
@endif

@else
<h2>User is not authorized!!!</h2>
@endif 
@endsection
