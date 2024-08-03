<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Expiration Reminder Email Failed</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        td {
            padding: 10px;
        }
    </style>
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
                    Dear Super Admin,
                </h3>
                <p style="color:black; font-size: 1rem; margin-top: 0.5rem; text-align:left;">
                    We encountered an issue while attempting to send the trial expiration reminder email. The email
                    notification for users whose trial period is about to expire could not be delivered successfully.
                </p>
                <p><b>Error Message:</b>{{$message}}</p>
                <p><b>Timestamp:</b>{{ now() }}</p>
                <p>
                    Please investigate the issue at your earliest convenience to ensure that users receive their trial
                    expiration notifications in a timely manner.
                </p>
                <p style="color:black;text-align:left;font-size: 1rem;" class="text-md">
                    Regards,<br> SubmitMyMortgage
                </p>
                {{-- <hr style="margin-top: 0.5rem;" class="my-3"> --}}
            </div>
            <small style="color:black">© {{ date('Y') }} SubmitMyMortgage. All rights reserved.</small>
        </div>
    </div>
</body>

</html>
