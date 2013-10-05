Asynchronous port scanner in PHP
==============

An asynchronous port scanner in PHP

```php
$ss = new PortScan\Scanner;
$ss->setTimeout(2);

$ss->addTest('dante.yuso.be', 80);
$ss->addTest('google.com', 80);
$ss->addTest('1.2.3.4', 80);

$ss->scan();
var_dump($ss->results);
```

Keywords: multi threaded port scan status check checker scanner open closed
