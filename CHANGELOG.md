# Changelog

## Unreleased — verifikasi akhir PR-13–PR-22

- Added cancellation and expiry handling for unpaid orders, including stock restoration within a transaction and a manual migration file.
- Added cashier management for soft-deactivated product options, including reactivation and CSRF-protected POST actions.
- Added read-only export and evaluation support for paid database transactions; database results are written separately from synthetic ML artifacts.
- Added best-effort recommendation impression and selection logs without customer identity, a manual schema file, and an admin acceptance report by hour.
- Added PHPUnit unit coverage for checkout and payment rules, Flask client success/failure handling, and cashier denial by the admin role filter.
- Hardened configuration, documented the synthetic dataset limitations, and completed the PR-21 code audit.

### Verification notes

- `composer install --no-interaction --prefer-dist` completed; no packages changed. Composer reported PSR-4 warnings for legacy FPDF files in `app/ThirdParty/fpdf/`.
- `vendor/bin/phpunit -c phpunit.xml.dist --no-coverage` passed 10 tests and 14 assertions. The tests do not connect to an application database.
- Python ML generation/evaluation could not start because NumPy is not installed in `.venv`.
- Database migrations and manual web flows were not run. No release tag was created.

See [STATUS_PR-01-21.md](STATUS_PR-01-21.md) for per-PR completion details and remaining verification.
