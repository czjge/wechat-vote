@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('suc'))
    <script>
        noty({
            text: "<strong>{{ session('suc') }}</strong><br/>",
            type:'success',
            timeout: 3000
        });
    </script>
@endif

@if (session('warning'))
    <script>
        noty({
            text: "<strong>{{ session('warning') }}</strong><br/>",
            type:'warning',
            timeout: 3000
        });
    </script>
@endif

@if (session('fail'))
    <script>
        noty({
            text: "<strong>{{ session('fail') }}</strong><br/>",
            type:'error',
            timeout: 3000
        });
    </script>
@endif