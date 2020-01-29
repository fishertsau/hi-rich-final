<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{$webConfig->title}}</title>
    <link href="/system/css/systemcss.css" rel="stylesheet" type="text/css"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
    <style>
        [v-cloak] {
            display: none;
        }
    </style>
</head>

<body>
@include('system.layouts.header')

<table width="100%" border="0">
    <tr>
        <td width="250" align="left" valign="top">
            @include('system.layouts.menu')
        </td>
        <td valign="top">
            @yield('content')
        </td>
    </tr>
</table>

@include('system.layouts.footer')

@yield('pageJS')
</body>
</html>
