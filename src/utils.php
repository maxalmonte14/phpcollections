<?php

/**
 * Return the correct article
 * for preceding a specific word.
 *
 * @param  string $word
 * 
 * @return string
 */
function getArticle(string $word) :string
{
    return !in_array(strtolower($word[0]), ['a','e','i','o','u']) ? 'a' : 'an';
}
