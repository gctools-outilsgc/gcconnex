# Emergency PHP runtime deployment handoff

For the developers operating GCcollab/GCconnex on Azure. This is a runtime-image
replacement, with no application change or database migration. Production has
not been inspected or deployed by this work. Keep public access disabled until
the deployment owner completes and records the checks below.

Read this alongside the [runtime runbook](php56-runtime-emergency.md) and
[OpenSSL build provenance](php56-openssl-followup.md).

## 1. Confirm the actual deployment

Record the release owner, approved source commit, Azure environment, registry,
namespace, workload names, container names and image digests in your internal
release ticket. Do not put credentials or environment dumps in the public PR.

- Confirm whether this is AKS/Kubernetes. The commands below are Kubernetes
  examples; use the equivalent image-promotion and instance-verification steps
  for another Azure service. No production resource names are assumed here.
- Use the root `Dockerfile`, Linux **amd64**, and an amd64 node pool. Alternate
  Alpine/FPM Dockerfiles are outside this patch. Confirm that the deployed
  application source corresponds to the reviewed checkout before promotion.
- Inventory every workload that executes PHP, including web replicas, separate
  workers, Jobs and CronJobs. An HTTP-only cron caller does not itself run PHP,
  but its destination must be patched. Check all applicable namespaces.
- Preserve the existing database, uploads/data volume, site URL, settings,
  secrets, session configuration, CA certificates and integration configuration.
  Verify restore procedures/backups. Do not recreate databases or delete PVCs.
- Inspect mounts and command overrides: mounts over `/var/www/html`, PHP/Apache
  configuration or executables can hide the patched image's contents. Preserve
  necessary settings/data mounts, and verify that they do not replace the
  security INI or Apache `php_admin_flag`. Run the new image entrypoint; a
  Kubernetes `command` override can bypass its runtime gate.
- Leave `INIT` **unset** and `E2E_TEST_INIT` unset in deployed application pods.
  The existing start script treats any nonempty `INIT`, including `0`, as a
  request to invoke the installer. Do not run the installer or seed local QA
  accounts against an existing deployment.
- Confirm pod/container memory limits, readiness/startup probes, ingress upload
  limits and termination behavior. Application `.htaccess` retains
  `memory_limit=-1`; choose container limits from your existing capacity policy.

The checked-in `kubernetes/gcconnex-kube.yaml` is an old test example, including
database resources; **do not apply it wholesale to production**. The repository's
development Compose stack enables installation/test fixtures and is also not a
production rollout template. Adapt the team's current manifests/Helm/GitOps
configuration instead.

## 2. Build, preserve and publish the release artifact

Run in a clean checkout of the approved release commit, through the team's build
pipeline. The build needs the pinned donor image, Ubuntu/PPA dependencies and
supplier source archives. Missing pins must fail; do not loosen versions or
replace the donor to make the build pass. Keep exports outside the build context.

Example Bash commands, with the registry/repository and unique release tag set
by the deployment team:

```bash
GC_IMAGE_REPOSITORY='REPLACE.azurecr.io/REPLACE/gcconnex'
GC_RELEASE_TAG='REPLACE-with-unique-release-tag'
GC_RELEASE_IMAGE="${GC_IMAGE_REPOSITORY}:${GC_RELEASE_TAG}"

docker buildx build --platform linux/amd64 --load \
  --file Dockerfile --tag "$GC_RELEASE_IMAGE" .

docker run --rm --entrypoint /usr/local/bin/gcconnex-check-runtime \
  "$GC_RELEASE_IMAGE"

docker buildx build --platform linux/amd64 --target php-artifacts \
  --output type=local,dest=../gcconnex-php-runtime-artifacts .

# After normal registry authentication, using the team's release identity:
docker push "$GC_RELEASE_IMAGE"
docker buildx imagetools inspect "$GC_RELEASE_IMAGE"
```

Record the registry manifest digest from the push/inspection and use
`registry/repository@sha256:...` for deployment. A local Docker image ID is not
that registry digest. Promote the **same digest** from staging to production;
do not rebuild between environments. If using the artifact export, keep the
same builder/cache and verify exported package hashes against the image's
`/usr/local/share/gcconnex-runtime/source-build/` metadata. Separate uncached
builds can differ because dependency repositories and timestamps are not frozen.

Retain the commit, registry digest, package inventory, exported source/packages,
build log and acceptance evidence in the team's release storage. The exact
required PHP package revision is:

```text
5.6.40-105+ubuntu22.04.1+deb.sury.org+1+gcconnex1
```

Seeing only `PHP 5.6.40` is insufficient. This is a locally maintained backport,
not a supplier-endorsed release. The source descriptor's signature was not
independently verified; see the provenance document for the hash/HTTPS trust
boundary and normally authenticated APT dependencies.

## 3. Deploy and validate in staging

Use isolated staging data and approved test identities/mail recipients. Configure
the real integration types, DNS names and trusted CAs without sending test
notifications to ordinary users. Use the team's normal deployment pipeline. If
it permits direct Kubernetes changes, the equivalent Deployment example is:

```bash
GC_CONTEXT='REPLACE-staging-context'
GC_NAMESPACE='REPLACE-namespace'
GC_DEPLOYMENT='REPLACE-deployment'
GC_CONTAINER='REPLACE-php-container'
GC_IMAGE_DIGEST='REPLACE.azurecr.io/REPLACE/gcconnex@sha256:REPLACE'

kubectl --context "$GC_CONTEXT" -n "$GC_NAMESPACE" set image \
  "deployment/$GC_DEPLOYMENT" "$GC_CONTAINER=$GC_IMAGE_DIGEST"
kubectl --context "$GC_CONTEXT" -n "$GC_NAMESPACE" rollout status \
  "deployment/$GC_DEPLOYMENT" --timeout=10m
```

Do not run imperative changes against a GitOps-managed deployment; update its
source of truth instead. Repeat the image update for other PHP workload
templates. A Deployment rollout does not update CronJobs or already-running
Jobs; handle these through their owners so no old PHP process survives or starts
later. Preserve scheduled work and prevent duplicate execution.

For **each** new pod/container, record its actual image ID, readiness/restarts,
and runtime-gate result. Select the pod explicitly, not a Deployment alias that
can inspect just one arbitrary replica:

```bash
GC_POD='REPLACE-one-pod-at-a-time'
kubectl --context "$GC_CONTEXT" -n "$GC_NAMESPACE" get pod "$GC_POD" \
  -o jsonpath='{range .status.containerStatuses[*]}{.name}{"\t"}{.imageID}{"\tready="}{.ready}{"\trestarts="}{.restartCount}{"\n"}{end}'
kubectl --context "$GC_CONTEXT" -n "$GC_NAMESPACE" exec "$GC_POD" \
  -c "$GC_CONTAINER" -- /usr/local/bin/gcconnex-check-runtime
```

The actual platform manifest digest can differ from a registry index digest;
verify it belongs to the approved amd64 artifact, rather than comparing unlike
digest types. The gate checks exact packages and startup configuration. It does
**not** prove the effective settings of an Apache request or integration health.

Complete this acceptance checklist and save results:

| Check | Required evidence |
| --- | --- |
| Effective web runtime | An operator-only HTTP check through Apache, in the application's directory/configuration scope, reports `apache2handler`, the full local PHP revision and `session.upload_progress.enabled` disabled (`0` or empty/false). Check every serving replica. CLI output alone is insufficient. |
| Diagnostic handling | Use an internal QA harness or a temporary loopback-only Apache diagnostic path denied at ingress and to external clients. Return only version/SAPI/required settings; never expose `phpinfo()`, secrets or configuration dumps. Remove it and verify it is inaccessible before reopening. |
| Normal application use | Login/logout, sessions, bilingual content creation/editing, upload and exact-byte download succeed. Check normal language switching on the real hostname; it was blocked on local loopback. |
| Private access | An owner/member can retrieve private content and downloads; an unauthenticated user/nonmember cannot. |
| Authentication | Actual configured SSO/identity provider login and return URL work with approved test accounts. |
| Email/TLS | Password-reset/notification delivery to approved test recipients succeeds using the configured SMTP host, CA and TLS mode. Where STARTTLS is required, establish that TLS was negotiated; delivery alone is not proof. |
| Other integrations | HTTPS group lookup and enabled external integrations work with their actual DNS names/trust stores. Keep certificate/name verification enabled. Correct invalid SAN certificates; do not restore CN fallback or disable verification. |
| Operations | Upload sizes/timeouts, health probes, container memory limits, restarts/OOM events and relevant Apache/application logs meet the team's acceptance criteria. Check search/indexing and scheduled tasks where used. |

## 4. Promote and reopen

1. Record staging acceptance and the deployment owner's approval. Keep the
   public maintenance/access restriction active while replacing production.
2. Promote the exact staged digest through the approved production pipeline;
   preserve existing configuration and data. Update all PHP-serving/executing
   workloads and future Job/CronJob templates.
3. Verify all desired replicas are ready, all old pods/processes are gone, and
   every PHP container passes the package gate and effective web checks above.
   Confirm load-balancer backends serve only the approved replicas.
4. Run controlled production smoke checks with approved test users/recipients:
   login/SSO, upload/download, private access and SMTP/external TLS integrations.
   Remove diagnostic resources and retain redacted evidence.
5. The deployment owner decides whether to reopen, accounting for the separately
   reported application vulnerabilities. Monitor errors, restarts/OOM events,
   failed logins, uploads and integrations after reopening.

Do not describe this as an upgrade to PHP 8 or a guarantee that the whole site
is secure. The accurate claim is that the deployed artifact contains the named
backports and upload-progress mitigation, once that artifact is verified on all
relevant workloads. PHP 5.6 remains end-of-life.

## 5. If rollout or acceptance fails

Keep or restore the public access restriction. Preserve logs and data, stop
promotion, and investigate the failed gate/integration. Do not bypass the runtime
gate, relax version pins or disable certificate verification. Do not blindly use
`kubectl rollout undo`: its previous revision may contain the vulnerable PHP
runtime. Restore only a separately verified patched artifact/configuration; if
none exists, remain offline while repairing the candidate. No schema migration
is introduced, so this patch itself does not require a database rollback.

## Local evidence handed over

The tested executable candidate is based on commit
`7881c90b77d9c8318db72f009b9777b6ef365208`, local image ID
`sha256:5e332540e21a73c2b41a4986adf3452885565418333412d34e988d7b83d59978`.
Later handoff documentation does not change runtime code; a release build from
the final approved commit still needs the staging acceptance above.

- Ordinary TLS checks: candidate **144/144**, baseline **108/144**. The 36
  corrected outcomes concern SAN/Common Name fallback; these are checks, not
  36 separate vulnerabilities. Actual Apache/mod_php: **8/8**.
- Runtime settings, extensions, sessions, multipart uploads and worker recovery
  passed. Application/source and donor vendor contents were preserved.
- Final-image browser regression passed with 20 screenshots, including private
  content and owner/member download hashes. Local language-switch and production
  integration limitations are stated above.
- Repository PHPUnit configuration: 387 tests, 1,243 assertions, the same five
  failures on baseline and candidate, 20 skipped and 25 incomplete. Not an
  entirely green suite. P0–P2 review found no actionable issues in runtime changes.
- Crafted memory-corruption/sanitizer reproduction was not performed after an
  automated safeguard block. Other PHP advisories and application-level security
  fixes are outside this emergency scope.

Build logs, detailed QA reports, screenshots and source/package exports are
retained by the PR author for internal handoff. They are not public repository
attachments. Obtain them through the team's approved channel; do not publish
private investigation reports or local fixture credentials with this PR.
