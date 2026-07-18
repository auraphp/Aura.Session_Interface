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
 * The minimal contract for a session manager.
 *
 * This is the light-weight surface that packages such as Aura.Auth need in
 * order to work with a session without depending on a full session
 * implementation.
 *
 * @package Aura.Session_Interface
 *
 */
interface SessionInterface
{
    /**
     *
     * Starts a new session.
     *
     * @return bool
     *
     */
    public function start(): bool;

    /**
     *
     * Resumes a previously-started session, if one is available.
     *
     * @return bool
     *
     */
    public function resume(): bool;

    /**
     *
     * Regenerates the session ID.
     *
     * @return bool
     *
     */
    public function regenerateId(): bool;
}
