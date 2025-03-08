<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background: linear-gradient(135deg, #f06595, #d50000);
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
            color: #d50000;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            max-width: 450px;
            width: 100%;
        }
        .container .icon {
            font-size: 80px;
            margin-bottom: 30px;
            color: #d50000;
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
        <div class="icon">✘</div>
        <h2>Payment Failed</h2>
        <p>There was an issue processing your payment. Please try again later.</p>
        <div class="message">If the issue persists, contact support.</div>
    </div>

</body>
</html>
