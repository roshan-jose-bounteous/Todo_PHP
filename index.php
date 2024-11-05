<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form id="loginForm">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <p id="loginResult"></p>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#loginForm').on('submit', function(event) {
            event.preventDefault();
            $.post('api/login.php', $(this).serialize(), function(response) {
                if (response.includes("successful")) {
                    window.location.href = "dashboard.php";
                } else {
                    $('#loginResult').text(response);
                }
            });
        });
    </script>
</body>
</html>
