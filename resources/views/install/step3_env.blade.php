@if ($errors->any())
    <div>
        @foreach ($errors->all() as $error)
            <p style="color:red;">{{ $error }}</p>
        @endforeach
    </div>
@endif

<form action="/install/env" method="POST">
    @csrf
    <input type="text" name="db_host" placeholder="DB Host" value="{{ old('db_host', $defaultConfig['db_host'] ?? '127.0.0.1') }}" required>
    <input type="text" name="db_name" placeholder="DB Name" value="{{ old('db_name', $defaultConfig['db_name'] ?? 'cms') }}" required>
    <input type="text" name="db_user" placeholder="DB User" value="{{ old('db_user', $defaultConfig['db_user'] ?? 'cm_user') }}" required>
    <input type="password" name="db_pass" placeholder="DB Password" value="{{ old('db_pass', $defaultConfig['db_pass'] ?? 'cms_secret') }}">
    <button type="submit">Save & Next</button>
</form>
