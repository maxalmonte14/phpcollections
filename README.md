## About PHPCollections

PHPCollections is a set of data structures that try to make your life easier when you're working with PHP and large sets of data. Inspired by languages like Java or C#, PHPCollections offers data structures like List, Map, Stack and more, check it out!

## Requirements

```
PHP >= 7.1
```

## Installation

```
composer require "maxalmonte14/phpcollections"
``` 

## Examples

Imagine you're storing Post objects for fetching like so.

```php
$posts[] = new Post(1, 'PHP 7.2 release notes');
$posts[] = new Post(2, 'New Laravel 5.5 LTS make:factory command');
```

Everything is fine! But maybe you made a mistake for some mysterious reason and added a non-Post object.

```php
$posts[] = 5 // This is not even an object!
```

When you'll try to fetch your posts array you'll be in troubles.

```html
<?php foreach($posts as $post): ?>
    <tr>
        <!-- this gonna fail when $post == 5! -->
        <td><?= $post->id; ?></td>
        <td><?= $post->title; ?></td>
    </tr>
<?php endforeach ?>
```

Fortunately PHPCollections exists.

```php
$posts = new GenericList(
    Post::class,
    new Post(1, 'PHP 7.2 release notes'),
    new Post(2, 'New Laravel 5.5 LTS make:factory command')
);
$posts->add(5); // An InvalidArgumentException is thrown!
```

Of course there exist more flexible data structures like ArrayList.

```php
$posts = new ArrayList();
$posts->add(new Post(1, 'PHP 7.2 release notes'));
$posts->add(new Post(2, 'New Laravel 5.5 LTS make:factory command'));
$posts->add(5); // Everything is fine, I need this 5 anyway
```

## Features

- Different types of collections like Dictionariy, Stack and GenericList.
- Simple API.
- Lightweight, no extra packages needed.