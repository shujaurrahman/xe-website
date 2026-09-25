<?php /* DRAFT COPY — review before launch */
/* Services & packages — the shared catalogue (partials/services/catalogue.php), fed by the
   'marketing-technology' key in data/services/marketing-technology.php. It is deliberately identical on
   every page and is not restyled here; this page's CSS is scoped to .mth-* so nothing leaks into .svc-*.
   It sits immediately before the FAQ, the same place as on every other hub. */
$svc_key = 'marketing-technology';
include __DIR__ . '/../services/catalogue.php';
