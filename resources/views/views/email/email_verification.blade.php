<html>
<head> 
</head>
<body>

    <div class="container">
        <div class="row">
            <header>
                <img src="{{ asset('production/images/logo.svg') }}" alt="Next Power" height="50">
            </header>
            <div class="main-content">
                <h1>Welcome to Next Power</h1>
           
                <p>Dear {{$maildata['user_name']}}</p>
                <a style="font-size: 20px;" href="{{$maildata['mesg']}}">Click here to verify your Email ID </a>
              
            </div>
            <footer>
                <p>Next Power © 2024 . Privacy Policy</p>
            </footer>
        </div>
    </div>
</body>
</html>