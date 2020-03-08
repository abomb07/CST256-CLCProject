<?php 
/* CLC Project version 2.0
 * _navbar version 2.0
 * Adam Bender and Jim Nguyen
 * February 5th, 2020
 * _navbar class
 */?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="home">Home</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
    
    @if(Session::get('principal')== true and Session::get('role') == "admin") 	
      <li class="nav-item">
        <a class="nav-link" href="admin">Admin</a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link" href="adminJobs">Jobs</a>
      </li> 
    @endif
    
    @if(Session::get('principal')== false) 	
      <li class="nav-item">
        <a class="nav-link" href="login">Login</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="register">Register</a>
      </li>
    @else
      <li class="nav-item">
        <a class="nav-link" href="groups">Groups</a>
      </li>  
      <li class="nav-item">
        <a class="nav-link" href="logout">Logout</a>
      </li>     
    @endif
    </ul>
    
    @if(Session::get('principal')== true) 
    <form action='profile' method='POST' class="form-inline my-2 my-lg-0">
        {{ csrf_field() }}
        <input type='hidden' name='id' value="{{Session::get('id')}}">
        <button class="btn my-2 my-sm-0" type="submit">Profile</button>
    </form>
    
    <form action='portfolio' method='POST' class="form-inline my-2 my-lg-0">
        {{ csrf_field() }}
        <input type='hidden' name='user_id' value="{{Session::get('id')}}">
        <button class="btn my-2 my-sm-0" type="submit">Portfolio</button>
    </form>
    @endif
    
  </div>
</nav>