<!DOCTYPE html>
<html>
<head>
    <title>Welcome Email</title>
</head>
<body>
    <b><h5>Dear {{ $maildata['name'] }}!</h5></b>
    <p><b>We recieved a password reset request.</b>  </p>
    <br>
    <p>Your temporary account log in information is below.</p>
    <br>
    <p>Username: {{ $maildata['username'] }}</p>
    <p>Password: {{ $maildata['password'] }}</p>
    <br>
    <p>You can reset a permanent password by logging in <a href="https://www.courierboard.com/account/login">here</a>.</p>
    <br>
    <p>If you have any questions, please contact a Drivv support representative <a href="https://www.courierboard.com/home/contact">here</a>.</p>
    <br>
    <p>Best Regards,</p>
    <p>The Drivv Team</p>
</body>
</html>