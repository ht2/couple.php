# Merge

```php
// Gets the class.
$couple = new ht2\couple\Merge();

// Creates the arguments.
$needle = [
  'a' => 1,
  'b' => 1
];
$haystack = [
  'b' => 2,
  'c' => 2
];

// Runs the couple.
$couple->run($needle, $haystack);

/*
Returns `[
  'a' => 1,
  'b' => 1,
  'c' => 2
]
*/
```
