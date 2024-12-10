<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Mail Template</title>
</head>

<body style="background:#E5E5E5; font-family: 'Source Sans Pro', sans-serif, Helvetica, Arial;">
<table border="0" cellpadding="0" cellspacing="0" style="margin:30px auto; max-width:700px; width:90%">
  <thead>
    <tr>
      <td style="text-align:center"></td>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="background:#fff; padding:25px 35px 35px; margin:30px auto; width:340px; max-width:100%;  border-top: 7px solid #818A8F; border-bottom: 7px solid #333F48;border-radius: 10px;"><table style="width: 100%;">
          <tr>
            <td style="text-align:center"><img src="{{asset('img/logo-ibell.png')}}" style="max-width:120px; margin: 0px 0 10px;"></td>
          </tr>
          <tr>
            <td><hr style="margin: 5px 0 20px;border: none !important;background: #edeaf2 !important;height: 1px;"></td>
          </tr>
          <tr>
            <td><h4 style="color:#3d4852; margin:0 0 10px 0;">Hello,</h4>
             <p> You have received a new extended warranty registration. Details below has been provided for quick reference only.</p> 
            </td>
          </tr>
          <tr>
          
          <table style='font-size: 11px; border-radius: 4px; padding: 25px; width: auto; font-family: Verdana,Geneva,sans-serif; color: #67757c; border: 2px solid #848a96;'>



<tbody>



  <tr>

    <td colspan='2' style='background-color: #d42e4d; color: rgb(250,250,250); padding: 10px; text-align: center;'>

      <p>Extended Warranty Registration</p>
    </td>

  </tr>

  

 

  <tr>

    <td width='170' style='background-color: #d42e4d; color: rgb(250,250,250); padding: 10px'>

      Name

    </td>

    <td style='border-bottom: 1px solid #d8e4ee; padding: 10px'>

      <span>{{$name}}</span>

    </td>

  </tr>

  <tr>

    <td width='170' style='background-color: #d42e4d; color: rgb(250,250,250); padding: 10px'>

     Contact Number

    </td>

    <td style='border-bottom: 1px solid #d8e4ee; padding: 10px'>

      <span>{{$contact_no}}</span>

    </td>

  </tr>

  <tr>

    <td width='170' style='background-color: #d42e4d; color: rgb(250,250,250); padding: 10px'>

      Order ID

    </td>

    <td style='border-bottom: 1px solid #d42e4d; padding: 10px'>

      <span>{{$order_id}}</span>

    </td>

  </tr>

  <tr>

<td width='170' style='background-color: #d42e4d; color: rgb(250,250,250); padding: 10px'>

  Model No.

</td>

<td style='border-bottom: 1px solid #d42e4d; padding: 10px'>

  <span>{{$model_no}}</span>

</td>

</tr>

  <tr>

    <td width='170' style='background-color: #d42e4d; color: rgb(250,250,250); padding: 10px'>

      Product Category

    </td>

    <td style='border-bottom: 1px solid #d8e4ee; padding: 10px'>

      <span>{{$category}}</span>

    </td>

  </tr>
  <tr>
  <tr>

<td width='170' style='background-color: #d42e4d; color: rgb(250,250,250); padding: 10px'>

Documents/Screenshot

</td>

<td style='border-bottom: 1px solid #d8e4ee; padding: 10px'>

<a href="{{url($doc_path)}}" target="_blank">View </a>

</td>

</tr>
<tr>
<tr>

<td width='170' style='background-color: #d42e4d; color: rgb(250,250,250); padding: 10px'>

Extended Certificate

</td>

<td style='border-bottom: 1px solid #d8e4ee; padding: 10px'>

<a href="{{url($certificatePath)}}" target="_blank">View </a>

</td>

</tr>
<tr>

<td width='170' style='background-color: #d42e4d; color: rgb(250,250,250); padding: 10px'>

  Timestamp

</td>

<td style='border-bottom: 1px solid #d8e4ee; padding: 10px'>

  <span>{{$created_at}}</span>

</td>

</tr>


</tbody>



</table>

          </tr>
          <tr>
            <td style="height: 20px;"></td>
          </tr>
        </table>
       </td>
    </tr>
  </tbody>
  <tfoot>
    <tr>
      <td style="height: 30px;"></td>
    </tr>
 

    <tr>
      <td style="text-align:center; padding:30px 0; color:#8d99ab; font-size:14px; line-height:1.4; margin:0">© <?php echo date('Y');?> Ibelltools. All Rights Reserved.
    </tr>

  </tfoot>
</table>
</body>
</html>
