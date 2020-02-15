<?php

$offer = $_GET['offer'];
$currency = (object)$_GET['currency'];

?>
<html>
<body>

<h3>You received an offer!</h3>

<p><u>Amount</u>:
  <b><?= $offer ?> <?= $currency->code ?></b> (<?= $currency->name ?>)
  <i style="font-size: .75em">code: <?= $currency->number ?></i>
</p>

</body>
</html>
