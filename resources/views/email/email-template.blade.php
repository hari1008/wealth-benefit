<!DOCTYPE html>
<html style="height:100%;">
<head>
    <title>Benefit Wellness Email</title>
</head>
<body style="font-family: 'Lato', sans-serif, arial; color:#626262; font-size:15px; line-height:1.4; height:100%;margin:0 auto;padding:0;display:table;">
    <div style="display: table-cell;text-align: center;vertical-align: middle;width:640px;">
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse; max-width:640px; background-color:#1fb1dd;height:450px;color:#fff;">
            <tr>
                <td align="center" style="border-bottom:1px solid #eaeaea; padding:15px 0 12px; color: #fff;">
                    <a href="{{env('APP_URL','#')}}"><img src="{{asset('images/logo.png')}}" title="benefitwellness" height="60"></a>
                </td>
            </tr>
            <tr>
                <td style="padding:25px">
                    @yield('body')
                </td>
            </tr>
            <tr>
                <td style="padding:25px">
                    <p style="margin-top:25px">
                        <a href="#"><img src="{{asset('images/appstore.png')}}" alt="" width="174"></a>
                    </p>
                    <p style="margin-top:25px">App for ios and andriod</p>
                    <p style="margin-top:25px">For any queries or concerns, write to us at</p>
                    <p style="margin-bottom:0;">Regards</p>
                    <p style="margin:0">(<span style="font-size:14px;">benefitwellness</span>)</p>
                </td>
            </tr>
            <tr>
                <td style="border-top:1px solid #eaeaea; padding:15px 15px 12px;">
                    <table width="100%" style="border-collapse: collapse;">
                        <tbody>
                            <tr>
                                <td align="center">
                                    <p style="font-size: 12px">© <span class="date">2016</span> benefitwellness. All rights reserved.</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
