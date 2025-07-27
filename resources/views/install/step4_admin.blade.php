<!-- resources/views/install/step4_admin.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Create Admin Account</title>
</head>
<body>
    <h2>Step 4: Create Admin User</h2>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>⚠ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/install/admin">
        @csrf
        <label>Name</label><br>
        <input type="text" name="name" required><br><br>

        <label>Email</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Create Admin & Finish</button>
    </form>
</body>
</html>
