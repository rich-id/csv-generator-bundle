# Translation

## Header

The annotation `RichId\CsvGeneratorBundle\Annotation\Header` adds a header to the serialized CSV at the first line of
the page. Some options are available within the annotation to easily setting up the translation :

| Key      | Type          | Default | Description |
|  ---     | ---           | ---     | --- |
| `keys`   | string[]      | `[]`    | Keys to used for the translation. If empty, the properties name will be used instead |
| `prefix` | string        | `''`    | Prefix to add before every keys |
| `domain` | `string|null` | `null`  | Translation domain to use |
| `locale` | `string|null` | `null`  | Translation locale to use |


Lets check an example with the CSV model class:

```php
use RichId\CsvGeneratorBundle\Annotation as CSV;

/**
 * @CSV\Header(
 *    prefix="header.dummy_csv_model.",
 *    locale="fr_FR"
 */
class DummyCsvModel
{
    public $firstEntry;
    public $secondEntry;
    public $thirdEntry;
}
```

And the following translations keys available:

```yaml
header.dummy_csv_model.firstEntry: 'First entry'
header.dummy_csv_model.secondEntry: 'Second entry'
header.dummy_csv_model.thirdEntry: 'Third entry'
```

The first line of the CSV would be the following:

```csv
First entry,Second entry,Third entry
```


## Property translation

The properties can also be dynamically translated using the `RichId\CsvGeneratorBundle\Annotation\Header` annotation.

| Key      | Type          | Default | Description |
|  ---     | ---           | ---     | --- |
| `prefix` | string        | `''`    | Prefix to add before the property value|
| `domain` | `string|null` | `null`  | Translation domain to use |
| `locale` | `string|null` | `null`  | Translation locale to use |


With an example, everything makes sense. Here is the CSV model:

```php
use RichId\CsvGeneratorBundle\Annotation as CSV;

class DummyCsvModel
{
    /** @CSV\Translate(prefix="content.dummy_csv_model.") */
    public $entry = 'default_value';
    
    public function __construct(?string $entry = null)
    {
        if ($entry !== null) {
            $this->entry = $entry;
        }
    }
}

$models = [
    new DummyCsvModel(),
    new DummyCsvModel('first_value'),
    new DummyCsvModel('second_value'),
];
```

And here the available translation keys:

```yaml
header.dummy_csv_model.default_value: 'The default one'
header.dummy_csv_model.first_value: 'A great value'
header.dummy_csv_model.second_value: 'Another value'
```

If the `$models` variable is serialized, then the output would be:

```csv
The default one
A great value
Another value
```
