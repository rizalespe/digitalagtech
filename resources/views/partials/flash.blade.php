@if (session('status'))
    <div class="flash flash--success" role="status">{{ session('status') }}</div>
@endif

@if (session('error'))
    <div class="flash flash--error" role="alert">{{ session('error') }}</div>
@endif

@if ($errors->newsletter->any())
    <div class="flash flash--error" role="alert">{{ $errors->newsletter->first('email') }}</div>
@endif
