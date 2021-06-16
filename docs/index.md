# Orin

[![API](https://www.discogs.com/images/discogs-white.png)](https://www.discogs.com/developers) ##_API CLIENT_

Orin is a Discogs API PHP client library which utilizes GuzzleHttp.

## Getting Started
***
Install via Composer:
```sh
composer require xyrotech/orin
```

Copy test config file.
```sh
cp vendor/xyrotech/orin/src/orin_config.test.php myconfig.php
```
> Note: While technically this isn't require, there's no guarentee your API call will work at all

<br/>

Start using the library! See example below
```php
use Xyrotech\Orin;

$config = include('myconfig.php');
$discog = new Orin($config);

$artist = $discogs->artist(45);
echo $artist->name; // 'Aphex Twin'
```

<br/>

### Configuration
**DISCOGS_USER_AGENT**
Your application must provide a User-Agent string that identifies itself – preferably something that follows RFC 1945. Some good examples below
```
AwesomeDiscogsBrowser/0.1 +http://adb.example.com
LibraryMetadataEnhancer/0.3 +http://example.com/lime
MyDiscogsClient/1.0 +http://mydiscogsclient.org
```
> Note: Please don’t just copy one of those! Make it unique so we can let you know if your application starts to misbehave – the alternative is that discogs just silently blocks it.

<br/>

**DISCOGS_TOKEN**

You'll need a token otherwise you'll be rate limited to 25 request per minute. Find your token here: https://www.discogs.com/settings/developers after you've create an app.

<br/>

**DISCOGS_CONSUMER_KEY**

After you have created an application  navigate to this link: https://www.discogs.com/settings/developers and click on the settings button next to you app to reveal the key and secret

<br/>

**DISCOGS_CONSUMER_SECRET**

After you have created an application  navigate to this link: https://www.discogs.com/settings/developers and click on the settings button next to you app to reveal the key and secret

<br/>

**DISCOGS_VERSION**

*Default: v2*

Currently, Discogs API only supports one version: v2. However, you can specify a version in your requests to future-proof your application. By adding an Accept header with the version and media type, you can guarantee your requests will receive data from the correct version you develop your app on.

<br/>

**DISCOGS_MEDIA_TYPE**

*Default: discogs*

If you are requesting information from an endpoint that may have text formatting in it, you can choose which kind of formatting you want to be returned by changing that section of the Accept header. Discogs currently support 3 types: html, plaintext, discogs.

<br/>

## Supported API Endpoints
***

<br/>

### Database

<br/>

**Release** [:mag:](https://www.discogs.com/developers#page:database,header:database-release)

*Get a Release* 
```php
$discog->release(192988);
```

<br/>

**Release Rating by User** [:mag:](https://www.discogs.com/developers#page:database,header:database-release-rating-by-user)

*Retrieves the release’s rating for a given user.* 
```php
$discog->release_rating_by_user(16457562, 'kunli0');
```
*Edit the release’s rating for a given user.* 
```php
$discog->update_release_rating_by_user(16457562, 'kunli0', 5);
```
*Delete the release’s rating for a given user.* 
```php
$discog->delete_release_rating_by_user(16457562, 'kunli0');
```

<br/>

**Community Release Rating** [:mag:](https://www.discogs.com/developers#page:database,header:database-community-release-rating)

*Retrieves the community release rating average and count.* 
```php
$discog->community_release_rating(16457562);
```

<br/>

**Release Stats** [:mag:](https://www.discogs.com/developers#page:database,header:database-release-stats)

*Retrieves the release’s “have” and “want” counts.* 
```php
$discog->release_stats(16457562);
```

<br/>

**Master Release** [:mag:](https://www.discogs.com/developers#page:database,header:database-master-release)

*Get a master release* 
```php
$discog->master_release(2482);
```

<br/>

**Master Release** [:mag:](https://www.discogs.com/developers#page:database,header:database-master-release)

*Get a master release* 
```php
$discog->master_release(2482);
```

<br/>

**Master Release Versions** [:mag:](https://www.discogs.com/developers#page:database,header:database-master-release-versions)

*Retrieves a list of all Releases that are versions of this master.* 
```php
$master = $discog->master_release_versions(2482, ['sort' => 'released', 'sort_order' => 'desc']);

foreach($master->releases as $release)
{
    echo $release->name;
}
```

<br/>

**Artist** [:mag:](https://www.discogs.com/developers#page:database,header:database-artist-releases)

*Get an artist* 
```php
$discog->artist(45);
```

<br/>

**Artist Releases** [:mag:](https://www.discogs.com/developers#page:database,header:database-master-release-versions)

*Get an artist’s releases* 
```php
$artist = $discog->artist_releases(45, ['sort' => 'year']);

foreach($artist->releases as $release)
{
    echo $release->name;
}
```

<br/>

**Label** [:mag:](https://www.discogs.com/developers#page:database,header:database-label)

*Get a label* 
```php
$discog->label(107);
```

<br/>

**All Label Releases** [:mag:](https://www.discogs.com/developers#page:database,header:database-all-label-releases)

*Returns a list of Releases associated with the label.* 
```php
$discog->all_label_releases(107);
```

<br/>

**Search** [:mag:](https://www.discogs.com/developers#page:database,header:database-search)

*Issue a search query to our database.* 
```php
$search = $discog->search('While you were sleeping', ['artist' => 'opiate', 'type' => 'master');

foreach($search->results as $result)
{
    var_dump($result);
}
```
