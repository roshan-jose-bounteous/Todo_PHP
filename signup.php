<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
</head>
<body>
    <h2>Signup</h2>
    <form id="signupForm">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Signup</button>
    </form>
    <p id="signupResult"></p>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#signupForm').on('submit', function(event) {
            event.preventDefault();
            $.post('api/signup.php', $(this).serialize(), function(response) {
                $('#signupResult').text(response);
            });
        });
    </script>
</body>
</html>
