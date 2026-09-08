# CHANGELOG

## 7.0.0-beta2

- (ADD) `Aura\Session_Interface\FlashSegmentInterface` gains `getFlashAll()` and `getFlashNextAll()`, which return every flash value for the current or the next request, so consumers can render flash messages without knowing the keys. Neither takes an alternative value, and both return an empty array when nothing is set.
- (BRK) Implementations written against `7.0.0-beta1` must add those two methods.

## 7.0.0-beta1

Initial release.

- (ADD) `Aura\Session_Interface\SessionInterface` — the minimal session-manager contract: `start()`, `resume()`, `regenerateId()`.
- (ADD) `Aura\Session_Interface\SegmentInterface` — the minimal segment contract: `get()`, `set()`.
- (ADD) `Aura\Session_Interface\ManageableSegmentInterface` — whole-segment management: `getSegment()`, `clear()`, `remove()`.
- (ADD) `Aura\Session_Interface\FlashSegmentInterface` — flash values: `setFlash()`, `getFlash()`, `clearFlash()`, `getFlashNext()`, `setFlashNow()`, `clearFlashNow()`, `keepFlash()`.

These interfaces are shared by `aura/session` (the full implementation) and
`aura/auth` (which needs only a light session); both depend on `^7.0`. PHP
8.4+ is required.
