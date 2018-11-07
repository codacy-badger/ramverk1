<?php

namespace Anax\View;

?>
<div class="flex-row">
    <div class="">
        <h1>Ip-validator</h1>
        <form class="box-margin-right stylechooser" method="post" action="<?= url("ip/check") ?>">
            <label for="">Ipv4/Ipv6-adress</label>
            <input type="text" name="ip" value="">
            <input type="submit" name="submit" value="Check">
        </form>
    </div>
    <div class="flex-column">
        <h3>REST-API Examples</h3>
        <p>Use the API with the query: rest/index/[argument]</p>
        <a href="rest/index/127.0.0.55.55">Non valid ip</a>
        <a href="rest/index/127.0.0.1">Valid ipv4</a>
        <a href="rest/index/FE80:CD00:0000:0CDE:1257:0000:211E:729C">Valid ipv6</a>
    </div>
</div>
