<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace TYPO3\CMS\Core\Tests\Unit\Imaging;

use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Core\Exception;
use TYPO3\CMS\Core\Imaging\IconProvider\FontawesomeIconProvider;
use TYPO3\CMS\Core\Imaging\IconProviderInterface;
use TYPO3\CMS\Core\Imaging\IconRegistry;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test case
 */
class IconRegistryTest extends UnitTestCase
{
    use \Prophecy\PhpUnit\ProphecyTrait;
    /**
     * @var string
     */
    protected $notRegisteredIconIdentifier = 'my-super-unregistered-identifier';

    /**
     * @var FrontendInterface|ObjectProphecy
     */
    protected $cacheFrontendProphecy;

    public function setUp(): void
    {
        parent::setUp();
        $this->cacheFrontendProphecy = $this->prophesize(FrontendInterface::class);
        $this->cacheFrontendProphecy->get(Argument::cetera())->willReturn(false);
        $this->cacheFrontendProphecy->set(Argument::cetera())->willReturn(null);
    }

    /**
     * @test
     */
    public function getDefaultIconIdentifierReturnsTheCorrectDefaultIconIdentifierString()
    {
        $result = (new IconRegistry($this->cacheFrontendProphecy->reveal()))->getDefaultIconIdentifier();
        self::assertEquals('default-not-found', $result);
    }

    /**
     * @test
     */
    public function isRegisteredReturnsTrueForRegisteredIcon()
    {
        $subject = new IconRegistry($this->cacheFrontendProphecy->reveal());
        $result = $subject->isRegistered($subject->getDefaultIconIdentifier());
        self::assertTrue($result);
    }

    /**
     * @test
     */
    public function isRegisteredReturnsFalseForNotRegisteredIcon()
    {
        $result = (new IconRegistry($this->cacheFrontendProphecy->reveal()))->isRegistered($this->notRegisteredIconIdentifier);
        self::assertFalse($result);
    }

    /**
     * @test
     */
    public function registerIconAddNewIconToRegistry()
    {
        $unregisteredIcon = 'foo-bar-unregistered';
        $subject = new IconRegistry($this->cacheFrontendProphecy->reveal());
        self::assertFalse($subject->isRegistered($unregisteredIcon));
        $subject->registerIcon($unregisteredIcon, FontawesomeIconProvider::class, [
            'name' => 'pencil',
            'additionalClasses' => 'fa-fw'
        ]);
        self::assertTrue($subject->isRegistered($unregisteredIcon));
    }

    /**
     * @test
     */
    public function registerIconThrowsInvalidArgumentExceptionWithInvalidIconProvider()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode(1437425803);

        (new IconRegistry($this->cacheFrontendProphecy->reveal()))->registerIcon($this->notRegisteredIconIdentifier, GeneralUtility::class);
    }

    /**
     * @test
     */
    public function getIconConfigurationByIdentifierThrowsExceptionWithUnregisteredIconIdentifier()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionCode(1437425804);

        (new IconRegistry($this->cacheFrontendProphecy->reveal()))->getIconConfigurationByIdentifier($this->notRegisteredIconIdentifier);
    }

    /**
     * @test
     */
    public function getIconConfigurationByIdentifierReturnsCorrectConfiguration()
    {
        $result = (new IconRegistry($this->cacheFrontendProphecy->reveal()))->getIconConfigurationByIdentifier('default-not-found');
        // result must contain at least provider and options array
        self::assertArrayHasKey('provider', $result);
        self::assertArrayHasKey('options', $result);
        // the provider must implement the IconProviderInterface
        self::assertContains(IconProviderInterface::class, class_implements($result['provider']));
    }

    /**
     * @test
     */
    public function getAllRegisteredIconIdentifiersReturnsAnArrayWithIconIdentifiers()
    {
        self::assertIsArray((new IconRegistry($this->cacheFrontendProphecy->reveal()))->getAllRegisteredIconIdentifiers());
    }

    /**
     * @test
     */
    public function getAllRegisteredIconIdentifiersReturnsArrayWithAllRegisteredIconIdentifiers()
    {
        $result = (new IconRegistry($this->cacheFrontendProphecy->reveal()))->getAllRegisteredIconIdentifiers();
        self::assertIsArray($result);
        self::assertContains('default-not-found', $result);
    }

    /**
     * @test
     */
    public function getIconIdentifierForFileExtensionReturnsDefaultIconIdentifierForEmptyFileExtension()
    {
        $result = (new IconRegistry($this->cacheFrontendProphecy->reveal()))->getIconIdentifierForFileExtension('');
        self::assertEquals('mimetypes-other-other', $result);
    }

    /**
     * @test
     */
    public function getIconIdentifierForFileExtensionReturnsDefaultIconIdentifierForUnknownFileExtension()
    {
        $result = (new IconRegistry($this->cacheFrontendProphecy->reveal()))->getIconIdentifierForFileExtension('xyz');
        self::assertEquals('mimetypes-other-other', $result);
    }

    /**
     * @test
     */
    public function getIconIdentifierForFileExtensionReturnsImageIconIdentifierForImageFileExtension()
    {
        $result = (new IconRegistry($this->cacheFrontendProphecy->reveal()))->getIconIdentifierForFileExtension('jpg');
        self::assertEquals('mimetypes-media-image', $result);
    }

    /**
     * @test
     */
    public function registerFileExtensionRegisterAnIcon()
    {
        $subject = new IconRegistry($this->cacheFrontendProphecy->reveal());
        $subject->registerFileExtension('abc', 'xyz');
        $result = $subject->getIconIdentifierForFileExtension('abc');
        self::assertEquals('xyz', $result);
    }

    /**
     * @test
     */
    public function registerFileExtensionOverwriteAnExistingIcon()
    {
        $subject = new IconRegistry($this->cacheFrontendProphecy->reveal());
        $subject->registerFileExtension('jpg', 'xyz');
        $result = $subject->getIconIdentifierForFileExtension('jpg');
        self::assertEquals('xyz', $result);
    }

    /**
     * @test
     */
    public function registerMimeTypeIconRegisterAnIcon()
    {
        $subject = new IconRegistry($this->cacheFrontendProphecy->reveal());
        $subject->registerMimeTypeIcon('foo/bar', 'mimetype-foo-bar');
        $result = $subject->getIconIdentifierForMimeType('foo/bar');
        self::assertEquals('mimetype-foo-bar', $result);
    }

    /**
     * @test
     */
    public function registerMimeTypeIconOverwriteAnExistingIcon()
    {
        $subject = new IconRegistry($this->cacheFrontendProphecy->reveal());
        $subject->registerMimeTypeIcon('video/*', 'mimetype-foo-bar');
        $result = $subject->getIconIdentifierForMimeType('video/*');
        self::assertEquals('mimetype-foo-bar', $result);
    }

    /**
     * @test
     */
    public function getIconIdentifierForMimeTypeWithUnknownMimeTypeReturnNull()
    {
        $result = (new IconRegistry($this->cacheFrontendProphecy->reveal()))->getIconIdentifierForMimeType('bar/foo');
        self::assertNull($result);
    }
}
