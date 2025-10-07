# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## 1.2.2 (2025-10-07)

### Changed

- Switch from strings to true/false for the `hide_settings` option
- Display the version number in the settings

### Security

- Update `cross-spawn` to >=7.0.5
- Update `tmp` to >=0.2.3

## 1.2.1 (2024-07-26)

### Fixed

- Moved the block removal to `wp.blocks.unregisterBlockType` for better handling

## 1.2.0 (2024-06-20)

### Added

- Removes all comment related blocks

### Fixed

- Commitlint works with v19

### Improved

- UI layout

## 1.1.0 (2024-02-28)

### Added

- Settings page

### Improved

- Hide all comment-options from dashboard
- Security

## 1.0.0 (2024-02-27)

### Added

- Initial Release
