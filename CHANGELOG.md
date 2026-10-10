# Changelog

## [13.1.0] - 2026-10-10

### Added

- `ParticipantJoined` is now dispatched from `addParticipant()`, `createGroup()` and `createChannel()`.
- `createChannel()` accepts optional initial `$memberIds` and runs in a transaction.
- `ConversationRead` aggregated event; `markConversationAsRead()` no longer fires one `MessageRead` per message.
- `Chat::editMessage()` and `Chat::getSubscribableChannels()`.
- `InvalidParticipantException`.

### Changed

- `directTo()` throws `InvalidParticipantException` for self-chat and now sends `$message` into an existing conversation.
- `removeParticipant()` throws `InvalidParticipantException` for non-members.
- `addParticipant()` re-activates a participant who previously left.
- `Conversation::scopeForUser()` ignores participants with `left_at` set.
- `createGroup()` normalizes and de-duplicates member ids.

## [13.0.0] - 2026-07-08

### Added

- Laravel 13 support (dedicated release line).

### Changed

- Minimum PHP version raised to 8.3.
- Illuminate packages now require `^13.0`.
- Pest upgraded to `^3.0|^4.0` for Laravel 13 test tooling.

### Notes

- For Laravel 10-12, continue using the `^2.0` release line.
