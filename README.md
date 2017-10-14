## About PHPCollections

PHPCollections is a set of data structures that try to make your life easiest when you work with PHP and large sets of data. Inspired in languages like Java or C#, PHPCollections offers data structures like List, Map, Stack and more, check it out!

> **Note**: This package is under actual development, so maybe all the possible features cannot be available at the time you install it, please understand I develop as fast as I can but this is a free time project.

## Requirements

```
PHP >= 7.0
```

## Instalation

```
composer require "maxalmonte14/phpcollections dev-master"
``` 

## Examples

Imagine you're storing Post objects for fetching like so

```php
$posts[] = new Post(1, 'PHP 7.2 release notes');
$posts[] = new Post(2, 'New Laravel 5.5 LTS make:factory command');
```

Everything alright! But maybe you commit a mistake for some mysterious reason and added a non-Post object

```php
$posts[] = 5 // This is not even an object!
```

When you try to fetch your posts array you gonna be in troubles

```php
foreach($posts as $post):
    <tr>
        <!-- this gonna fail when $post = 5! -->
        <td><?= $post->id; ?></td>
        <td><?= $post->title; ?></td>
    </tr>
endforeach
```

Affortunaly PHPCollections exists

```php
$posts = new GenericCollection(Post::class);
$posts->add(new Post(1, 'PHP 7.2 release notes'));
$posts->add(new Post(2, 'New Laravel 5.5 LTS make:factory command'));
$posts->add(5); // An InvalidArgumentException is thrown!
```

Of course also exists more flexible data structures like ArrayList

```php
$posts = new ArrayList();
$posts->add(new Post(1, 'PHP 7.2 release notes'));
$posts->add(new Post(2, 'New Laravel 5.5 LTS make:factory command'));
$posts->add(5); // Everything alright, I need this 5 anyway
```