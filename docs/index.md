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

<br/>

### Database

***

**Release** [:mag:](https://www.discogs.com/developers#page:database,header:database-release)

<small>Get a Release</small> 
```php
$discog->release(int $release_id, string $curr_abbr = null);
```

<br/>

**Release Rating by User** [:mag:](https://www.discogs.com/developers#page:database,header:database-release-rating-by-user)

<small>Retrieves the release’s rating for a given user.</small> 
```php
$discog->release_rating_by_user(int $release_id, string $username);
```
<small>Edit the release’s rating for a given user.</small> 
```php
$discog->update_release_rating_by_user(int $release_id, string $username, int $rating);
```
<small>Delete the release’s rating for a given user.</small> 
```php
$discog->delete_release_rating_by_user(int $release_id, string $username);
```

<br/>

**Community Release Rating** [:mag:](https://www.discogs.com/developers#page:database,header:database-community-release-rating)

<small>Retrieves the community release rating average and count.</small> 
```php
$discog->community_release_rating(int $release_id);
```

<br/>

**Release Stats** [:mag:](https://www.discogs.com/developers#page:database,header:database-release-stats)

<small>Retrieves the release’s “have” and “want” counts.</small> 
```php
$discog->release_stats(int $release_id);
```

<br/>

**Master Release** [:mag:](https://www.discogs.com/developers#page:database,header:database-master-release)

<small>Get a master release</small> 
```php
$discog->master_release(int $master_id);
```

<br/>

**Master Release Versions** [:mag:](https://www.discogs.com/developers#page:database,header:database-master-release-versions)

<small>Retrieves a list of all Releases that are versions of this master.</small>
```php
$master = $discog->master_release_versions(int $master_id, array $parameters = null);

foreach($master->releases as $release)
{
    echo $release->name;
}
```

<br/>

**Artist** [:mag:](https://www.discogs.com/developers#page:database,header:database-artist-releases)

<small>Get an artist</small>
```php
$discog->artist(int $artist_id);
```

<br/>

**Artist Releases** [:mag:](https://www.discogs.com/developers#page:database,header:database-master-release-versions)

<small>Get an artist’s releases</small> 
```php
$artist = $discog->artist_releases(int $artist_id, array $parameters = null);

foreach($artist->releases as $release)
{
    echo $release->name;
}
```

<br/>

**Label** [:mag:](https://www.discogs.com/developers#page:database,header:database-label)

<small>Get a label</small>
```php
$discog->label(int $label_id);
```

<br/>

**All Label Releases** [:mag:](https://www.discogs.com/developers#page:database,header:database-all-label-releases)

<small>Returns a list of Releases associated with the label.</small>
```php
$discog->all_label_releases(int $label_id, array $parameters = null);
```

<br/>

**Search** [:mag:](https://www.discogs.com/developers#page:database,header:database-search)

<small>Issue a search query to discog's database.</small>
```php
$search = $discog->search(string $query, array $parameters = null);

foreach($search->results as $result)
{
    var_dump($result);
}
```

<br/>

### Marketplace

***

**Inventory** [:mag:](https://www.discogs.com/developers#page:marketplace,header:marketplace-inventory)

<small>Get a seller’s inventory</small>
```php
$user = $discog->inventory(int $username, array $parameters = null);

foreach($user->listings as $listing)
{
    var_dump($listing);
}
```

<br/>

**Listing** [:mag:](https://www.discogs.com/developers#page:marketplace,header:marketplace-listing)

<small>The Listing resource allows you to view Marketplace listings.</small>
```php
$listing = $discog->listing(int $listing_id, string $curr_abbr = null);
```

<small>Edit the data associated with a listing.</small>
```php
$parameters = [
    'release_id' => 16457562,
    'condition' => 'Poor (P)',
    'price' => 89.00,
    'status' => 'For Sale'
];
        
$discog->edit_listing(int $listing_id, array $parameters);
```

<small>Permanently remove a listing from the Marketplace.</small>
```php
$discog->delete_listing(int $listing_id);
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
        
$discog->new_listing(array $parameters);
```

<br/>

**Order** [:mag:](https://www.discogs.com/developers#page:marketplace,header:marketplace-order)

<small>The Order resource allows you to manage a seller’s Marketplace orders.</small>
```php
$discog->order(int $order_id);
```

<small>Edit the data associated with an order.</small>
```php
$discog->edit_order(int $order_id, array $parameters = null);
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
$discog->new_order_message(int $order_id, string $message = null, string $status = null);
```

<br/>

**Fee** [:mag:](https://www.discogs.com/developers#page:marketplace,header:marketplace-fee)

<small>The Fee resource allows you to quickly calculate the fee for selling an item on the Marketplace.</small>
```php
$discog->fee(float $price);
```

<br/>

**Fee with Currency** [:mag:](https://www.discogs.com/developers#page:marketplace,header:marketplace-fee-with-currency)

<small>The Fee resource allows you to quickly calculate the fee for selling an item on the Marketplace given a particular currency.</small>
```php
$discog->fee_with_currency(float $price, string $currency = null);
```

<br/>

**Price Suggestion** [:mag:](https://www.discogs.com/developers#page:marketplace,header:marketplace-price-suggestions)

<small>Retrieve price suggestions for the provided Release ID.</small>
```php
$discog->price_suggestions(int $release_id);
```

<br/>

**Release Statistics** [:mag:](https://www.discogs.com/developers#page:marketplace,header:marketplace-release-statistics)

<small>Retrieve marketplace statistics for the provided Release ID.</small>
```php
$discog->release_statistics(int $release_id, string $curr_abbr = null);
```

<br/>

### User Identity

***

**Identity** [:mag:](https://www.discogs.com/developers#page:user-identity,header:user-identity-identity)

<small>Retrieve basic information about the authenticated user.</small>
```php
$discog->identity();
```

<br/>

**Profile** [:mag:](https://www.discogs.com/developers#page:user-identity,header:user-identity-profile)

<small>Retrieve a user by username.</small>
```php
$discog->profile(string $username);
```

<small>Edit a user’s profile data.</small>
```php
$discog->edit_profile(string $username, array $parameters => null);
```

<br>

**User Submissions** [:mag:](https://www.discogs.com/developers#page:user-identity,header:user-identity-user-submissions)

<small>Retrieve a user’s submissions by username.</small>
```php
$user = $discog->user_submissions(string $username);

foreach($user->submissions as $submission)
{
    var_dump($submission);
}
```

<br/>

### User Collection

***

**Collection** [:mag:](https://www.discogs.com/developers#page:user-collection,header:user-collection-collection)

<small>Retrieve a list of folders in a user’s collection.</small>
```php
$user = $discog->collection_folders(string $username);

foreach($user->folders as $folder)
{
    var_dump($folder);
}
```

<small>Create a new folder in a user’s collection.</small>
```php
$discog->new_collection_folder(string $username, string $name);
```

<br/>

**Collection Folder** [:mag:](https://www.discogs.com/developers#page:user-collection,header:user-collection-collection-folder)

<small>Retrieve metadata about a folder in a user’s collection.</small>
```php
$discog->collection_folder(string $username, int $folder_id);
```

<small>Retrieve metadata about a folder in a user’s collection.</small>
```php
$discog->edit_collection_folder(string $username, int $folder_id, string $name);
```

<small>Delete a folder from a user’s collection.</small>
```php
$discog->delete_collection_folder(string $username, int $folder_id);
```

<br/>

**Collection Items by Release** [:mag:](https://www.discogs.com/developers#page:user-collection,header:user-collection-collection-items-by-release)

<small>View the user’s collection folders which contain a specified release.</small>
```php
$discog->collection_items_by_release(string $username, int $release_id);
```

<br/>

**Collection Items by Folder** [:mag:](https://www.discogs.com/developers#page:user-collection,header:user-collection-collection-items-by-folder)

<small>Returns the list of item in a folder in a user’s collection.</small>
```php
$discog->collection_items_by_release(string $username, int $release_id);
```

<br/>

**Add to Collection Folder** [:mag:](https://www.discogs.com/developers#page:user-collection,header:user-collection-add-to-collection-folder)

<small>Add a release to a folder in a user’s collection.</small>
```php
$discog->add_to_collection_folder(string $username, int $folder_id, int $release_id);
```

<br/>

**Change Rating of Release** [:mag:](https://www.discogs.com/developers#page:user-collection,header:user-collection-change-rating-of-release)

<small>Change the rating on a release and/or move the instance to another folder.</small>
```php
$discog->change_rating_of_release(string $username, int $folder_id, int $release_id, int $instance_id, array $parameters = null);
```

<br/>

**Delete Instance from Folder** [:mag:](https://www.discogs.com/developers#page:user-collection,header:user-collection-delete-instance-from-folder)

<small>Remove an instance of a release from a user’s collection folder.</small>
```php
$discog->delete_instance_from_folder(string $username, int $folder_id, int $release_id, int $instance_id);
```

<br/>

**List Custom Fields** [:mag:](https://www.discogs.com/developers#page:user-collection,header:user-collection-list-custom-fields)

<small>Retrieve a list of user-defined collection notes fields.</small>
```php
$discog->list_custom_fields(string $username);
```

<small>Change the value of a notes field on a particular instance.</small>
```php
$discog->edit_fields_instance(string $username, string $value, int $folder_id, int $release_id, int $instance_id, int $field_id);
```

<br/>

**Collection Value** [:mag:](https://www.discogs.com/developers#page:user-collection,header:user-collection-collection-value)

<small>Returns the minimum, median, and maximum value of a user’s collection.</small>
```php
$discog->collection_value(string $username);
```

<br/>

### User Wantlist

***

**Wantlist** [:mag:](https://www.discogs.com/developers#page:user-wantlist,header:user-wantlist-wantlist)

<small>Returns the list of releases in a user’s wantlist.</small>
```php
$discog->wantlist(string $username);
```

<small>Add a release to a user’s wantlist.</small>
```php
$discog->add_to_wantlist(string $username, int $relase_id, string $notes = null, int $rating = null);
```

<small>Edit a release from a user’s wantlist.</small>
```php
$discog->edit_from_wantlist(string $username, int $relase_id, string $notes = null, int $rating = null);
```

<small>Delete a release from a user’s wantlist.</small>
```php
$discog->delete_from_wantlist(string $username, int $relase_id, string $notes = null, int $rating = null);
```

<br/>

### User Lists

***

**User Lists** [:mag:](https://www.discogs.com/developers#page:user-lists,header:user-lists-user-lists)

<small>Returns a User’s Lists.</small>
```php
$discog->user_lists(string $username);
```

<br>

**List** [:mag:](https://www.discogs.com/developers#page:user-lists,header:user-lists-list)

<small>Returns items from a specified List.</small>
```php
$discog->user_lists(int $list_id);
```
