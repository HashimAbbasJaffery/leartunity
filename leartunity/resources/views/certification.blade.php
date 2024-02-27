<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Certificate</title>
    <style>
        body {
            border: 1px solid black;
            padding: 30px;
        }
        body, html {
            height: 100%;
            margin: 0;
        }
        .center {
            width: 90%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        * {
            font-family: sans-serif;
            text-align: center
        }
        .completion {
            font-size: 40px;
            border-bottom: 1px solid black;
            padding-bottom: 10px;
        }
        .name {
            border: none;
            font-size: 30px;
        }
    </style>
</head>
<body>
    <div class="certificate center">
        <h1 class="completion">Certificate Of Completion</h1>
        <p style="font-size: 50px;">This is to certify that <strong>{{ $name }}</strong> successfully completed {{ $duration }} hours of <srong>{{ $course_title }}</strong> online course on {{ $awarded_date }}</p>
        <h1 class="logo">Leartunity.</h1>
    </div>
</body>
</html>