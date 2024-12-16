<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Ibell</title>
    <!-- <link href="{{asset('fonts/stylesheet.css')}}" rel="stylesheet"/> -->
  </head>
  <body>
    <table style=" width: 100%;font-family: sans-serif; font-size: 14px; ">
      <tbody>
        <tr>
          <td style="text-align: center; padding: 40px 0 10px;">
            <img src="{{asset('img/newlogo.jpg')}}" alt="" style="max-width: 200px;" />
          </td>
        </tr>
        <tr>
          <td style="text-align: center">
            <h2 style="font-weight: bold; margin: 40px 0 0; font-size: 26px; font-family: sans-serif;">ADDITIONAL WARRANTY CARD</h2>
            <!-- <h4 style="font-weight: 400; margin: 10px 0 0; font-size: 20px;">4 Years From Date of Purchase</h4> -->
            <img src="{{asset('img/badge.png')}}" style="position: absolute;right: 0px;top:-50px;width: 180px;" alt="">
          </td>
        </tr>
        <tr>
            <td style="padding: 50px 0 0">
                <!-- <ul style="text-align: center; list-style-type: none; margin: 0; padding: 0;">
                    <li style="border: 1px solid #d42e4d; border-radius: 8px; padding: 15px 20px; display: inline-block; font-size: 16px; margin: 5px;"><span style="font-weight: bold;">Name :</span>Dylan Aldridge</li>
                    <li style="border: 1px solid #d42e4d; border-radius: 8px; padding: 15px 20px; display: inline-block; font-size: 16px; margin: 5px;"><span style="font-weight: bold;">Order ID :</span>123456</li>
                    <li style="border: 1px solid #d42e4d; border-radius: 8px; padding: 15px 20px; display: inline-block; font-size: 16px; margin: 5px;"><span style="font-weight: bold;">Product :</span>Air Cooler</li>
                    <li style="border: 1px solid #d42e4d; border-radius: 8px; padding: 15px 20px; display: inline-block; font-size: 16px; margin: 5px;"><span style="font-weight: bold;">Model : </span>AIR123</li>
                    <li style="border: 1px solid #d42e4d; border-radius: 8px; padding: 15px 20px; display: inline-block; font-size: 16px; margin: 5px;"><span style="font-weight: bold;">Date of Purchase : </span>08July2024</li>
                    <li style="border: 1px solid #d42e4d; border-radius: 8px; padding: 15px 20px; display: inline-block; font-size: 16px; margin: 5px;"><span style="font-weight: bold;">Additional Warranty Period : </span>08July2024 - 08July2028</li>
                </ul> -->
                <table border="0" cellpadding="0" cellspacing="0" style="font-size: 14px; margin: 0 auto; width: 100%; ">
                    <tr>
                        <td style="padding: 13px 20px ; font-weight: bold; border:1px solid #e5e5e5">Name  </td>
                        <td style="padding: 13px 20px ; border:1px solid #e5e5e5"><span style="font-weight:normal">{{$collection['name']}}</span></td>
                    </tr>                   
                    <tr>
                        <td style="padding: 13px 20px ; font-weight: bold; border:1px solid #e5e5e5">Order ID  </td>
                        <td style="padding: 13px 20px ; border:1px solid #e5e5e5"><span style="font-weight:normal">{{$collection['order_id']}}</span></td>
                    </tr>                   
                    <tr>
                        <td style="padding: 13px 20px ; font-weight: bold; border:1px solid #e5e5e5">Product  </td>
                        <td style="padding: 13px 20px ; border:1px solid #e5e5e5"><span style="font-weight:normal">{{$collection['category']}}</span></td>
                    </tr>                   
                    <tr>
                        <td style="padding: 13px 20px ; font-weight: bold; border:1px solid #e5e5e5">Model  </td>
                        <td style="padding: 13px 20px ; border:1px solid #e5e5e5"><span style="font-weight:normal">{{$collection['model_no']}}</span></td>
                    </tr>
                    <tr>
                        <td style="padding: 13px 20px ; font-weight: bold; border:1px solid #e5e5e5">Date of Purchase  </td>
                        <td style="padding: 13px 20px ; border:1px solid #e5e5e5"><span style="font-weight:normal">{{$collection['date_of_purchase']}}</span></td>
                    </tr>                   
                    <tr>
                        <td style="padding: 13px 20px ; font-weight: bold; border:1px solid #e5e5e5">Additional Warranty Period  </td>
                        <td style="padding: 13px 20px ; border:1px solid #e5e5e5"><span style="font-weight:normal">{{$collection['warranty_period']}}</span></td>
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
          <td style="padding:0 0">
            <div style="padding: 30px 30px; background-color: rgb(0 0 0 / 3%);">            
              <h5 style="font-size: 14px; margin: 0 0 15px; font-weight: bold;">Terms & Conditions</h5>
              <ul style="padding: 0;margin: 0 0 0 20px;font-size: 14px;line-height: 1.8;">
                <li>
                  Please refer to all terms & conditions in the primary warranty
                  card and all those terms and conditions are applicable for the
                  additional warranty too
                </li>
                <li>
                  Primary card to be submitted together with this additional
                  warranty card, if and when a claim is made under additional
                  warranty agreement
                </li>
                <li>
                  Additional warranty is applicable only for the customers who
                  have registered with us
                </li>
              </ul>
            </div>
          </td>
         
        </tr>
        <tr>
          <td style="text-align:center; padding-top: 20px;">
            <img src="{{asset('img/approved.png')}}" style="width:180px" alt="">
          </td>
        </tr>
      </tfoot>
    </table>
  </body>
</html>
