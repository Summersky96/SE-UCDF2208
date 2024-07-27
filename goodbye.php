<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Goodbye</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
            background: #f0f0f0;
            color: #333;
            overflow: hidden;
            margin: 0;
        }
        .container{
            display: flex;
            justify-content: center;
            align-items: center;
            background: hsla(180,0%,10%,0.8);
            width: 100%;
            height: 100%;
        }
        .message {
            text-align: center;
            color: #f0f0f0;
            padding: 50px;
            border: 2px solid rgba(255,255,255,5);
            backdrop-filter: blur(20px);
            box-shadow: 0 0 30px rgba(0,0,0,.5);
            border-radius: 20px;
        }
        .message h1 {
            font-size: 2em;
        }
        .message p {
            font-size: 1.2em;
        }
        .message a{
            color: #ffe000;
        }
        @media (min-aspect-ratio: 16/9){
            .backgroundVideo{
                width: 100%;
                height: auto;
            }
        }
        @media (max-aspect-ratio: 16/9){
            .backgroundVideo{
                width: auto;
                height: 100%;
            }
        }
        .backgroundVideo{
            position: absolute;
            right: 0;
            bottom: 0;
            z-index: -1;
        }
    </style>
</head>
<body>
<video autoplay loop muted plays-inline class="backgroundVideo">
        <source src="pfpvid.mp4" type="video/mp4">
    </video>
    <div class="container">
        <div class="message">
            <h1>Account Deleted</h1>
            <p>Thank you for using our service. Your account has been successfully deleted.</p>
            <p><a href="loginpage1.php">Return to Home</a></p>
        </div>
    </div>
</body>
</html>
