# CGI Calc

Casual Gaming Infrastructure - Calc PHP library.

[![License](https://img.shields.io/packagist/l/tmilos/cgi-calc.svg)](https://packagist.org/packages/tmilos/cgi-calc)
[![Build Status](https://travis-ci.org/tmilos/cgi-calc.svg?branch=master)](https://travis-ci.org/tmilos/cgi-calc)
[![Coverage Status](https://coveralls.io/repos/github/tmilos/cgi-calc/badge.svg?branch=master)](https://coveralls.io/github/tmilos/cgi-calc?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/tmilos/cgi-calc/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/tmilos/cgi-calc/?branch=master)


## Point

```php
$point = new Point(10, 10);
print $point->getX();
print $point->getY();
$leftPoint = $point->left();
$otherPoint = $point->move(new Point(2, 3));
```

## PointSet

```php
$set = new PointSet([new Point(10, 10), new Point(20, 20)]);
$set[new Point(10, 10)] = 'something';
$set->contains(new Point(10, 10)); // true
print $set[new Point(10, 10)]; // something

$other = new PointSet([new Point(10, 10), new Point(0, 0)]);
$unionSet = $set->union($other);
$intersectionSet = $set->intersect($other);
$differenceSet = $set->diff($other);
```

## Field Producers

```php
$rectangularProducer = new RectangularFromTwoPoints(new Point(0,0), new Point(3, 2), function (Point $point) {
    // value provider for the points of the generated rectangular
    return sprintf("%d : %d", $point->getX(), $point->getY());
});
$rect = $rectangularProducer->produce();
```

```php
$rectangularProducer = new RectangularFromTwoPoints(new Point(2,3), 10, 8);
$rect = $rectangularProducer->produce();
```

```php
$circleProducer = new CircularCenterRadius(new Point(10,10), 8);
$circle = $circleProducer->produce();
```


# License

Copyright [Milos Tomic](https://github.com/tmilos). This package is licensed under MIT, for details check the [LICENSE](LICENSE) file.