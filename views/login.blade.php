<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <style>
        body {
            font-family: Arial;
            background: #f2f2f2;
        }

        .container {
            width: 400px;
            margin: 80px auto;
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 10px #ccc;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 8px 0 15px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
        }

        a {
            text-decoration: none;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>Login</h2>

    @if (session('success'))
        <p class="success">
            {{ session('success') }}
        </p>
    @endif

    @if ($errors->any())
        <div class="error">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ url('/login') }}" method="POST">
        @csrf

        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}">

        <label>Password</label>
        <input type="password" name="password">

        <button type="submit">Login</button>
    </form>

    <p>
        Don't have an account?
        <a href="{{ url('/register') }}">Register</a>
    </p>

</div>

</body>
</html>


