<?php


namespace Source\support;
require_once("../../vendor/autoload.php");


class SendMail
{
    public function disparaEmail($to, $message, $assunto)
    {

        $header = '<html>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<body>			
<table class="table" style="height: 40px; border-color: black; margin-left: auto; margin-right: auto; width: 500px;" border="1">
<thead>
</thead>
<tbody>
<tr style="height: 37px;">
<td style="width: 10px; text-align: center; height: 37px;"><img style="display: block; margin-left: auto; margin-right: auto;" src="http://tidev.tmsa.ind.br/Intranet/Content/Images/logoClient.png" alt="" width="144" height="34" /></td>
<td style="width: 80px; height: 40px; text-align: center;"><img style="display: block; margin-left: auto; margin-right: auto;" src="http://mova.tmsa.ind.br/mova/assets/images/LogoMOVA.png" alt="" width="144" height="49" /></td>
<td style="width: 80px; height: 40px; text-align: center;"><img style="display: block; margin-left: auto; margin-right: auto;" src="http://mova.tmsa.ind.br/mova/assets/images/pdca.png" alt="" width="69" height="59" /></td>


</tbody>
</table>
<br>
<table class="table" style="height: 25px; border-color: black; margin-left: auto; margin-right: auto; width: 1000px;" border="1">
<thead>
</thead>
<tbody>';

        $footer = '</tr>
</tbody>
</table>
</body>
</html> ';

        $sender = $header.$message.$footer;
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From:' . 'MOVA TMSA' . '<mova@tmsa.ind.br>' . "\r\n";

        mail($to, $assunto, $sender, $headers);


    }
}
