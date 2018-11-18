# Changelog

## Version 1.2
- Added `diff` and `slice` methods to `BaseCollection` class.
- Extracted `contains` method from `ArrayList` to `BaseCollection`, now is available on all child classes.
- Removed `find` method from `ArrayList`, `Dictionary`, and `GenericList` classes.
- Removed `search` method from `GenericList` class.
- Updated documentation.

## Version 1.3
- Added `equals` method to `BaseCollection` class.
- Added `sum` method to `BaseCollection` class.
- Replaced `is_a` native function by `instanceof` operator.