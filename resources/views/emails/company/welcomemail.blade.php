<!DOCTYPE html>
<html>

<head>
    <title>Welcome to Drivv powered by Courierboard</title>
</head>

<body>
    <b>
        <h5>Dear {{ $maildata['name'] }}!</h5>
    </b>
    <p>Thank you for signing up with Drivv powered by Courierboard, connecting professional courier companies to shippers needing delivery services throughout the U.S. and Canada.</p>
    <p><b>As a new courier company member you will receive a free Premium trial account for 30 days. You will receive an email notice several days before your trial expires.</b></p>
    <p>To kick-off your free trial - please contact our Courier Support group for a brief 10 minute online demo where we show you how to set-up your company profile and new business alerts to maximize your Drivv account.</p>
    <p>Contact us at 1-800-220-5998 or email your preferred demo time to demo@courierboard.com</p>

    <br>
    <p><b>Your account log in information is below.</b></p>
    <p>Company Name: {{ $maildata['company'] }}</p>
    <p>Username: {{ $maildata['username'] }}</p>
    <p>Temporary Password: {{ $maildata['password'] }}</p>
    <br>
    <p>You can reset a permanent password by logging in <a href="https://www.courierboard.com/account/login">here</a>.</p>
    <br>
    <p>Please review our requirements for courier companies that include: must have an EIN, 5 or more drivers, a business domain/website, business phone, and a business office location. see Courier Company membership guidelines for all Terms and Conditions. New accounts will be reviewed and may be canceled if these requirements are not met.

        Please contact us at members@courierboard.com or call 1-800-220-5998.

        Go to your Drivv account at and login

        With Drivv

        Set up your company profile so shippers can search and find your company when looking for couriers in your area.
        Post a Driver Wanted Ad on Drivv's Find-A-Driver recruiting system - with over 60,000 registered courier drivers, helping you recruit qualified new drivers cost effectively and easily.
        You will receive new business email alerts in your business zip code zone (75 mile radius) - when freight and RFP (repeat routes) quote requests are posted in your area - giving you opportunities to quote on new business. You can add a second city alert zone as well.
        Add up to 6 Users on your account.</p>
    <p>Best Regards,</p>
    <p>The Drivv Team</p>
</body>

</html>