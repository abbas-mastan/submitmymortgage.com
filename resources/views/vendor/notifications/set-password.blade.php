<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register Email</title>
</head>
<body style="background-color: #edf2f7;">
    <div style="padding: 50px">
        <div style="text-align: center;">
            <h2>
                <span style="color:black;">
                    SubmitMyMortgage
                </span>
            </h2>
            <div
                style="height: 50%; background-color:white; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, .25); padding:3rem; margin-bottom:20px;">
                <h3 style="font-size: 1.125rem; line-height: 1.75rem;text-align:left; color:black;" class="text-lg">
                    Hello!</h3>
                <p style="color:black; font-size: 1rem; margin-top: 0.5rem; text-align:left;">
                    You are receiving this email to complete your registration process by entering your password.
                </p>
                <div style="text-align: center; margin-top: 1.5rem; margin-bottom: 1.5rem;">
                    <a href="{{ $url }}"
                        style="text-decoration:none; background-color: black; border-radius: 0.25rem; color: white; padding:0.5rem 0.90rem;">
                        Create Password
                    </a>
                </div>
                <p style="color:black;text-align:left;font-size: 1rem;" class="text-md">
                    Regards,<br> SubmitMyMortgage
                </p>
                <hr style="margin-top: 0.5rem;" class="my-3">
            </div>
            <small style="color:black">© {{ date('Y') }} SubmitMyMortgage. All rights reserved.</small>
        </div>
    </div>
</body>
</html>
