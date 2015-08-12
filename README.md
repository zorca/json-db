#json-db

[![Build Status](https://travis-ci.org/dav-m85/json-db.png?branch=master)](https://travis-ci.org/dav-m85/json-db)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/dav-m85/json-db/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/dav-m85/json-db/?branch=master)

json-db is a document oriented database using json files as storage.

It tries to implement concurrency proofness with unit of work mechanism, but has not been tested yet in heavy
load environments. Documents are retrieved with a query pattern.

## Usage

```php
use JsonDb\JsonDb;
use JsonDb\JsonCollection;

$db = new JsonDb('some/dir/in/your/filesystem');

// Lets get a collection
$test = $db->getCollection('test');
$test = $db->test; // That's the same

// Insert something
$something = array('foo' => 'bar');
$test->insert($something); // Adds a _id to $something, mongo style.

// Get all documents
$all = $test->find();

// Get one or more documents with condition
$some = $test->find(Query::match('foo','bar'));
$some = $test->find(Query::match('foo','bar')->or(Query::match('yay', 'blah')));

// Update a record
$something['aze'] = 'rty';
$test->update(Query::match('foo','bar'), $something);

// Deleting a record works the same way
$test->delete(Query::match('foo','bar'));

// If you want flush changes to filesystem, just use flush
$test->flush();

// When you're done, drop the collection erases it all.
$test->drop();
```

## Contributing
You can contribute in various ways :

*Report bugs* in the projects "issues" section. Please make sure you know how to report one, general understanding of [this
document](http://www.chiark.greenend.org.uk/~sgtatham/bugs.html) could help ;)

You want to *fix a bug* ? Take an issue or fill one, assign yourself on it and when done, submit a Pull Request. I'll do
my best to read it in a timely fashion and approve it.

Note that this project is following [Semantic Versioning 2.0.0](http://semver.org/).

You like this project ? Fork it, star it, talk about it !

## Testing
In a (nut)shell

```bash
phpunit
```

## Credits
Maintainer : [dav-m85](http://github.com/dav-m85)

Contributors : you ?

## License
*json-db* uses the MIT license. A copy can be found inside the project, or at http://opensource.org/licenses/mit-license.php
