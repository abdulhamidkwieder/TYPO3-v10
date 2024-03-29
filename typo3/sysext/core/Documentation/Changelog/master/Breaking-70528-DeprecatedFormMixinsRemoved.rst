.. include:: ../../Includes.txt

=================================================
Breaking: #70528 - Deprecated form mixins removed
=================================================

See :issue:`70528`

Description
===========

The deprecated ext:form setup mixins from :yaml:`TYPO3.CMS.Form.mixins.*` have been removed.

Impact
======

Form setup inheriting mixins from :yaml:`TYPO3.CMS.Form.mixins.*` will not work properly anymore.

Affected Installations
======================

All installations using the deprecated form setup mixins are affected.

Migration
=========

Embed the essential parts from :yaml:`TYPO3.CMS.Form.mixins.*` or migrate them to custom mixins.

.. index:: Backend, Frontend, NotScanned, ext:form
