<?php
/**
 *
 * This file is part of Aura for PHP.
 *
 * @license http://opensource.org/licenses/mit-license.php MIT
 *
 */
namespace Aura\Session_Interface;

/**
 *
 * The contract for the "flash" features of a session segment: values that are
 * available for the *next* request only, and/or the current one.
 *
 * This is intentionally separate from {@see SegmentInterface} so that
 * consumers that only need plain read/write access are not forced to depend
 * on flash behaviour.
 *
 * @package Aura.Session_Interface
 *
 */
interface FlashSegmentInterface
{
    /**
     *
     * Sets a flash value for the *next* request.
     *
     * @param string $key The key for the flash value.
     *
     * @param mixed $val The flash value itself.
     *
     */
    public function setFlash(string $key, mixed $val): void;

    /**
     *
     * Gets the flash value for a key in the *current* request.
     *
     * @param string $key The key for the flash value.
     *
     * @param mixed $alt An alternative value to return if the key is not set.
     *
     * @return mixed The flash value itself.
     *
     */
    public function getFlash(string $key, mixed $alt = null): mixed;

    /**
     *
     * Gets all the flash values for the *current* request.
     *
     * @return array All the flash values for the current request; empty when
     * there are none.
     *
     */
    public function getFlashAll(): array;

    /**
     *
     * Clears flash values for *only* the next request.
     *
     * @return null
     *
     */
    public function clearFlash(): void;

    /**
     *
     * Gets the flash value for a key in the *next* request.
     *
     * @param string $key The key for the flash value.
     *
     * @param mixed $alt An alternative value to return if the key is not set.
     *
     * @return mixed The flash value itself.
     *
     */
    public function getFlashNext(string $key, mixed $alt = null): mixed;

    /**
     *
     * Gets all the flash values for the *next* request.
     *
     * @return array All the flash values for the next request; empty when
     * there are none.
     *
     */
    public function getFlashNextAll(): array;

    /**
     *
     * Sets a flash value for the *next* request *and* the current one.
     *
     * @param string $key The key for the flash value.
     *
     * @param mixed $val The flash value itself.
     *
     */
    public function setFlashNow(string $key, mixed $val): void;

    /**
     *
     * Clears flash values for *both* the next request *and* the current one.
     *
     * @return null
     *
     */
    public function clearFlashNow(): void;

    /**
     *
     * Retains all the current flash values for the next request; values that
     * already exist for the next request take precedence.
     *
     * @return null
     *
     */
    public function keepFlash(): void;
}
