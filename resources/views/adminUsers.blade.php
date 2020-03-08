<?php
/* CLC Project version 4.0
 * Admin page version 4.0
 * Adam Bender and Jim Nguyen
 * March 8, 2020
 * Admin Users Page
 */
?>
@extends('layouts.appmaster')
@section('title','Admin Page')

@section('content')
@if(Session::get('principal') == true and Session::get('role') == "admin") 		

<a href="adminSearch">Search For Users Here</a>
	 
<table id="users" class="table table-hover">
<tr>
        <tH>
        
        </tH>
        <tH>
        
        </tH>
    <tH>
    ID
    </tH>
    <tH>
    USERNAME
    </tH>
    <tH>
    PASSWORD
    </tH>
     <tH>
    FIRST NAME
    </tH>
    <tH>
    LAST NAME
    </tH>
    <tH>
    EMAIL
    </tH>
    <tH>
    PHONE NUMBER
    </tH>
    <tH>
    CITY
    </tH>
    <tH>
    ROLE
    </tH>
    <tH>
    STATUS
    </tH>
</tr>

    @foreach($users as $user)
    	
	<tr>
		@if(Session::get('id') != $user['ID'])
	<td>
	<form action='adminEdit' method='POST'>
		{{ csrf_field() }}
    	<input type='hidden' name='id' value="{{ $user['ID'] }}">
    	<input type='submit' value='Edit'>
	</form>
	</td>
	<td>
	<form action='adminConfirmDelete' method='POST'>
    {{ csrf_field() }}
    <input type='hidden' name='id' value="{{ $user['ID'] }}">
    <input type='submit' value='Delete'>
</form>
	</td>
	@else
	<td></td>
	<td></td>
		@endif
	<td>{{$user['ID']}}</td>
	<td>{{$user['USERNAME']}}</td>
	<td>{{$user['PASSWORD']}}</td>
	<td>{{$user['FIRSTNAME']}}</td>
	<td>{{$user['LASTNAME']}}</td>
	<td>{{$user['EMAIL']}}</td>
	<td>{{$user['PHONENUMBER']}}</td>
	<td>{{$user['CITY']}}</td>
	<td>{{$user['ROLE']}}</td>
	<td>{{$user['STATUS']}}</td>
	
	@if(Session::get('id') != $user['ID'] && $user['STATUS'] == "active" )
	<td>
	<form action='adminSuspend' method='POST'>
		{{ csrf_field() }}
    	<input type='hidden' name='id' value="{{ $user['ID'] }}">
    	<input type='submit' value='Suspend'>
	</form>
	</td>
	@endif
	
	@if(Session::get('id') != $user['ID'] && $user['STATUS'] == "suspended")
	<td>
	<form action='adminActivate' method='POST'>
		{{ csrf_field() }}
    	<input type='hidden' name='id' value="{{ $user['ID'] }}">
    	<input type='submit' value='Activate'>
	</form>
	</td>
	@endif
	</tr>
		
	@endforeach
	</table>


@else
<h2> User is not authorized!!!</h2>
@endif	
@endsection