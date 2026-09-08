# Aura.Session_Interface

Light-weight, framework-agnostic interfaces for session managers and session
segments. These interfaces let packages depend on *the contract* of a session
without pulling in a full session implementation.

They are used by:

- [Aura.Session](https://github.com/auraphp/Aura.Session), which provides the
  full-featured implementation; and
- [Aura.Auth](https://github.com/auraphp/Aura.Auth), which only needs a very
  light session to work independently, but can also accept an Aura.Session
  instance directly because both speak these interfaces.

## Installation

```bash
composer require aura/session-interface
```

This package has no dependencies other than PHP `^8.4`.

## Interfaces

The segment contract is split into three interfaces by capability, following
the interface-segregation principle, so a consumer depends only on what it
actually uses.

### `Aura\Session_Interface\SessionInterface`

The minimal contract for a session manager:

| Method                     | Purpose                              |
|----------------------------|--------------------------------------|
| `start(): bool`            | Start a new session.                 |
| `resume(): bool`           | Resume a previously-started session. |
| `regenerateId(): bool`     | Regenerate the session ID.           |

### `Aura\Session_Interface\SegmentInterface`

The minimal contract for reading and writing values in a session segment:

| Method                              | Purpose                           |
|-------------------------------------|-----------------------------------|
| `get(string $key, $alt): mixed`     | Read a value (or an alternative). |
| `set(string $key, $val): void`      | Write a value.                    |

### `Aura\Session_Interface\ManageableSegmentInterface`

The contract for managing a segment as a whole:

| Method                          | Purpose                                       |
|---------------------------------|-----------------------------------------------|
| `getSegment(): mixed`           | Read the entire segment.                      |
| `clear(): void`                 | Empty the segment.                            |
| `remove(?string $key): void`    | Remove one key, or the whole segment if null. |

### `Aura\Session_Interface\FlashSegmentInterface`

The contract for "flash" values (available for the next request, and/or the
current one): `setFlash()`, `getFlash()`, `getFlashAll()`, `clearFlash()`,
`getFlashNext()`, `getFlashNextAll()`, `setFlashNow()`, `clearFlashNow()`, and
`keepFlash()`.

The two all-getters return every flash value for the current or the next
request, so a consumer can render them without knowing the keys in advance;
both return an empty array when there is nothing set.

Each of these is a separate interface so that consumers that only read and
write plain values do not have to depend on whole-segment management or flash
behaviour. A full implementation simply composes the ones it needs — for
example Aura.Session's own `SegmentInterface` extends all three:

```php
namespace Aura\Session;

use Aura\Session_Interface\SegmentInterface as BaseSegmentInterface;
use Aura\Session_Interface\ManageableSegmentInterface;
use Aura\Session_Interface\FlashSegmentInterface;

interface SegmentInterface extends
    BaseSegmentInterface,
    ManageableSegmentInterface,
    FlashSegmentInterface
{
}
```

## Why a separate package?

By extracting these interfaces into their own zero-dependency package, a
consumer such as Aura.Auth can type-hint against `SessionInterface` and
`SegmentInterface` and:

- ship a tiny built-in implementation for standalone use, **and**
- transparently accept a full `Aura\Session\Session` / segment when one is
  available,

without either package depending on the other.
