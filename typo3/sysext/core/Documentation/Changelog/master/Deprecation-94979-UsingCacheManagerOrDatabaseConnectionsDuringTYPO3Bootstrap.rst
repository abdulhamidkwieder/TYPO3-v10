.. include:: ../../Includes.txt

=======================================================================================
Deprecation: #94979 - Using CacheManager or Database Connections during TYPO3 bootstrap
=======================================================================================

See :issue:`94979`

Description
===========

TYPO3 now triggers a deprecation if extension authors
or site admins have code in their `ext_localconf.php`,
`Configuration/TCA/*` configuration files or `ext_tables.php`.

This is important for extension authors as TYPO3 will become
stricter in the future in terms of booting up TYPO3's Core Configuration, making typical requests much faster, as all
configuration can be cached away. When using TYPO3 in
a build environment, this will also lead to possibilities to
pre-warmup caches during the build phase of a new deployment.


Impact
======

Accessing the database and utilizing the Cache Manager in
these files will trigger a deprecation message.


Affected Installations
======================

TYPO3 installations with extensions using Cache Manager
or Database Connections.


Migration
=========

Use proper places to initialize extensions, and only when
needed to reduce the general time to boot up TYPO3's configuration.

.. index:: PHP-API, NotScanned, ext:core