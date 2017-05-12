## Package to add priority to Laravel 5.3 routes

[![Latest Stable Version](https://poser.pugx.org/langaner/route-priority/v/stable)](https://packagist.org/packages/langaner/route-priority) 
[![Total Downloads](https://poser.pugx.org/langaner/route-priority/downloads)](https://packagist.org/packages/langaner/route-priority) 
[![Latest Unstable Version](https://poser.pugx.org/langaner/route-priority/v/unstable)](https://packagist.org/packages/langaner/route-priority) 
[![License](https://poser.pugx.org/langaner/route-priority/license)](https://packagist.org/packages/langaner/route-priority)

### Installation

1) Add `langaner/route-priority` to `composer.json`.

    "langaner/route-priority": "5.3.*-dev"
    
2)Run `composer update` to pull down the latest version of the package.

3)Now open up `app/config/app.php` and add the service provider to your `providers` array.

	Langaner\RoutePriority\RoutePriorityServiceProvider::class,

4)Add the trait to `App\Http\Kernel`

	use \Langaner\RoutePriority\RouterTrait;

### Usage

Change routes priority:

```php
Route::get('test', ['uses' => 'Controller@showAction'])->setPriority(100);
```

### Default Priority

Default priority is `50`. Higher priority - values from 50 and above, lower priority - `49` and below.

### Usage example

```php
Route::get('/test/{slug}', …);
Route::get('/test/hello', …);
```

In this example second route will not work. Add priority 0 to the first route will fix the error:

```php
Route::get('/test/{slug}', …)->setPriority(0);
Route::get('/test/hello', …);
```

Second route now has higher priority.

### Group priority

You can put priority to groups:

```php
Route::group(['prefix' => 'test-group', 'priority' => 10], function () {
	Route::get('/test/hello', function () {
	    return 'First group';
	});
});

Route::group(['prefix' => 'test-group', 'priority' => 20], function () {
	Route::get('/test/hello', function () {
	    return 'Second group';
	});
});
```

Second group has higher priority then First group. All routes in the group will has the same priority as the group.