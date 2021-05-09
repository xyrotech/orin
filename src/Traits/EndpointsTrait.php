<?php

require 'CollectionTrait.php';
require 'DatabaseTrait.php';
require 'IdentityTrait.php';
require 'ListTrait.php';
require 'MarketplaceTrait.php';
require 'WantlistTrait.php';

trait EndpointsTrait
{
    protected $base_uri = "https://api.discogs.com";
    protected $uri;
    protected $parameters = [];

    use DatabaseTrait, IdentityTrait, MarketplaceTrait, CollectionTrait, ListTrait, WantlistTrait;
}