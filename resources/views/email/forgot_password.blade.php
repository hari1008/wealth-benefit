<p> Hi {{$name}}, </p>
<p>We’ve received a request to change your password.</p>
<p>If you made this request, please click on the link below to reset your password using our secure server.</p>
<p>Else, you can ignore this email and your password will remain as is.<p>
<p><a href="{{ url('password/reset/'.$token) }}">Reset Password</a><p>
<p>To keep your Benefit profile secure, please regularly update your password.</p>
<p>Regards,</p>
<p>Benefit Team</p>