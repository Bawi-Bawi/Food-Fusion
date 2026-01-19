<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your email confirmation code</title>
    <style>
         h3,p {
                text-align: center;
            }

            .card ,.footer {
                display: flex;
                justify-content: center;
                margin-top: 10px;
            }
           .box{
             width: 70px;
             padding: 5px;
             margin-top: 20px;
             background-color: orange;
             border: 1px solid black;
             border-radius: 5px;
             text-align: center;
           }
           small{
            color: gray;
           }
    </style>
</head>
<body>
    <h3>One more step to sign up</h3>
    <p> We got your request to create an account. Here's your confirmation code:</p>
    <div class="card">
        <div class="box">{{  $code }}</div>
    </div>
    <div class="footer">
         <small>Don't share this code with anyone.</small>
    </div>
</body>
</html>
