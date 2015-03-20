Features
======================
This bundle provides you with:

- reason to move on from php 5.3
- code base of 1k+ lines including 25+ phpspec examples
- symfony2 security configuration
- symfony2 security configuration for partially protected sites
- symfony2 firewall
- User entity for Doctrine ORM
- login controller
- login template
- login event logger

Issues and feature requests are tracked in the Github [issue tracker]https://github.com/unknown-opensource/user-light/issues.

Installation
======================

1. To install this bundle with Composer, just add the following to your composer.json file:


    require: {
        ...
        "unknown/user-light": "1.0.4"
    }

2. Then register the bundle in AppKernel::registerBundles()


    $bundles = array(
        ...
        new Unknown\Bundle\ReportBundle\UnknownUserLightBundle(),
    );

3. Include security configuration.


    imports:
        - { resource: @UnknownUserLightBundle/Resources/config/security.yml }


Custom User Entity
======================

To assign custom user entity for firewall use bundle configuration.

Partial bundle configuration:

    unknown_user_light:
        user_entity_class: Acme\CustomBundle\Entity\User


Custom Login Event Logging
======================

To store login events in database supply record class in bundle configuration. Supplied class should implement Unknown\Bundle\UserLightBundle\Entity\LoginRecordInterface interface.

Partial bundle configuration:

    unknown_user_light:
        login_record_class: Acme\CustomBundle\Entity\LoginRecord


Custom Login Theme
======================

Default bundle configuration looks for ::login.html.twig template. However, there is already provided template which can
be used by configuring bundle with following:

    unknown_user_light:
        login_template: UserLightBundle::login.html.twig

