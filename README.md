# Multi Language Supports for Laravel

## WARNING

The routing dispatch strategy will be affected, do not apply to production environment without sufficient testing. 

All parameters must be explicitly defined in the method's parameter list, and the parameter names must match those defined in the route.

The following call may have an impact.

```php
class SomeController extends Controller
{
    // For route: /{a}/{b}/{c}
    // ❌ Method's parameter list is empty.
    public function method()
    {
        $a = func_get_args()[0];
        $b = func_get_args()[1];
        $c = func_get_args()[2];
    }
    
    // For route: /{a}/{b}/{c}
    // ❌ Parameter name does not match the variable name defined in the route.
    public function method($aa, $bb, $cc)
    {
        // ....
    }
    
    // For route: /{a}/{b}/{c}
    // ⚠️ The number of parameters does not match the number of variables defined in the route.
    public function method($a, $b)
    {
        $c = func_get_args()[2];
    }
    
    // For route: /{a}/{b}/{c}
    // ✅
    public function method($a, $b, $c)
    {
        // .....
    }
}
```

## Usage

```php
URL::defaults(['locale' => 'en-us']);
```

```php
Route::group([
    'prefix' => '/{locale?}',
], function (\Illuminate\Routing\Router $router) {
    $router->get('/{name}', 'Home@test')->name('home.test');
});
```

```php
class Home extends Controller
{
    public function test(string $name)
    {
        return $name;
    }
}
```