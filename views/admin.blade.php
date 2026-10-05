
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Admin Panel</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
        }

        .header {
            background: #343a40;
            color: white;
            padding: 20px;
        }

        .header h1 {
            margin: 0;
        }

        .container {
            width: 90%;
            margin: 30px auto;
        }

        .welcome {
            background: white;
            padding: 20px;
            margin-bottom: 25px;
            border-radius: 8px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .card {
            background: white;
            padding: 25px;
            text-align: center;
            border-radius: 8px;
            box-shadow: 0 2px 8px #ccc;
        }

        .card h2 {
            margin-bottom: 15px;
        }

        .card a {
            display: inline-block;
            padding: 10px 15px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .card a:hover {
            background: #0056b3;
        }

        .logout {
            margin-top: 30px;
        }

        .logout button {
            padding: 10px 20px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

    </style>

</head>

<body>

    <div class="header">

        <h1>Admin Panel</h1>

    </div>


    <div class="container">

        <div class="welcome">

            <h2>
                Welcome Admin, {{ Auth::user()->name }}
            </h2>

            <p>
                Email: {{ Auth::user()->email }}
            </p>

            <p>
                Role: {{ Auth::user()->role }}
            </p>

        </div>


        <h2>Admin Management</h2>


        <div class="cards">

            <!-- Users -->

            <div class="card">

                <h2>Users</h2>

                <p>Manage registered users.</p>

                <a href="/admin/users">
                    Manage Users
                </a>

            </div>


            <!-- Products -->

            <div class="card">

                <h2>Products</h2>

                <p>Manage products.</p>

                <a href="/admin/products">
                    Manage Products
                </a>

            </div>


            <!-- Categories -->

            <div class="card">

                <h2>Categories</h2>

                <p>Manage product categories.</p>

                <a href="/admin/categories">
                    Manage Categories
                </a>

            </div>


            <!-- Orders -->

            <div class="card">

                <h2>Orders</h2>

                <p>Manage customer orders.</p>

                <a href="/admin/orders">
                    Manage Orders
                </a>

            </div>

        </div>


        <br>


        <a href="/admin/dashboard">
            Back to Dashboard
        </a>


        <div class="logout">

            <form action="/logout" method="POST">

                @csrf

                <button type="submit">
                    Logout
                </button>

            </form>

        </div>

    </div>

</body>

</html>