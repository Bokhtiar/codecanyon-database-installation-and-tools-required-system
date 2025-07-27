<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel CMS - Welcome</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .status-active {
            color: #4CAF50;
            font-weight: bold;
        }
        .status-inactive {
            color: #f44336;
            font-weight: bold;
        }
        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
            font-style: italic;
        }
        .user-count {
            background: #4CAF50;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to Laravel CMS</h1>
        
        <div class="user-count">
            Total Users: {{ $users->count() }}
        </div>
        
        <h2>Users Table (Dynamic Data)</h2>
        
        @if($users->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Email Verified</th>
                        <th>Created Date</th>
                        <th>Last Updated</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->email_verified_at)
                                    <span class="status-active">Verified</span>
                                @else
                                    <span class="status-inactive">Not Verified</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('Y-m-d H:i:s') }}</td>
                            <td>{{ $user->updated_at->format('Y-m-d H:i:s') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data">
                <h3>No users found in the database.</h3>
                <p>Please run the installation process to create users.</p>
                <a href="/install" style="color: #4CAF50; text-decoration: none; font-weight: bold;">Go to Installation</a>
            </div>
        @endif
        
        <div style="margin-top: 30px; text-align: center; color: #666;">
            <p>This table shows real user data from your database. Data is fetched dynamically.</p>
        </div>
    </div>
</body>
</html>
