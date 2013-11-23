# JsonDb

*Document oriented database using json files as storage. Usefull for small concurrency free apps.*

I wouldn't use it in heavy load environment if I were you.

## Quick Start

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

Pretty neat uh ?