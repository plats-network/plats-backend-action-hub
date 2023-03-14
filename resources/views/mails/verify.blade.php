<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Xin chào,</h2>

<div>
    Tài khoản của bạn tại website Plats đang chờ kích hoạt. Để kích hoạt, bạn hãy click vào link dưới đây:
    <br/>
    URL : <a href="{{ \URL::temporarySignedRoute(VERIFY_EMAIL,now()->addMinutes(config('auth.url_reset_password_timeout')), $confirmation_code) }}">{{ \URL::temporarySignedRoute(VERIFY_EMAIL,now()->addHours(config('auth.url_reset_password_timeout')), $confirmation_code) }}</a>
    <br/>
    Trân trọng,
</div>

</body>
</html>


