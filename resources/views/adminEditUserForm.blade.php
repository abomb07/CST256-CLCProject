<?php
/* CLC Project version 5.0
 * Edit User Form version 5.0
 * Adam Bender and Jim Nguyen
 * March 15, 2020
 * Edit User Form
 */
?>
@extends('layouts.appmaster')
@section('title','Edit User Page')

@section('content')
@if(Session::get('principal') == true and Session::get('role') == "admin") 	
<div class="center">
<h1>Admin User Edit</h1>

<form action="adminSave" method ="POST">

{{ csrf_field() }}
        <input type="hidden" class="form-control" id="id" value="{{ $user->getId() }} " name="id">
        
        
        <input type="hidden" class="form-control" id="username" value="{{ $user->getUsername() }} " name="username">

        
        <input type="hidden" class="form-control" id="password" value="{{ $user->getPassword() }} " name="password">

       
        <input type="hidden" class="form-control" id="firstname" value="{{ $user->getFirstname() }} "name="firstname">

        
        <input type="hidden" class="form-control" id="lastname" value="{{ $user->getLastname() }} " name="lastname">

        
        <input type="hidden" class="form-control" id="email" value="{{ $user->getEmail() }} " name="email">

        
        <input type="hidden" class="form-control" id="phonenumber" value="{{ $user->getPhonenumber() }} " name="phonenumber">

       
        <input type="hidden" class="form-control" id="city" value="{{ $user->getCity() }} " name="city">
        
        
                <label for="role">Role</label>
                <select  id="role" name="role">
                        <option value="user">user</option>
                        <option value="admin">admin</option>      
                </select>
                <br>
        
                <label for="status">Status</label>
                <select id="status" name="status">
                        <option value="active">active</option>
                        <option value="suspended">suspended</option>
                    
                       
                </select>
                 <br>
        
        <button type="submit" value="submit" >SUBMIT</button>

</form>        
</div>
@else
<h2> User is not authorized!!!</h2>
@endif	
@endsection