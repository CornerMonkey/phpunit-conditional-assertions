# Conditional assertions for PHPUnit

This library adds the ability conditionally call any exiting assertions for
[PHPUnit](https://phpunit.de/). Inspiration for this library came from Pest's conditional expectations
and the desire to have the similar functionality in PHPUnit.

## Author and copyright

Tim Lawson <tim@lawson.fyi>  
This library is [MIT-licensed](LICENSE.md).

## Installation

    $ composer require --dev cornermonkey/phpunit-conditional-assertions

## Compatibility

This package is compatible with PHP 8.0 and later, and PHPUnit 8.0 and later.

## Usage

Simply use the trait `CornerMonkey\ConditionalAssertions\ConditionalAssertionTrait` in your test case. This
trait adds an `when` and `unless` methods to your test case. 

Example:

```php
<?php
use CornerMonkey\ConditionalAssertion\ConditionalAssertionTrait;
use PHPUnit\Framework\TestCase;

class MyTestCase extends TestCase
{
  use ConditionalAssertionTrait;

  public function testConditionIsValid()
  {
    
    $this->when(true)->assertThat(true, true);
    $this->when(false)->assertThat(true, true);    // This assertion will not be called
    $this->unless(true)->assertThat(true, true);   // This assertion will not be called
    $this->unless(false)->assertThat(true, true);
    
  }
}
```

You can also pass a callback to the `when` and `unless` methods. The supplied callback will be called 
when the condition is true.

```php
<?php
use CornerMonkey\ConditionalAssertion\ConditionalAssertionTrait;
use PHPUnit\Framework\TestCase;

class MyTestCase extends TestCase
{
  use ConditionalAssertionTrait;
   
  public function dataProvider()
  {
    return [
      [true],
      [false]
    ];
  }
  /** 
    * @dataProvider dataProvider
    */
  public function testIfExceptionShouldBeThrown($shouldThrow)
  {
    $this->when($shouldThrow, function(TestCase $testCase, $value) {
      $testCase->expectException(Exception::class);
    });
    
    if ($shouldThrow) {
      throw new Exception();
    }
  }
}
```
