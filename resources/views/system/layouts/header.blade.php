<div id="header">
    <table width="100%" border="0">
        <tr>
            <td align="left"><br/><br/><strong><span class="textblue-xlarge">{{config('app.name')}}管理後台</span></strong>
            </td>
            <td align="right" valign="bottom" class="textblue-medium">  <a href="/" target="_blank">前台瀏覽 | </a>
                <span>
                    <form action="/logout" method="post" style="display: inline">
                        {{ csrf_field() }}
                        <button type="submit"
                                style="width:80px;height:30px;background-color:#fbbca8;font-size: large;font-weight:bold; padding:0; border: 1px solid #fb9073;"
                        >登出</button>
                    </form>
                </span>
            </td>
            <td width="240" align="right" valign="bottom" class="textblue-medium"></td>
        </tr>
    </table>
</div>