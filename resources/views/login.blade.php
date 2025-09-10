<!-- resources/views/web.blade.php -->
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>SIMA - DISKOMINFO Kota Samarinda</title>

    <!-- Inter font (opsional) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">

    <style>
        /* Minimal reset agar positioning konsisten */
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: "Inter", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
        }
    </style>
</head>

<body>
    <div style="width: 1280px; height: 720px; position: relative; background: white; overflow: hidden">
        <img style="width: 426px; height: 426px; left: 108px; top: 147px; position: absolute" src="./assets/img/login.svg" />
        <div style="width: 651px; height: 77px; left: 128px; top: 41px; position: absolute; color: #3E267C; font-size: 28px; font-family: Inter; font-weight: 700; word-wrap: break-word">SIMA (Sistem Informasi Manajemen Aset)<br />DISKOMINFO Kota Samarinda</div>
        <div style="left: 900px; top: 203px; position: absolute; text-align: right; color: #3E267C; font-size: 32px; font-family: Inter; font-weight: 700; word-wrap: break-word">Login</div>
        <img style="width: 77px; height: 77px; left: 31px; top: 34px; position: absolute" src="./assets/img/logo.svg" />
        <div style="width: 365px; height: 66px; left: 761px; top: 445px; position: absolute">
            <div style="width: 365px; height: 66px; left: 0px; top: 0px; position: absolute; background: #6FB553; border-radius: 50px"></div>
            <div style="left: 152px; top: 21px; position: absolute; text-align: right; color: white; font-size: 20px; font-family: Inter; font-weight: 700; word-wrap: break-word">LOGIN</div>
        </div>
        <div style="width: 365px; height: 66px; left: 761px; top: 258px; position: absolute">
            <div style="width: 365px; height: 66px; left: 0px; top: 0px; position: absolute; background: #E8E8E8; border-radius: 50px"></div>
            <div style="width: 24px; height: 24px; left: 34px; top: 21px; position: absolute">
                <div style="width: 24px; height: 24px; left: 0px; top: 0px; position: absolute; opacity: 0"></div>
                <div style="width: 20px; height: 17px; left: 2px; top: 3.50px; position: absolute; background: #82898C"></div>
            </div>
            <div style="left: 86px; top: 21px; position: absolute; color: #82898C; font-size: 20px; font-family: Inter; font-weight: 400; word-wrap: break-word">Email</div>
        </div>
        <div style="width: 365px; height: 66px; left: 761px; top: 337px; position: absolute">
            <div style="width: 365px; height: 66px; left: 0px; top: 0px; position: absolute; background: #E5E5E5; border-radius: 50px"></div>
            <div style="left: 85px; top: 21px; position: absolute; text-align: right; color: #82898C; font-size: 20px; font-family: Inter; font-weight: 400; word-wrap: break-word">Password</div>
            <div data-style="bold" style="width: 24px; height: 24px; left: 314px; top: 21px; position: absolute">
                <div style="width: 20px; height: 17.13px; left: 2px; top: 3.43px; position: absolute; background: #82898C"></div>
                <div style="width: 5.71px; height: 5.71px; left: 9.15px; top: 9.14px; position: absolute; background: #82898C"></div>
                <div style="width: 24px; height: 24px; left: 24px; top: 24px; position: absolute; transform: rotate(-180deg); transform-origin: top left; opacity: 0"></div>
            </div>
            <div data-style="bold" style="width: 24px; height: 24px; left: 34px; top: 18px; position: absolute">
                <div style="width: 3.26px; height: 3.26px; left: 10.37px; top: 14.09px; position: absolute; background: #82898C"></div>
                <div style="width: 20px; height: 20px; left: 2px; top: 2px; position: absolute; background: #82898C"></div>
                <div style="width: 24px; height: 24px; left: 24px; top: 24px; position: absolute; transform: rotate(-180deg); transform-origin: top left; opacity: 0"></div>
            </div>
        </div>
        <div style="width: 351px; height: 351px; left: 1027px; top: -96px; position: absolute; background: linear-gradient(180deg, #3E267C 0%, #09A0D5 100%); border-radius: 9999px"></div>
        <div style="width: 351px; height: 334px; left: 805px; top: -168px; position: absolute; background: linear-gradient(180deg, #3E267C 0%, #09A0D5 100%); border-radius: 9999px"></div>
        <div style="width: 351px; height: 334px; left: 1377.77px; top: -114.80px; position: absolute; transform: rotate(113deg); transform-origin: top left; background: linear-gradient(180deg, #3E267C 0%, #09A0D5 100%); border-radius: 9999px"></div>
    </div>

    <!-- <div style="width: 365px; height: 66px; position: relative; border-radius: 50px">
        <div style="width: 365px; height: 66px; left: 0px; top: 0px; position: absolute; background: #6FB553; border-radius: 50px"></div>
        <div style="left: 152px; top: 21px; position: absolute; text-align: right; color: white; font-size: 20px; font-family: Inter; font-weight: 700; word-wrap: break-word">LOGIN</div>
    </div>
    <a style="width: 365px; height: 66px; position: relative" href="/asap">
        <div style="width: 365px; height: 66px; left: 0px; top: 0px; position: absolute; background: #6FB553; border-radius: 50px"></div>
        <div style="left: 152px; top: 21px; position: absolute; text-align: right; color: white; font-size: 20px; font-family: Inter; font-weight: 700; word-wrap: break-word">LOGIN</div>
    </a> -->
</body>

</html>