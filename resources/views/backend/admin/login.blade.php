@include('backend.includes.header')
<form method="post" action="{{ route('admin-login') }}">
    @csrf

    <img class="mb-4" src="{!! url('backend/images/login-logo.jpg') !!}" alt="" width="77" height="77">

    <h1 class="h3 mb-3 fw-normal">Login</h1>
    <div class="form-group form-floating mb-3">
        <input type="text" class="form-control" name="email"  placeholder="Email" autofocus>
        <label for="floatingName">Email </label> 
    </div>
    <div class="form-group form-floating mb-3">
        <input type="password" class="form-control" name="password" placeholder="Password">
        <label for="floatingPassword">Password</label>
    </div>
    <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>
</form>