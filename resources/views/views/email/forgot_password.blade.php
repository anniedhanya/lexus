<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<style>
html { background: #679324; font-family: 'Open Sans', Helvetica, Arial, sans-serif; }
table { border-collapse: collapse; width: 100%; }
td, th { border: 1px solid #dddddd; text-align: left; padding: 15px; }
.logo { text-align: center; width: 100%; float: left; padding: 30px 0 }
p { width: 100%; max-width: 850px; margin: 15px auto; font-size: 14px; line-height: 25px; color: #565353; font-weight: 500; letter-spacing: 1px; }
#mail { width: 80%; box-shadow: 2px 4px 20px #e2d7d7; margin: 30px auto; min-height: 550px; background: #fff; padding: 0 15px 30px 15px; }
b { color: #1ec838; }
.gif { width: 60px; margin: 15px auto; float: none; display: block; }
.button { background-color: #679324; /* Green */ border: none; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; -webkit-transition-duration: 0.4s; /* Safari */ transition-duration: 0.4s; }
.button:hover { box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19); }
.columns { width: 100%; padding: 8px; display: block; max-width: 850px; margin: 0 auto; float: none; }
.price { list-style-type: none; border: 1px solid #eee; margin: 0; padding: 0; -webkit-transition: 0.3s; transition: 0.3s; }
.price:hover { box-shadow: 0 8px 12px 0 rgba(0,0,0,0.2) }
.price .header { background-color: #111; color: white; font-size: 25px; }
.price li { border-bottom: 1px solid #eee; padding: 20px; text-align: center; }
.price .grey { background-color: #eee; font-size: 20px; }
.button { background-color: #4CAF50; border: none; color: white; padding: 10px 25px; text-align: center; text-decoration: none; font-size: 18px; }
.blue-box { max-width: 600px; margin: 20px auto; border-radius: 5px; border: 1px solid #bdbbbb; text-align: center; overflow: hidden }
.blue-box h2 { padding: 20px 15px; background: #679324; margin-top: 0; color: #fff; font-weight: 500; font-size: 20px; }
.blue-box p { font-size: 13px; font-weight: 400; }
.btn { background: #679324; color: #fff; display: inline-block; font-weight: 400; text-align: center; white-space: nowrap; vertical-align: middle; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; border: 1px solid transparent; padding: .475rem .95rem; font-size: 13px; line-height: 1.5; border-radius: .25rem; transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out; color: #fff!important; margin-bottom: 20px; }
a { text-decoration: none }
a:hover { box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19); }

@media only screen and (max-width: 600px) {
.columns { width: 100%; }
}
.full-width { width: 100%; }
.ii a[href]{
	color: #eff4fc;
}
</style>
</head>

<body style="padding:0; margin:0">
<section id="mail">
 
 
 <h3 style="text-align:center;color: #679324;font-size: 26px;font-weight: bolder;">Password Reset Request Submitted </h3>
 <p> Hi,<br>
  You are receiving this email because we received a password reset request for your account.</p>
 <div class="blue-box">
  <h2>Password Reset Link</h2>
  <p><?= @$inputData['unique_no'] ?> " is OTP to access your Next Power account. OTP is valid for 24hr. Do not share your OTP with anyone.</p>
   </div>
 
 <!-- <p> Click below for more plans <br>
  <a class="plan button" href="#">Click here</a></p>-->
 <p style="text-align:right">Thank you</p>
</section>
</body>
</html>



