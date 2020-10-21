
<?php
$pattern = '/[c,m,e][\d][\d][\d][\d][\d][\d]\D/g';
$replacement = '';
$body = eregi_replace($pattern, $replacement, $body);
?>
