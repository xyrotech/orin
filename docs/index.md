# Orin

[![API](https://www.discogs.com/images/discogs-white.png)](https://www.discogs.com/developers) 
## API CLIENT

Orin is a Discogs API PHP client library which utilizes GuzzleHttp.

<br>

## Todo List

- [x] Database Endpoints
- [x] Marketplace Endpoints
- [x] User Identiy
- [x] User Collection
- [x] User Wantlist
- [x] User Lists
- [ ] Authentication
- [ ] Inventory Export
- [ ] Inventory Upload

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

***

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

Default: v2

Currently, Discogs API only supports one version: v2. However, you can specify a version in your requests to future-proof your application. By adding an Accept header with the version and media type, you can guarantee your requests will receive data from the correct version you develop your app on.

<br/>

**DISCOGS_MEDIA_TYPE**

Default: discogs

If you are requesting information from an endpoint that may have text formatting in it, you can choose which kind of formatting you want to be returned by changing that section of the Accept header. Discogs currently support 3 types: html, plaintext, discogs.

<br/>

## Supported API Endpoints

<br/>

### Database

***

**Release**

[:mag: More Info](https://www.discogs.com/developers#page:database,header:database-release)


Get a Release
```php
$discog->release(int $release_id, string $curr_abbr = null);
```

<br/>

**Release Rating by User**

[:mag: More Info](https://www.discogs.com/developers#page:database,header:database-release-rating-by-user)

Retrieves the release’s rating for a given user.
```php
$discog->release_rating_by_user(int $release_id, string $username);
```
Edit the release’s rating for a given user. [:closed_lock_with_key: Auth Required](https://www.discogs.com/developers#page:authentication) 
```php
$discog->update_release_rating_by_user(int $release_id, string $username, int $rating);
```
Delete the release’s rating for a given user. [:closed_lock_with_key: Auth Required](https://www.discogs.com/developers#page:authentication)
```php
$discog->delete_release_rating_by_user(int $release_id, string $username);
```

<br/>

**Community Release Rating**

[:mag: More Info](https://www.discogs.com/developers#page:database,header:database-community-release-rating)

Retrieves the community release rating average and count.
```php
$discog->community_release_rating(int $release_id);
```

<br/>

**Release Stats** 

Retrieves the release’s “have” and “want” counts.

[:mag: More Info](https://www.discogs.com/developers#page:database,header:database-release-stats)


```php
$discog->release_stats(int $release_id);
```

<br/>

**Master Release**

[:mag: More Info](https://www.discogs.com/developers#page:database,header:database-master-release)

Get a master release
```php
$discog->master_release(int $master_id);
```

<br/>

**Master Release Versions**

[:mag: More Info](https://www.discogs.com/developers#page:database,header:database-master-release-versions)

Retrieves a list of all Releases that are versions of this master.
```php
$master = $discog->master_release_versions(int $master_id, array $parameters = null);

foreach($master->releases as $release)
{
    echo $release->name;
}
```

<br/>

**Artist**

[:mag: More Info](https://www.discogs.com/developers#page:database,header:database-artist-releases)

Get an artist
```php
$discog->artist(int $artist_id);
```

<br/>

**Artist Releases**

[:mag: More Info](https://www.discogs.com/developers#page:database,header:database-master-release-versions)

Get an artist’s releases
```php
$artist = $discog->artist_releases(int $artist_id, array $parameters = null);

foreach($artist->releases as $release)
{
    echo $release->name;
}
```

<br/>

**Label**

[:mag: More Info](https://www.discogs.com/developers#page:database,header:database-label)

Get a label
```php
$discog->label(int $label_id);
```

<br/>

**All Label Releases**

[:mag: More Info](https://www.discogs.com/developers#page:database,header:database-all-label-releases)

Returns a list of Releases associated with the label.
```php
$discog->all_label_releases(int $label_id, array $parameters = null);
```

<br/>

**Search**

[:mag: More Info](https://www.discogs.com/developers#page:database,header:database-search)

Issue a search query to discog's database. [:closed_lock_with_key: Auth Required](https://www.discogs.com/developers#page:authentication)
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

**Inventory**

[:mag: More Info](https://www.discogs.com/developers#page:marketplace,header:marketplace-inventory)

Get a seller’s inventory
```php
$user = $discog->inventory(int $username, array $parameters = null);

foreach($user->listings as $listing)
{
    var_dump($listing);
}
```

<br/>

**Listing**

[:mag: More Info](https://www.discogs.com/developers#page:marketplace,header:marketplace-listing)

The Listing resource allows you to view Marketplace listings.
```php
$listing = $discog->listing(int $listing_id, string $curr_abbr = null);
```

Edit the data associated with a listing. [:closed_lock_with_key: Auth Required](https://www.discogs.com/developers#page:authentication)
```php
$parameters = [
    'release_id' => 16457562,
    'condition' => 'Poor (P)',
    'price' => 89.00,
    'status' => 'For Sale'
];
        
$discog->edit_listing(int $listing_id, array $parameters);
```

Permanently remove a listing from the Marketplace. [:closed_lock_with_key: Auth Required](https://www.discogs.com/developers#page:authentication)
```php
$discog->delete_listing(int $listing_id);
```

<br/>

**New Listing**

[:mag: More Info](https://www.discogs.com/developers#page:marketplace,header:marketplace-new-listing)

Create a Marketplace listing. [:closed_lock_with_key: Auth Required](https://www.discogs.com/developers#page:authentication)
```php
$parameters = [
    'release_id' => 16457562,
    'condition' => 'Fair (F)',
    'price' => 99.00,
];
        
$discog->new_listing(array $parameters);
```

<br/>

**Order**

[:mag: More Info](https://www.discogs.com/developers#page:marketplace,header:marketplace-order)

View the data associated with an order. [:closed_lock_with_key: Auth Required](https://www.discogs.com/developers#page:authentication)
```php
$discog->order(int $order_id);
```

Edit the data associated with an order. [:closed_lock_with_key: Auth Required](https://www.discogs.com/developers#page:authentication)
```php
$discog->edit_order(int $order_id, array $parameters = null);
```

<br/>

**List Orders**

[:mag: More Info](https://www.discogs.com/developers#page:marketplace,header:marketplace-list-orders)

Returns a list of the authenticated user’s orders. [:closed_lock_with_key: Auth Required](https://www.discogs.com/developers#page:authentication)
```php
$user = $discog->list_orders();

foreach($user->orders as $order)
{
    var_dump($order);
}
```

<br/>

**List Order Messages**

[:mag: More Info](https://www.discogs.com/developers#page:marketplace,header:marketplace-list-order-messages)

Returns a list of the order’s messages with the most recent first.  [:closed_lock_with_key: Auth Required](https://www.discogs.com/developers#page:authentication)
```php
$order = $discog->list_order_messages();

foreach($order->messages as $message)
{
    var_dump($message);
}
```

Adds a new message to the order’s message log.  [:closed_lock_with_key: Auth Required](https://www.discogs.com/developers#page:authentication)
```php
$discog->new_order_message(int $order_id, string $message = null, string $status = null);
```

<br/>

**Fee**

[:mag: More Info](https://www.discogs.com/developers#page:marketplace,header:marketplace-fee)

The Fee resource allows you to quickly calculate the fee for selling an item on the Marketplace.
```php
$discog->fee(float $price);
```

<br/>

**Fee with Currency**

[:mag: More Info](https://www.discogs.com/developers#page:marketplace,header:marketplace-fee-with-currency)

The Fee resource allows you to quickly calculate the fee for selling an item on the Marketplace given a particular currency.
```php
$discog->fee_with_currency(float $price, string $currency = null);
```

<br/>

**Price Suggestion**

[:mag: More Info](https://www.discogs.com/developers#page:marketplace,header:marketplace-price-suggestions)

Retrieve price suggestions for the provided Release ID.  [:closed_lock_with_key: Auth Required](https://www.discogs.com/developers#page:authentication)
```php
$discog->price_suggestions(int $release_id);
```

<br/>

**Release Statistics**

[:mag: More Info](https://www.discogs.com/developers#page:marketplace,header:marketplace-release-statistics)

Retrieve marketplace statistics for the provided Release ID.
```php
$discog->release_statistics(int $release_id, string $curr_abbr = null);
```

<br/>

### User Identity

***

**Identity**

[:mag: More Info](https://www.discogs.com/developers#page:user-identity,header:user-identity-identity)

Retrieve basic information about the authenticated user. [:closed_lock_with_key: Auth Required](https://www.discogs.com/developers#page:authentication)
```php
$discog->identity();
```

<br/>

**Profile**

[:mag: More Info](https://www.discogs.com/developers#page:user-identity,header:user-identity-profile)

Retrieve a user by username.
```php
$discog->profile(string $username);
```

Edit a user’s profile data. [:closed_lock_with_key: Auth Required](https://www.discogs.com/developers#page:authentication)
```php
$discog->edit_profile(string $username, array $parameters => null);
```

<br>

**User Submissions**

[:mag: More Info](https://www.discogs.com/developers#page:user-identity,header:user-identity-user-submissions)

Retrieve a user’s submissions by username.
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

**Collection** 

[:mag: More Info](https://www.discogs.com/developers#page:user-collection,header:user-collection-collection)

Retrieve a list of folders in a user’s collection.
```php
$user = $discog->collection_folders(string $username);

foreach($user->folders as $folder)
{
    var_dump($folder);
}
```

Create a new folder in a user’s collection. [:closed_lock_with_key: Auth Required](https://www.discogs.com/developers#page:authentication)
```php
$discog->new_collection_folder(string $username, string $name);
```

<br/>

**Collection Folder**

[:mag: More Info](https://www.discogs.com/developers#page:user-collection,header:user-collection-collection-folder)

Retrieve a list of folders in a user’s collection.
```php
$discog->collection_folders(string $username);
```

Create a new folder in a user’s collection.
```php
$discog->new_collection_folder(string $username, string $name);
```

Retrieve metadata about a folder in a user’s collection.
```php
$discog->collection_folder(string $username, int $folder_id);
```

Edit the metadata about a folder in a user’s collection. [:closed_lock_with_key: Auth Required](https://www.discogs.com/developers#page:authentication)
```php
$discog->edit_collection_folder(string $username, int $folder_id, string $name);
```

Delete a folder from a user’s collection. [:closed_lock_with_key: Auth Required](https://www.discogs.com/developers#page:authentication)
```php
$discog->delete_collection_folder(string $username, int $folder_id);
```

<br/>

**Collection Items by Release**

[:mag: More Info](https://www.discogs.com/developers#page:user-collection,header:user-collection-collection-items-by-release)

View the user’s collection folders which contain a specified release.
```php
$discog->collection_items_by_release(string $username, int $release_id);
```

<br/>

**Collection Items by Folder**

[:mag: More Info](https://www.discogs.com/developers#page:user-collection,header:user-collection-collection-items-by-folder)

Returns the list of item in a folder in a user’s collection.
```php
$discog->collection_items_by_release(string $username, int $release_id);
```

<br/>

**Add to Collection Folder**

[:mag: More Info](https://www.discogs.com/developers#page:user-collection,header:user-collection-add-to-collection-folder)

Add a release to a folder in a user’s collection. [:closed_lock_with_key: Auth Required](https://www.discogs.com/developers#page:authentication)
```php
$discog->add_to_collection_folder(string $username, int $folder_id, int $release_id);
```

<br/>

**Change Rating of Release**

[:mag: More Info](https://www.discogs.com/developers#page:user-collection,header:user-collection-change-rating-of-release)

Change the rating on a release and/or move the instance to another folder. [:closed_lock_with_key: Auth Required](https://www.discogs.com/developers#page:authentication)
```php
$discog->change_rating_of_release(string $username, int $folder_id, int $release_id, int $instance_id, array $parameters = null);
```

<br/>

**Delete Instance from Folder**

[:mag: More Info](https://www.discogs.com/developers#page:user-collection,header:user-collection-delete-instance-from-folder)

Remove an instance of a release from a user’s collection folder. [:closed_lock_with_key: Auth Required](https://www.discogs.com/developers#page:authentication)
```php
$discog->delete_instance_from_folder(string $username, int $folder_id, int $release_id, int $instance_id);
```

<br/>

**List Custom Fields**

[:mag: More Info](https://www.discogs.com/developers#page:user-collection,header:user-collection-list-custom-fields)

Retrieve a list of user-defined collection notes fields.
```php
$discog->list_custom_fields(string $username);
```

Change the value of a notes field on a particular instance.
```php
$discog->edit_fields_instance(string $username, string $value, int $folder_id, int $release_id, int $instance_id, int $field_id);
```

<br/>

**Collection Value**

[:mag: More Info](https://www.discogs.com/developers#page:user-collection,header:user-collection-collection-value)

Returns the minimum, median, and maximum value of a user’s collection. [:closed_lock_with_key: Auth Required](https://www.discogs.com/developers#page:authentication)
```php
$discog->collection_value(string $username);
```

<br/>

### User Wantlist

***

**Wantlist**

[:mag: More Info](https://www.discogs.com/developers#page:user-wantlist,header:user-wantlist-wantlist)

Returns the list of releases in a user’s wantlist.
```php
$discog->wantlist(string $username);
```

Add a release to a user’s wantlist. [:closed_lock_with_key: Auth Required](https://www.discogs.com/developers#page:authentication)
```php
$discog->add_to_wantlist(string $username, int $relase_id, string $notes = null, int $rating = null);
```

Edit a release from a user’s wantlist. [:closed_lock_with_key: Auth Required](https://www.discogs.com/developers#page:authentication)
```php
$discog->edit_from_wantlist(string $username, int $relase_id, string $notes = null, int $rating = null);
```

Delete a release from a user’s wantlist. [:closed_lock_with_key: Auth Required](https://www.discogs.com/developers#page:authentication)
```php
$discog->delete_from_wantlist(string $username, int $relase_id, string $notes = null, int $rating = null);
```

<br/>

### User Lists

***

**User Lists**

[:mag: More Info](https://www.discogs.com/developers#page:user-lists,header:user-lists-user-lists)

Returns a User’s Lists.
```php
$discog->user_lists(string $username);
```

<br>

**List**

[:mag: More Info](https://www.discogs.com/developers#page:user-lists,header:user-lists-list)

Returns items from a specified List.
```php
$discog->user_lists(int $list_id);
```
