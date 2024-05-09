<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register Email</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        td {
            padding: 10px;
        }
    </style>
</head>

<body style="background-color: #edf2f7;">
    @php($user = Auth::user())
    <div style="padding: 50px">
        <div style="text-align: center;">
            <h2>
                <span style="color:black;">
                    SubmitMyMortgage
                </span>
            </h2>
            <div
                style="height: 50%; background-color:white; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, .25); padding:3rem; margin-bottom:20px;">
                {{-- <h3 style="font-size: 1.125rem; line-height: 1.75rem;text-align:left; color:black;" class="text-lg">
                    Hello!</h3> --}}
                <p style="color:black; font-size: 1rem; margin-top: 0.5rem; text-align:left;">
                <table style="border: 1px solid black;" width="100%">
                    <thead>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="border-bottom:1px solid black; border-right:1px solid black;">User Name</td>
                            <td style="border-bottom:1px solid black;">{{ $user->name }}
                            </td>
                        </tr>
                        <tr>
                            <td style="border-bottom:1px solid black; border-right:1px solid black;">User email</td>
                            <td style="border-bottom:1px solid black;">{{ $user->email }}
                            </td>
                        </tr>
                        <tr>
                            <td style="border-bottom:1px solid black; border-right:1px solid black;">Training Date</td>
                            <td style="border-bottom:1px solid black;">
                                {{ $user->training->start_date }}</td>
                        </tr>
                        <tr>
                            <td style="border-right:1px solid black;">Training time</td>
                            <td>{{ $user->training->start_time ?? $time .' AM'}}</td>
                        </tr>
                    </tbody>
                </table>
                </p>
                {{-- <p style="color:black;text-align:left;font-size: 1rem;" class="text-md">
                    Regards,<br> SubmitMyMortgage
                </p> --}}
                {{-- <hr style="margin-top: 0.5rem;" class="my-3"> --}}
            </div>
            <small style="color:black">© {{ date('Y') }} SubmitMyMortgage. All rights reserved.</small>
        </div>
    </div>
</body>

</html>
