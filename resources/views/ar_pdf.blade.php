
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate</title>
    <style type="text/css" media="all">
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@700&display=swap');

        @font-face {
            font-family: 'dejavu sans', sans-serif;
            src: url('pdf_asset/fonts/DejaVuSans.ttf');
        }

        body {
            background: url('pdf_asset/images/bg-body.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
            font-family: 'dejavu sans', sans-serif;

        }

        .flower__background {
            background: url('pdf_asset/images/main-background.png');
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        header {
            background: #88a39c;
            height: 30px;
            width: 100%;
        }

        footer {
            background: #88a39c;
            height: 25px;
            width: 100%;
        }

        .banner__logos {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 8px 28px;
        }

        .certificate__content {
            height: 100%;
            width: 100%;
            position: absolute;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        h3 {
            font-family: Arial;
            line-height: 36px;
            color: #097671;
            font-size: 28px;
            margin: 0;
        }

        p {
            font-family: Arial;
            font-size: 20px;
            line-height: 38px;
            color: #000;
            text-align: center;
            font-weight: 700;
        }
        .issue__date {
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: end;
            width: 10%;
            text-align: right;
            margin-bottom: 1.4rem;
            margin-left: 1rem;
        }

        p.issue {
            margin: 0;
            text-align: left;
            padding-left: 24px;
        }
        p.dated {
            text-align: left;
            padding-left: 32px;
            margin-top: 0;
        }
        .bismi-logo {
            width: 10rem;
            margin-bottom: 1rem;
        }

    </style>
</head>

<body  style="font-family:Arial">
    <header class=""></header>
    <div class="flower__background">

        <!-- main content -->
        <table>
            <tbody>
                <tr style="margin: 0px 32px;">
                    <td style="text-align: left; ">
                        <div class="logo-left" style="margin-top:40px;">
                            <img src="{{ url('pdf_asset/images/logo-left.png') }}" class="img-fluid" alt="" style="padding-left: 12px;">
                        </div>
                    </td>
                    <td style="text-align: right;">
                        <div class="logo-right" style="margin-top:30px;">
                            <img src="{{ url('pdf_asset/images/logo-right.png') }}" class="img-fluid" style="padding-right: 12px;" alt="">
                        </div>
                    </td>
                </tr>
                <tr >
                    <td colspan="2" style="text-align: center;">
                        <img src="{{ url('pdf_asset/images/bismillah.png') }}" class="bismi-logo" alt="bismillah">
                    </td>
                </tr>
                <tr>
                    <td  dir="rtl" lang="ar" colspan="2" style="text-align: center;">
                        <p>تشهد أكاديمية بلدي أن
                        </p>
                    </td>
                </tr>
                <tr>
                    <td  colspan="2" style="text-align: center;">
                        <h3>{{$user['student']['first_name']}} {{$user['student']['family_name']}} </h3>
                    </td>
                </tr>
                <tr>
                    <td dir="rtl" lang="ar" colspan="2" style="text-align: center;">
                        <p class="widtho" style="margin: 0% 26%;">
                            قد حصل على لقب " شريك الامتثال " نتيجة لإتمامه مرحلة التأهيل للرقابة على "التشوه البصري"
                        </p>
                    </td>
                </tr>
                <tr><td></td></tr>
                <tr><td></td></tr>
                <tr><td></td></tr>
                <tr><td></td></tr>
                <tr>
                    <td >
                        <p class="issue" style="padding-top:120px;">تاريخ اصدار الشهادة
                            <br> {{$user['issue_date']}}</p>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- main content end -->

    </div>
    <footer class=""></footer>

</body>

</html>
