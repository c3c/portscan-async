Asynchronous port scanner in PHP
==============

This package offers a portscan utility to determine if a host is reachable on a certain (TCP) port or not.

#### Scenario

A status pages has to report if certain hosts are online. 
Using the normal methods, each host will be checked sequentially, which is slow.
Thanks to this class, all of the checks are performed asynchronously, and the status of all hosts can be checked in a non-blocking way.

## Functions

  * `setTimeout($float)` : timeout for all checks to terminate
  * `addTest($host, $port)` : add a host to test

## Example

```php
$ss = new PortScan\Scanner;
$ss->setTimeout(2);

$ss->addTest('yahoo.com', 80);
$ss->addTest('google.com', 80);
$ss->addTest('1.2.3.4', 80);

$ss->scan();
var_dump($ss->results);
```

##### Result:

```
array(3) {
  ["google.com"]=>
  array(1) {
    [80]=>
    int(0)
  }
  ["yahoo.com"]=>
  array(1) {
    [80]=>
    int(0)
  }
  ["1.2.3.4"]=>
  array(1) {
    [80]=>
    int(10060)
  }
}
```

------------
Keywords: 
 multi threaded port scan status check checker scanner open closed non-blocking
