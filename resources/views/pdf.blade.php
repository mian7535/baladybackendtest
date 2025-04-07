
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate</title>
    <style type="text/css" media="all">
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@700&display=swap');

        @font-face {
            font-family: 'fruiti-black';
            src: url(fonts/FrutigerLTArabic45Light.ttf);
        }

        body {
            background: url('https://baladyapi.baxkit.com/pdf_asset/images/bg-body.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
            
        }

        .flower__background {
            background: url('https://baladyapi.baxkit.com/pdf_asset/images/main-background.png');
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
            position: fixed;
            top:0;
        }

        footer {
            background: #88a39c;
            height: 25px;
            width: 100%;
            position: fixed;
            bottom: 0;
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
            font-family: 'Tajawal', sans-serif;
            line-height: 36px;
            color: #097671;
            font-size: 28px;
            margin: 0;
        }

        p {
            font-family: 'fruiti-black';
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

<body>
    <header class=""></header>
    <div class="flower__background">
       
        <!-- main content -->
        <table>
            <tbody>
                <tr style="margin: 0px 32px;">
                    <td style="text-align: left; ">
                        <div class="logo-left" style="margin-top:40px;">
                            <img src="https://baladyapi.baxkit.com/pdf_asset/images/logo-left.png" class="img-fluid" alt="" style="padding-left: 12px;">
                        </div>
                    </td>
                    <td style="text-align: right;">
                        <div class="logo-right" style="margin-top:30px;">
                            <img src="https://baladyapi.baxkit.com/pdf_asset/images/logo-right.png" class="img-fluid" style="padding-right: 12px;" alt="">
                        </div>
                    </td>
                </tr>
                <tr >
                    <td colspan="2" style="text-align: center;">
                        <img src="https://baladyapi.baxkit.com/pdf_asset/images/bismillah.png" class="bismi-logo" alt="bismillah">
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center;">
                        <p>This is to certify that </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center;">
                        <h3>{{$user['student']['first_name']}} {{$user['student']['third_name']}} </h3>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center;">
                        <p class="widtho" style="margin: 0% 26%;">has been awarded the title of "Compliance Partner" as a result of completing the qualification phase to
                            the Visual Distortion Exam.</p>
                    </td>
                </tr>
                <tr><td></td></tr>
                <tr><td></td></tr>
                <tr><td></td></tr>
                <tr><td></td></tr>
                <tr>
                    <td >
                        <p class="issue" style="padding-top:120px;">Issue Date : {{$user['issue_date']}}</p>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- main content end -->
       
    </div>
    <footer class=""></footer>

</body>

</html>