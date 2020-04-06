<?php
/*
 * CLC Project version 6.0
 * Affinity group page version 6.0
 * Adam Bender and Jim Nguyen
 * April 5, 2020
 * Affinity group Page
 */
?>
@extends('layouts.appmaster')
@section('title','Group Page')

@section('content')
@if(Session::get('principal') == true)

<a href="groupNewForm">Create New Group</a>

<table id="groups" class="table table-hover">
	<tr>
		<tH></tH>
		<tH></tH>
		<tH>NAME</tH>
		<tH>DESCRIPTION</tH>
		<tH></tH>
		<tH></tH>
	</tr>

@if($groups)
	@foreach($groups as $group)

	<tr>
		<td>
		@if(Session::get('id') == $group['OWNER_ID'])
			<form action='editGroup' method='POST'>
				{{ csrf_field() }} 
				<input type='hidden' name='group_id' value="{{ $group['ID'] }}"> 
				<input type='submit' value='Edit'>
			</form>
		@endif
		</td>
		<td>
		@if(Session::get('id') == $group['OWNER_ID'])
			<form action='deleteGroup' method='POST'>
				{{ csrf_field() }} 
				<input type='hidden' name='group_id' value="{{ $group['ID'] }}"> 
				<input type='hidden' name='user_id' value="{{ Session::get('id') }}">
				<input type='submit' value='Delete'>
			</form>
		@endif
		</td> 

		<td>{{$group['NAME']}}</td>
		<td>{{$group['DESCRIPTION']}}</td>
	
    	<td>
    	<form action='viewGroup' method='POST'>
    		{{ csrf_field() }}
        	<input type='hidden' name='group_id' value="{{ $group['ID'] }}">
        	<input type='hidden' name='user_id' value="{{ Session::get('id') }}">
        	<input type='submit' value='View Members'>
    	</form>
    	</td>

	</tr>

	@endforeach
@endif
</table>


@else
<h2>User is not authorized!!!</h2>
@endif 
@endsection
