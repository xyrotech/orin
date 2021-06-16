# Orin

[![API](https://www.discogs.com/images/discogs-white.png)](https://www.discogs.com/developers) 
## API CLIENT

Orin is a Discogs API PHP client library which utilizes GuzzleHttp.

<br>

## Getting Started
***
Install via Composer:
```bash
composer require xyrotech/orin
```

Copy test config file.
```bash
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
> Note: Please don’t just copy one of those! Make it unique so discogs can let you know if your application starts to misbehave – the alternative is that discogs just silently blocks it.

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

<small>Default: v2</small>

Currently, Discogs API only supports one version: v2. However, you can specify a version in your requests to future-proof your application. By adding an Accept header with the version and media type, you can guarantee your requests will receive data from the correct version you develop your app on.

<br/>

**DISCOGS_MEDIA_TYPE**

<small>Default: discogs</small>

If you are requesting information from an endpoint that may have text formatting in it, you can choose which kind of formatting you want to be returned by changing that section of the Accept header. Discogs currently support 3 types: html, plaintext, discogs.

<br/>

## Supported API Endpoints
***

<br/>

### Database

<br/>

**Release** [:mag:](https://www.discogs.com/developers#page:database,header:database-release)

<small>Get a Release</small> 
```php
$discog->release(192988);
```

<br/>

**Release Rating by User** [:mag:](https://www.discogs.com/developers#page:database,header:database-release-rating-by-user)

<small>Retrieves the release’s rating for a given user.</small> 
```php
$discog->release_rating_by_user(16457562, 'kunli0');
```
<small>Edit the release’s rating for a given user.</small> 
```php
$discog->update_release_rating_by_user(16457562, 'kunli0', 5);
```
<small>Delete the release’s rating for a given user.</small> 
```php
$discog->delete_release_rating_by_user(16457562, 'kunli0');
```

<br/>

**Community Release Rating** [:mag:](https://www.discogs.com/developers#page:database,header:database-community-release-rating)

<small>Retrieves the community release rating average and count.</small> 
```php
$discog->community_release_rating(16457562);
```

<br/>

**Release Stats** [:mag:](https://www.discogs.com/developers#page:database,header:database-release-stats)

<small>Retrieves the release’s “have” and “want” counts.</small> 
```php
$discog->release_stats(16457562);
```

<br/>

**Master Release** [:mag:](https://www.discogs.com/developers#page:database,header:database-master-release)

<small>Get a master release</small> 
```php
$discog->master_release(2482);
```

<br/>

**Master Release** [:mag:](https://www.discogs.com/developers#page:database,header:database-master-release)

<small>Get a master release</small>
```php
$discog->master_release(2482);
```

<br/>

**Master Release Versions** [:mag:](https://www.discogs.com/developers#page:database,header:database-master-release-versions)

<small>Retrieves a list of all Releases that are versions of this master.</small>
```php
$master = $discog->master_release_versions(2482, ['sort' => 'released', 'sort_order' => 'desc']);

foreach($master->releases as $release)
{
    echo $release->name;
}
```

<br/>

**Artist** [:mag:](https://www.discogs.com/developers#page:database,header:database-artist-releases)

<small>Get an artist</small>
```php
$discog->artist(45);
```

<br/>

**Artist Releases** [:mag:](https://www.discogs.com/developers#page:database,header:database-master-release-versions)

<small>Get an artist’s releases</small> 
```php
$artist = $discog->artist_releases(45, ['sort' => 'year']);

foreach($artist->releases as $release)
{
    echo $release->name;
}
```

<br/>

**Label** [:mag:](https://www.discogs.com/developers#page:database,header:database-label)

<small>Get a label</small>
```php
$discog->label(107);
```

<br/>

**All Label Releases** [:mag:](https://www.discogs.com/developers#page:database,header:database-all-label-releases)

<small>Returns a list of Releases associated with the label.</small>
```php
$discog->all_label_releases(107);
```

<br/>

**Search** [:mag:](https://www.discogs.com/developers#page:database,header:database-search)

<small>Issue a search query to discog's database.</small>
```php
$search = $discog->search('While you were sleeping', ['artist' => 'opiate', 'type' => 'master');

foreach($search->results as $result)
{
    var_dump($result);
}
```

<br/>

### Marketplace

<br/>

**Inventory** [:mag:](https://www.discogs.com/developers#page:marketplace,header:marketplace-inventory)

<small>Get a seller’s inventory</small>
```php
$user = $discog->inventory('kunli0', ['sort' => 'artist']);

foreach($user->listings as $listing)
{
    var_dump($listing);
}
```

<br/>

**Listing** [:mag:](https://www.discogs.com/developers#page:marketplace,header:marketplace-listing)

<small>The Listing resource allows you to view Marketplace listings.</small>
```php
$listing = $discog->listing(172723812);
```

<small>Edit the data associated with a listing.</small>
```php
$parameters = [
    'release_id' => 16457562,
    'condition' => 'Poor (P)',
    'price' => 89.00,
    'status' => 'For Sale'
];
        
$discog->edit_listing(172723812, $parameters);
```

<small>Permanently remove a listing from the Marketplace.</small>
```php
$discog->delete_listing(172723812);
```

<br/>

**New Listing** [:mag:](https://www.discogs.com/developers#page:marketplace,header:marketplace-new-listing)

<small>Create a Marketplace listing.</small>
```php
$parameters = [
    'release_id' => 16457562,
    'condition' => 'Fair (F)',
    'price' => 99.00,
];
        
$discog->new_listing($parameters);
```

<br/>

**Order** [:mag:](https://www.discogs.com/developers#page:marketplace,header:marketplace-order)

<small>The Order resource allows you to manage a seller’s Marketplace orders.</small>
```php
$discog->order(156896);
```

<small>Edit the data associated with an order.</small>
```php
$discog->edit_order(156896, ['status' => $new_status]);
```

<br/>

**List Orders** [:mag:](https://www.discogs.com/developers#page:marketplace,header:marketplace-list-orders)

<small>Returns a list of the authenticated user’s orders.</small>
```php
$user = $discog->list_orders();

foreach($user->orders as $order)
{
    var_dump($order);
}
```

<br/>

**List Order Messages** [:mag:](https://www.discogs.com/developers#page:marketplace,header:marketplace-list-order-messages)

<small>Returns a list of the order’s messages with the most recent first.</small>
```php
$order = $discog->list_order_messages();

foreach($order->messages as $message)
{
    var_dump($message);
}
```

<small>Adds a new message to the order’s message log.</small>
```php
$discog->new_order_message(15359, 'Test Message', 'New Order');
```

<br/>

**Fee** [:mag:](https://www.discogs.com/developers#page:marketplace,header:marketplace-fee)

<small>The Fee resource allows you to quickly calculate the fee for selling an item on the Marketplace.</small>
```php
$discog->fee('10.00');
```

<br/>

**Fee with Currency** [:mag:](https://www.discogs.com/developers#page:marketplace,header:marketplace-fee-with-currency)

<small>The Fee resource allows you to quickly calculate the fee for selling an item on the Marketplace given a particular currency.</small>
```php
$discog->fee_with_currency('10.00', 'USD');
```

<br/>

**Price Suggestion** [:mag:](https://www.discogs.com/developers#page:marketplace,header:marketplace-price-suggestions)

<small>Retrieve price suggestions for the provided Release ID.</small>
```php
$discog->price_suggestions(123456);
```

<br/>

**Release Statistics** [:mag:](https://www.discogs.com/developers#page:marketplace,header:marketplace-release-statistics)

<small>Retrieve marketplace statistics for the provided Release ID.</small>
```php
$discog->price_suggestions(123456);
```

<br/>

### User Identity

<br/>

**Identity** [:mag:](https://www.discogs.com/developers#page:user-identity,header:user-identity-identity)

<small>Retrieve basic information about the authenticated user.</small>
```php
$discog->identity();
```

<br/>

**Profile** [:mag:](https://www.discogs.com/developers#page:user-identity,header:user-identity-profile)

<small>Retrieve a user by username.</small>
```php
$discog->profile('kunli0');
```

<small>Edit a user’s profile data.</small>
```php
$discog->edit_profile('kunli0', ['name' => 'Adekunle Adelakun']);
```

<br>

**User Submissions** [:mag:](https://www.discogs.com/developers#page:user-identity,header:user-identity-user-submissions)

<small>Retrieve a user’s submissions by username.</small>
```php
$user = $discog->user_submissions('kunli0');

foreach($user->submissions as $submission)
{
    var_dump($submission);
}
```

<br/>

### User Collection

<br/>

**Collection** [:mag:](https://www.discogs.com/developers#page:user-collection,header:user-collection-collection)

<small>Retrieve a list of folders in a user’s collection.</small>
```php
$user = $discog->collection_folders('kunli0');

foreach($user->folders as $folder)
{
    var_dump($folder);
}
```

<small>Create a new folder in a user’s collection.</small>
```php
$discog->new_collection_folder('kunli0', 'New Folder');
```

<br/>

**Collection Folder** [:mag:](https://www.discogs.com/developers#page:user-collection,header:user-collection-collection-folder)

<small>Retrieve metadata about a folder in a user’s collection.</small>
```php
$discog->collection_folder('kunli0', 1);
```

<small>Retrieve metadata about a folder in a user’s collection.</small>
```php
$discog->edit_collection_folder('kunli0', 3, 'New Folder Name');
```

<small>Delete a folder from a user’s collection.</small>
```php
$discog->delete_collection_folder('kunli0', 3);
```

<br/>

**Collection Items by Release** [:mag:](https://www.discogs.com/developers#page:user-collection,header:user-collection-collection-items-by-release)

<small>View the user’s collection folders which contain a specified release.</small>
```php
$discog->collection_items_by_release('kunli0', 16457562);
```

<br/>

**Collection Items by Folder** [:mag:](https://www.discogs.com/developers#page:user-collection,header:user-collection-collection-items-by-folder)

<small>Returns the list of item in a folder in a user’s collection.</small>
```php
$discog->collection_items_by_release('kunli0', 1);
```

<br/>

**Add to Collection Folder** [:mag:](https://www.discogs.com/developers#page:user-collection,header:user-collection-add-to-collection-folder)

<small>Add a release to a folder in a user’s collection.</small>
```php
$discog->add_to_collection_folder('kunli0', 1, 1598736);
```

<br/>

**Change Rating of Release** [:mag:](https://www.discogs.com/developers#page:user-collection,header:user-collection-change-rating-of-release)

<small>Change the rating on a release and/or move the instance to another folder.</small>
```php
$discog->change_rating_of_release('kunli0', 1, 1598736, 2921113, 5);
```

<br/>

**Delete Instance from Folder** [:mag:](https://www.discogs.com/developers#page:user-collection,header:user-collection-delete-instance-from-folder)

<small>Remove an instance of a release from a user’s collection folder.</small>
```php
$discog->delete_instance_from_folder('kunli0', 1, 1598736, 2921113);
```

<br/>

**List Custom Fields** [:mag:](https://www.discogs.com/developers#page:user-collection,header:user-collection-list-custom-fields)

<small>Retrieve a list of user-defined collection notes fields.</small>
```php
$discog->list_custom_fields('kunli0');
```

<small>Change the value of a notes field on a particular instance.</small>
```php
$discog->edit_fields_instance('kunli0', 'Testing', 1, 1598736, 3, 3);
```

<br/>

**Collection Value** [:mag:](https://www.discogs.com/developers#page:user-collection,header:user-collection-collection-value)

<small>Returns the minimum, median, and maximum value of a user’s collection.</small>
```php
$discog->collection_value('kunli0');
```
