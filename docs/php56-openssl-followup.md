# Local PHP 5.6 OpenSSL follow-up

The application's group-member lookup can use PHP's HTTPS stream wrapper, and
its PHPMailer notification path can negotiate SMTP STARTTLS. Both reach PHP's
built-in OpenSSL hostname checker when their runtime settings select TLS. These
are verified source call paths, not evidence of production settings or attacks.

The main Dockerfile rebuilds the full pinned supplier source with two narrow
upstream fixes, preserving application code, dependencies and the October PHP
security backports. The distinct installed package version is
`5.6.40-105+ubuntu22.04.1+deb.sury.org+1+gcconnex1`. This local build is maintained
by the application team; it is not a supplier-signed or supplier-endorsed release.

## Changes and sources

- CVE-2026-91767: [upstream fix](https://github.com/php/php-src/commit/78cc82b37a340840c6fbff676f513eb4e3d96533)
  includes both wildcard prefix and suffix in the length bound. The backport uses
  `size_t` lengths to avoid narrowing `strlen()` results.
- CVE-2026-91769: [upstream fix](https://github.com/php/php-src/commit/0bb308eb4cf699e707efbcf97ffb70e46a176be7)
  suppresses Common Name fallback when a DNS, URI or SRV service identity is
  present in subjectAltName and does not match. Legacy no-SAN and IP-only SAN
  compatibility follows the upstream fix; this is not a rewrite of TLS policy.
- Supplier patches 0261–0264 remain intact, including the October bailout,
  stale-state and multipart protections. Upload-progress disablement remains in
  both the source and startup/admin configuration.

The supplier's revision 105 remained the latest published Jammy package during
this investigation. Its hostname routines did not include these two fixes.
The retained source-only patch header records its research-stage status;
compilation and acceptance evidence are separate from that source handoff.

## Build and provenance

`docker/php56-source.sha256` pins the source descriptor, original archive and
Debian patch archive from the supplier publication linked in the emergency
runbook. The build verifies all three hashes before extraction. The `.dsc`
OpenPGP signature is not independently verified: the trust boundary is the
reviewed hash pins and HTTPS retrieval. APT still authenticates build/runtime
dependencies normally; no unauthenticated repository mode is enabled.

`docker/build-php56.sh` verifies the applied supplier hostname source hash,
imports the reviewed patch with zero fuzz, verifies the resulting source hash,
and builds the complete Debian source package with a local changelog entry.
The supplier's hardening and SAPI build rules are retained. Only the original
runtime package set is installed, including readline; unused FPM/CGI/SOAP
packages and build tools are not added to the application image. PECL memcache
keeps its separate supplier version. PHP copyright/license files are retained.

To preserve the rebuilt `.deb` files, exact local source package and build
metadata independently of the image, export the optional target:

```sh
docker buildx build --platform linux/amd64 --target php-artifacts \
  --output type=local,dest=../gcconnex-php-runtime-artifacts .
```

Keep this export outside a later Docker build context. The final image also
retains source pins, patch, changelog, build dependency inventory, binary-package
hashes and Debian build metadata under
`/usr/local/share/gcconnex-runtime/source-build/`.

Build dependency packages and timestamps are not frozen, so this is a traceable
source build, not a bit-for-bit reproducibility claim. Verify the final image's
CLI and Apache module package ownership, versions and hashes; package names
alone do not prove a source change was compiled. The startup gate rejects the
unmodified supplier revision when the local rebuild is expected.

## Acceptance boundaries

The supplier package workflow disables its PHP test suite. A successful package
build is therefore not a test-suite pass. Separate acceptance must cover ordinary
certificate trust/name matching, legitimate wildcards, SAN precedence, HTTPS
streams, bundled PHPMailer explicit/opportunistic STARTTLS, and the original
runtime/application checks. Never disable certificate verification to make an
integration pass. Servers with mismatched SANs that previously succeeded through
CN fallback must have their certificates corrected.

Crafted memory-corruption reproduction and sanitizer exploit tests are excluded
following an automated cybersecurity safeguard block. Ordinary compatibility
checks and source review do not substitute for those unperformed tests.

Other old PHP advisories remain outside this two-fix follow-up. PHP 5.6 is still
upstream end-of-life. Production integrations and all serving Azure replicas
must be verified after a separately approved deployment; no production test or
deployment has been performed by this local work.
