# Emergency PHP 5.6 runtime, 23 October 2026

The main `Dockerfile` retains this checkout's application sources and replaces
the PHP runtime with a local rebuild of the verified Ondřej Surý Ubuntu 22.04
source package, adding the two upstream OpenSSL hostname-verification fixes. No application
or database migration is included. The alternate Alpine/FPM Dockerfiles are not
covered by this patch.

Deployment developers should start with the
[deployment handoff](php56-deployment-handoff.md), including Azure rollout,
per-replica verification, integration acceptance and recovery instructions.

## Fixed inputs and dependency preservation

- Ubuntu 22.04 base index:
  `sha256:0a9887931b0e38af2e3487ed39e29436b0535c4f3f52e57745baaf79d1898956`.
- PHP source-package revision:
  `5.6.40-105+ubuntu22.04.1+deb.sury.org+1`, required exactly for the Apache
  module, CLI, common package, PHP metapackage and installed core extensions.
  The installed local rebuild adds the suffix `+gcconnex1`; the runtime gate
  requires this distinct full revision. `docker/runtime-packages.env` separately
  pins the PECL memcache extension. See
  [the OpenSSL follow-up](php56-openssl-followup.md) for source/build provenance.
- Dependency donor:
  `phanoix/gcconnex@sha256:fcea945fe594bd71a04f23c35b379064de89a038f492d3e05ed4b231cb536a1a`.
  Only `/var/www/html/vendor` and `/var/www/html/mod/pleio/vendor` are copied.
  Its older PHP, OS, settings and application files are never copied or run.

The previous Alpine builder omitted the root lockfile and resolved Pleio's
unlocked dependencies on every build. This emergency recipe runs no Composer
commands, preserving the donor's exact dependency artifacts instead. The root
`composer.json` and `composer.lock` remain unchanged. The partially tracked root
`vendor` directory was already excluded by `.dockerignore`; it is not a complete
installable dependency tree. The manifest contents do not
attest the donor's installed package versions: compare both vendor inventories
with the donor and record any existing difference from the root lockfile during
acceptance. Removing development dependencies or refreshing libraries is separate
work because either changes this emergency baseline.

The donor is the supplied Linux amd64 production artifact; build this candidate
with `--platform linux/amd64`. The recipe uses the current checkout for every
other application file, including bundled plugin dependencies, and retains the
existing Docker settings-file injection. It must not substitute the donor's
application tree for this checkout.

## Security evidence and startup setting

The supplier's [published source record](https://launchpad.net/~ondrej/+archive/ubuntu/php/+sourcepub/18893905)
identifies revision 105 for Jammy. Its Debian source archive has SHA-256
`e5932885bf735540f2e7a2b1a3523e4cfba172189fa512f6dc55efd005e9cbfe`.
The changelog records both CVE-2026-109618 and CVE-2026-109619 in revision 104;
`debian/patches/0261-Avoid-state-corruption-via-bailout.patch` names both and is
enabled in `debian/patches/series`. Revision 105 also backports CVE-2023-0662.
The local rebuild retains all supplier patches through 0264 and adds patch 0265
for CVE-2026-91767 and CVE-2026-91769. Source archives and the local patch are
hash-pinned; build dependencies and runtime dependencies use authenticated APT.
Unavailable inputs fail the build instead of falling back. Local rebuilt packages
are distinct from supplier binaries and are not supplier-endorsed releases.

PHP's [23 October follow-up](https://www.php.net/archive/2026.php#2026-10-23-1)
recommends disabling session upload progress pending a further fix for an
unusual serializer-switching configuration (CVE-2026-115560). This patch
conservatively disables it at startup. `docker/99-gcconnex-security.ini` sets
`session.upload_progress.enabled=0` before requests for both Apache and CLI.
The Apache virtual host also applies `php_admin_flag` so application
`.htaccess` configuration cannot re-enable it. This supplements the vendor
backports; it does not certify PHP 5.6 against all vulnerabilities.

## Build and acceptance

Build the candidate from this checkout:

```sh
docker buildx build --platform linux/amd64 --load \
  -t gcconnex:openssl-20261023 .
```

The build and entrypoint run `/usr/local/bin/gcconnex-check-runtime`. It requires
the exact installed package revisions, verifies CLI and Apache startup INI trees,
checks Apache configuration syntax and confirms the PHP 5 module is loaded.
It does not start Apache or establish the effective configuration in a running
web request. The complete build package inventory is retained at
`/usr/local/share/gcconnex-runtime/packages.tsv`.

Run the same gate independently without application initialization:

```sh
docker run --rm --entrypoint /usr/local/bin/gcconnex-check-runtime \
  gcconnex:openssl-20261023
```

Before deployment, acceptance must establish the effective Apache PHP setting,
required extensions, sessions and multipart uploads; bounded memory-exhaustion
worker exit/recovery; preservation of application source hashes and both donor
vendor trees; and absence of private investigation material in the image.
Application login, integrations and representative user journeys require a
separately restored, isolated environment. No public diagnostic endpoint should
be added to the application.

No live-production QA was performed. Local image checks do not establish the
state of deployed replicas or compatibility with live production integrations.

The Ubuntu base and dependency artifacts are digest-pinned, and PHP revisions
are exact. Other Ubuntu/PPA dependency packages still come from live signed APT
repositories, so the build is not bit-for-bit reproducible. Retain the final
image digest, package inventory and build evidence; archive authenticated
package artifacts separately if long-term rebuilds are required.

Deploy by immutable digest and replace every PHP/Apache worker, including any
ancillary PHP-serving image. Verify package revisions and the effective startup
setting in every replica. Record the full supplier package revision rather than
only the upstream version `5.6.40`; this supplier also includes its revision in
`PHP_VERSION`. The supplied donor runs older Focal
packages; do not reinstall Jammy packages into that Focal image or silently
restore an exposed vulnerable runtime during rollback. Restrict access while
resolving any failed rollout.

Check the deployed container memory limit explicitly: this checkout retains
`memory_limit=-1` in `.htaccess`, so PHP does not impose a per-request memory cap.
The local QA stack uses container memory limits; repository defaults alone do
not establish Azure's deployed limits.

Private security investigation reports are excluded by `.dockerignore` and must
remain untracked. Never include them in the image or pull request.

## Local acceptance evidence, 23 October 2026

The original revision-105 emergency candidate (before the OpenSSL local rebuild)
was built and tested with synthetic data, MySQL 5.6.51
and Solr 6.6.6. No production environment or production data was used.

- Installed PHP packages matched the exact revision-105 requirements. Apache's
  effective web SAPI reported that revision and disabled session upload progress,
  including inside the application's `.htaccess` scope. Required extensions loaded.
- Session persistence and multipart field/file handling passed; uploaded bytes
  matched their SHA-256. A bounded 32 MiB allocation against a 16 MiB PHP limit
  terminated the affected worker without invoking its shutdown callback; ten
  subsequent HTTP requests succeeded. This tests mitigation behavior, not every
  possible exploit path.
- 9,846 application/source files matched the checkout byte-for-byte, excluding
  existing Docker build omissions and the separately checked root vendor tree.
  All 2,766 files in the two donor dependency trees matched. No private report
  entered the image. The donor's installed root inventory differs from the
  repository lockfile in 14 entries; those existing differences were preserved.
- The existing core PHPUnit suite ran 371 tests and 1,164 assertions on both
  the supplied runtime and candidate, using the same current application source
  and donor dependencies. Both produced the same five `ElggAutoPTest` failures,
  with identical assertion differences, plus 20 skipped and 25 incomplete tests.
  The suite is not fully green; this comparison found no new failing cases.
- Sol 6.1 High autoreview reported no P0 findings. Actual build validation then
  identified and corrected a version-check assumption: the supplier appends its
  package revision to `PHP_VERSION`, so the engine check uses `PHP_VERSION_ID`
  while `dpkg` still verifies exact package revisions. The corrected build and
  runtime checks passed.

Browser workflow results are recorded separately from these runtime checks.
