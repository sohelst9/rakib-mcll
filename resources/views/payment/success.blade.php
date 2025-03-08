<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background: linear-gradient(135deg, #56ccf2, #2f80ed);
            font-family: 'Arial', sans-serif;
            color: white;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            text-align: center;
        }
        .container {
            background-color: #ffffff;
            color: #4caf50;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            max-width: 450px;
            width: 100%;
        }
        .container .icon {
            font-size: 80px;
            margin-bottom: 30px;
            color: #4caf50;
        }
        h2 {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        p {
            font-size: 18px;
        }
        .message {
            font-size: 18px;
            font-weight: 500;
            margin-top: 20px;
            color: #333;
        }
        .background-animation {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.1);
            animation: moveBackground 5s ease-in-out infinite;
        }
        @keyframes moveBackground {
            0% { transform: translateX(0); }
            50% { transform: translateX(50%); }
            100% { transform: translateX(0); }
        }
    </style>
</head>
<body>

    <div class="background-animation"></div>

    <div class="container">
        <div class="icon">✔</div>
        <h2>Payment Successful</h2>
        <p>Your payment has been processed successfully.</p>
        <div class="message">You can now enjoy your service.</div>
    </div>

</body>
</html>
