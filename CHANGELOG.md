# CHANGELOG

## 6.0.0

Initial release.

- (ADD) `Aura\Session_Interface\SessionInterface` — the minimal session-manager contract: `start()`, `resume()`, `regenerateId()`.
- (ADD) `Aura\Session_Interface\SegmentInterface` — the minimal segment contract: `get()`, `set()`.
- (ADD) `Aura\Session_Interface\ManageableSegmentInterface` — whole-segment management: `getSegment()`, `clear()`, `remove()`.
- (ADD) `Aura\Session_Interface\FlashSegmentInterface` — flash values: `setFlash()`, `getFlash()`, `clearFlash()`, `getFlashNext()`, `setFlashNow()`, `clearFlashNow()`, `keepFlash()`.

These interfaces are shared by `aura/session` (the full implementation) and
`aura/auth` (which needs only a light session); both depend on `^6.0`. PHP
8.1+ is required.
