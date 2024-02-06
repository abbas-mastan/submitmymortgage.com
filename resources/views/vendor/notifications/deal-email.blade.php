<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register Email</title>
</head>
<body style="font-family: graphik, sans-serif; cursor: auto; background-color:#faf2f2;">
    <div style="text-align: center;">
        <div style="margin-top:30px">
            <div style="text-align: center; box-shadow: 0 25px 50px -12px rgba(0,0,0,.25); padding:2.5rem;">
                <header
                    style="padding:0.3rem; color:white; border-top-left-radius:1rem; border-top-right-radius:1rem; background-color:#b91c1c;">
                    <h1 style="font-weight:600;font-size: 1.875rem;">
                        You’ve Been Added on a Submit my Mortgage Deal
                    </h1>
                </header>
                <p style="font-size:1.5rem; line-height:2rem; font-weight:600; padding:2rem;">
                    <span style="margin-bottom: 0.5rem;">
                        {{-- Dear {{ $user->name ?? "" }} --}}
                    </span>
                    <br>
                    This is an important step in completing your mortgage application.
                    <br><br>
                    Click the link below to begin adding the necessary files to complete your mortgage deal:
                </p>
                <div style="text-white">
                    <a href="{{ $url }}"
                        style="text-decoration:none; font-size: 1.125rem;line-height: 1.75rem; padding-bottom: 0.75rem; padding-left: 1.25rem;padding-right: 1.25rem; border-radius: 0.375rem; color:white;padding-top: 0.75rem; font-weight:600;background-color:#b91c1c;">
                        Get Started
                    </a>
                </div>
                <p style="font-size: 1.5rem;line-height: 2rem; font-weight:600;">
                    if you have any queries or need assistance, please don't hesitate to reach out to our support
                    team.
                    <br><br>
                    Thank you for choosing Submit My Mortgage!
                </p>
            </div>
        </div>
    </div>
</body>

</html>
