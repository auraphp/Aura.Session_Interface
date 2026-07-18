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
 * The minimal contract for a session segment: read and write values.
 *
 * This is the light-weight surface that packages such as Aura.Auth rely on.
 * Richer segment features (flash values, clearing, removal, etc.) are defined
 * in separate interfaces so that consumers only depend on what they use.
 *
 * @package Aura.Session_Interface
 *
 */
interface SegmentInterface
{
    /**
     *
     * Returns the value of a key in the segment.
     *
     * @param string $key The key in the segment.
     *
     * @param mixed $alt An alternative value to return if the key is not set.
     *
     * @return mixed
     *
     */
    public function get(string $key, mixed $alt = null): mixed;

    /**
     *
     * Sets the value of a key in the segment.
     *
     * @param string $key The key to set.
     *
     * @param mixed $val The value to set it to.
     *
     */
    public function set(string $key, mixed $val): void;
}
