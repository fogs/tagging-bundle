tagging-bundle
==============

Tag any entity in your Symfony2 project. This bundles takes care of the 
frontend using the jQuery Plugin from max-favilli/tagmanager and of the
backend using FabienPennequin/FPNTagBundle, which is a convenient 
wrapper around a Doctrine extension.

**Navigation**

1. [Installation](#installation)
2. [Making an entity taggable](#taggable-entity)
3. [Using Tags](#using-tags)

<a name="installation"></a>

## Installation

### Use Composer

You can either use composer to add the bundle :

``` sh
$ php composer.phar require max-favilli/tagmanager:dev-master
$ php composer.phar require fogs/tagging-bundle:@dev
```

Or you can edit your `composer.json` where you have to add the following:

    "require": {
        "max-favilli/tagmanager": "dev-master",
        "fogs/tagging-bundle":"@dev"
    }

### Setup the bundle

To start using the bundle, register it in your Kernel. This file is usually located at `app/AppKernel`:

    public function registerBundles()
    {
        $bundles = array(
            // ...
            new FPN\TagBundle\FPNTagBundle(),
            new Fogs\TaggingBundle\FogsTaggingBundle(),
        );
    )

(Do you know how to get rid of the line for FPNTagBundle()? Please tell me. Or better: fork & fix. Thanks.)

Activate the bundles configuration by adding an imports statement in your config. This file is usually located at `app/config/config.yml`:

``` yaml
imports:
	# ...
    - { resource: "@FogsTaggingBundle/Resources/config/config.yml" }
```

Add routes to this bundle. Only needed, if you plan to use typeahead. This file is usually located at `app/config/routing.yml`:

``` yaml
fogs_tag:
    resource: "@FogsTaggingBundle/Controller"
    type:     annotation
    prefix:   /
```

Dump all newly installed assets and update the database schema

``` sh
$ app/console assetic:dump
$ app/console doctrine:schema:update --force
```

Ensure that the bundle's CSS and JS files are loaded. Most likely you want to do that in your `app/Resources/views/base.html.twig`

``` twig
	<link rel="stylesheet" type="text/css" href="{{ asset('css/tagging.css') }}" />
	<script src="{{ asset('js/tagging-bundle.js') }}"></script>
```

Since the tagging.js relies on JQuery, the `<script>` tag must be somewhere after JQuery has been loaded.

### Setup an entity

In this example, we use the entity `Profile` - yours may of course have a different name.

``` php
use Fogs\TaggingBundle\Interfaces\Taggable;
use Fogs\TaggingBundle\Traits\TaggableTrait;
 
/**
 * Profile
 */
class Profile implements Taggable
{
	use TaggableTrait;
	
	// ...
}
```

Traits require PHP >5.4 - if you are not able to upgrade, you may also copy & paste the content of the TaggableTrait class into your entity instead of the `use TaggableTrait;`. However, baby seals die whenever you do that, so consider upgrading again.

Afterwards add a new input to the form builder of your entity:

``` php
class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ..
            ->add('tags', 'tags')
        ;
    }
```

Now you should be able to edit the entity and have tags available.

To access tags that are assigned, use the tags attribute of the entity. In a twig you could do this:

``` twig
	<ul>
	{% for key, value in profile.tags %}
	  <li>{{ value }}</li>
	{% endfor %} 
	</ul>
```
