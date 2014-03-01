README
======

What is json-db
-----------------
*json-db* is a document oriented database using json files as storage. It is *not* concurrency proof, so I wouldn't use
it in heavy production environnements if I were you. Database's size is also a matter.

This said, *json-db* can proove usefull in some cases.

Requirements
------------

gnu make, php5.3, prophecy

Usage
------------

Copy config.ini.dist to config.ini, and setup the correct key values (you need a github API access token).
```bash
make build
```

```php
use JsonDb\JsonDb;
    use JsonDb\JsonCollection;

    $db = new JsonDb('somewhere/in/your/filesystem');

    // Lets get a collection

    $test = $db->getCollection('test');
    $test = $db->test; // That's the same

    // Insert something
    $something = array('foo' => 'bar');
    $test->insert($something); // Adds a _id to $something, mongo style.

    // Get all documents
    $all = $test->find();

    // Get one or more documents with condition
    $some = $test->find(array('foo' => 'bar')); // That's a And condition

    // Update a record
    $something['aze'] = 'rty';
    $test->update($something);

    // If you want to update insert, use save
    $test->save($something);

    // When you're done, drop the collection erases it all.
    $test->drop();
```

Contributing
------------

You can contribute in various ways :

*Report bugs* in the projects "issues" section. Please make sure you know how to report one, general understanding of [this
document](http://www.chiark.greenend.org.uk/~sgtatham/bugs.html) could help ;)

You want to *fix a bug* ? Take an issue or fill one, assign yourself on it and when done, submit a Pull Request. I'll do
my best to read it in a timely fashion and approve it.

Note that this project is following [Semantic Versioning 2.0.0](http://semver.org/).

You like this project ? Fork it, star it, talk about it !

Testing
----------------------

In a (nut)shell :
```bash
make test
```

Credits
-------
Maintainer : [dav-m85](http://github.com/dav-m85)
Contributors : you ?

License
-------
*json-db* uses the MIT license. A copy can be found inside the project, or at http://opensource.org/licenses/mit-license.php