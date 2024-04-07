# Multi Language Supports for Laravel

## WARNING

会影响路由调度策略。在充分测试前请勿用于生产环境。

所有路由参数都必须显式定义在方法参数列表中，并且参数名称必须和路由定义的占位符名称一致。

一些举例

```php
class SomeController extends Controller
{
    // 路由: /{a}/{b}/{c}
    // ❌ 方法参数列表为空
    public function method()
    {
        $a = func_get_args()[0];
        $b = func_get_args()[1];
        $c = func_get_args()[2];
    }

    // 路由: /{a}/{b}/{c}
    // ❌ 参数名称和路由定义占位符名称不一致
    public function method($aa, $bb, $cc)
    {
        // ....
    }

    // 路由: /{a}/{b}/{c}
    // ❗ 方法参数数量和路由定义中的参数数量不一致
    public function method($a, $b)
    {
        $c = func_get_args()[2];
    }

    // 路由: /{a}/{b}/{c}
    // ✅ 正确
    public function method($a, $b, $c)
    {
        // .....
    }

    // 路由: /{a}/{b}/{c}
    // ✅ 允许顺序不一致
    public function method($c, $a, $b)
    {
        return $c.'-'.$a.'-'.$b;
        // /a/b/c
        // output: c-a-b
    }
}
```

## 使用举例

```php
// 在 AppServiceProvider::boot
// 设置生成路由默认locale值
URL::defaults(['locale' => 'en-us']);
// route('home.test', ['name'=>'hello']) => /en-us/hello
// route('home.test', ['name'=>'hello', 'locale'=>'fr']) => /fr/hello
```

```php
use \Illuminate\Support\Facades\Route;

// 定义路由组并且有一个可选的locale占位符
// 可以使用路由 /en-us/name   /name
Route::prefix('/{locale?}')
    ->whereIn('locale', ['en-us', 'fr', 'zh-CN', 'zh-HK'])
    ->group(function (\Illuminate\Routing\Router $router) {
        $router->get('/{name}', 'Home@test')->name('home.test');
    });
```

```php
// Controller
class Home extends Controller
{
    public function test(\Illuminate\Http\Request $request, string $name)
    {
        $locale = $request->getLocale();
        return $name;
    }
}
```
