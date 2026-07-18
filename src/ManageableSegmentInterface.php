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
 * The contract for managing a session segment as a whole: reading the entire
 * segment, clearing it, and removing keys (or the whole segment).
 *
 * This is intentionally separate from {@see SegmentInterface} so that
 * consumers that only read and write individual values are not forced to
 * depend on whole-segment management (interface segregation).
 *
 * @package Aura.Session_Interface
 *
 */
interface ManageableSegmentInterface
{
    /**
     *
     * Returns the entire segment.
     *
     * @return mixed
     *
     */
    public function getSegment(): mixed;

    /**
     *
     * Clears all data from the segment.
     *
     * @return void
     *
     */
    public function clear(): void;

    /**
     *
     * Removes a key from the segment, or removes the entire segment (including
     * key) from the session.
     *
     * @param string|null $key The key to remove, or null to clear the entire
     * segment.
     *
     * @return void
     *
     */
    public function remove(?string $key = null): void;
}
