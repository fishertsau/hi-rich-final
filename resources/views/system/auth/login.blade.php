<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>無標題文件</title>
    <link href="/system/css/systemcss.css" rel="stylesheet" type="text/css"/>
    <style type="text/css">
        form {
            position: relative;
            width: 305px;
            margin: 15px auto 0 auto;
            text-align: center;
        }

        input {
            width: 270px;
            height: 20px;
            line-height: 20px;
            margin-top: 25px;
            padding: 11px 15px;
            background: #2d2d2d;
            background: rgba(45, 45, 45, .15);
            -moz-border-radius: 6px;
            -webkit-border-radius: 6px;
            border-radius: 6px;
            border: 1px solid #3d3d3d;
            border: 1px solid rgba(255, 255, 255, .15);
            -moz-box-shadow: 0 2px 3px 0 rgba(0, 0, 0, .1) inset;
            -webkit-box-shadow: 0 2px 3px 0 rgba(0, 0, 0, .1) inset;
            box-shadow: 0 2px 3px 0 rgba(0, 0, 0, .1) inset;
            font-family: "microsoft yahei";
            font-size: 14px;
            color: #fff;
            text-shadow: 0 1px 2px rgba(0, 0, 0, .1);
            -o-transition: all .2s;
            -moz-transition: all .2s;
            -webkit-transition: all .2s;
            -ms-transition: all .2s;
        }

        input:-moz-placeholder {
            color: #fff;
        }

        input:-ms-input-placeholder {
            color: #fff;
        }

        input::-webkit-input-placeholder {
            color: #fff;
        }

        input:focus {
            outline: none;
            -moz-box-shadow: 0 2px 3px 0 rgba(0, 0, 0, .1) inset, 0 2px 7px 0 rgba(0, 0, 0, .2);
            -webkit-box-shadow: 0 2px 3px 0 rgba(0, 0, 0, .1) inset, 0 2px 7px 0 rgba(0, 0, 0, .2);
            box-shadow: 0 2px 3px 0 rgba(0, 0, 0, .1) inset, 0 2px 7px 0 rgba(0, 0, 0, .2);
        }

        button {
            cursor: pointer;
            width: 300px;
            height: 44px;
            margin-top: 25px;
            padding: 0;
            background: #ef4300;
            -moz-border-radius: 6px;
            -webkit-border-radius: 6px;
            border-radius: 6px;
            border: 1px solid #ff730e;
            -moz-box-shadow: 0 15px 30px 0 rgba(255, 255, 255, .25) inset, 0 2px 7px 0 rgba(0, 0, 0, .2);
            -webkit-box-shadow: 0 15px 30px 0 rgba(255, 255, 255, .25) inset, 0 2px 7px 0 rgba(0, 0, 0, .2);
            box-shadow: 0 15px 30px 0 rgba(255, 255, 255, .25) inset, 0 2px 7px 0 rgba(0, 0, 0, .2);
            font-family: "microsoft yahei";
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            text-shadow: 0 1px 2px rgba(0, 0, 0, .1);
            -o-transition: all .2s;
            -moz-transition: all .2s;
            -webkit-transition: all .2s;
            -ms-transition: all .2s;
        }

        button:hover {
            -moz-box-shadow: 0 15px 30px 0 rgba(255, 255, 255, .15) inset, 0 2px 7px 0 rgba(0, 0, 0, .2);
            -webkit-box-shadow: 0 15px 30px 0 rgba(255, 255, 255, .15) inset, 0 2px 7px 0 rgba(0, 0, 0, .2);
            box-shadow: 0 15px 30px 0 rgba(255, 255, 255, .15) inset, 0 2px 7px 0 rgba(0, 0, 0, .2);
        }

        button:active {
            -moz-box-shadow: 0 15px 30px 0 rgba(255, 255, 255, .15) inset, 0 2px 7px 0 rgba(0, 0, 0, .2);
            -webkit-box-shadow: 0 15px 30px 0 rgba(255, 255, 255, .15) inset, 0 2px 7px 0 rgba(0, 0, 0, .2);
            box-shadow: 0 5px 8px 0 rgba(0, 0, 0, .1) inset, 0 1px 4px 0 rgba(0, 0, 0, .1);
            border: 0px solid #ef4300;
        }
    </style>


</head>

<body onload="generateVerificationCode()">
<div id="login"><img src="/system/images/people.png" width="61" height="64"/><br/>
    後台系統登入
    <form action="/login" method="post" onsubmit="return validateVerification()">
        {{ csrf_field() }}
        <input type="text" name="name" placeholder="用户帳號" required>
        <input type="password" name="password" placeholder="密碼" required>
        <input type="text" name="verification" placeholder="請輸入下方驗證碼" required>
        <span id="securityCode">526</span>
        <button type="submit">登錄</button>
    </form>
</div>

@include('system.layouts.footer')

<script type="text/javascript">
    function generateVerificationCode() {
        document.querySelector('#securityCode').innerText = randomFixedInteger(3);
    }

    const randomFixedInteger = function (length) {
        return Math.floor(Math.pow(10, length - 1) + Math.random() * (Math.pow(10, length) - Math.pow(10, length - 1) - 1));
    }

    function validateVerification() {
        let verification = document.querySelector("input[name='verification']").value;
        let random = document.querySelector('#securityCode').innerText;

        if (!(verification.toString() === random)) {
            alert('請輸入正確認證碼');
            document.querySelector("input[name='verification']").value = '';
            document.querySelector("input[name='verification']").focus();
            return false;
        }

        return true;
    }
</script>
</body>
</html>