<?php
$qrdata = site_url($qrdata);
QRcode::png($qrdata,false,QR_ECLEVEL_H,3);
