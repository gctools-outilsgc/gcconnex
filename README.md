
# GCconnex and GCcollab
GCconnex (GC only, now decommissioned) and [GCcollab](https://gccollab.ca/) are a professional networking and collaborative workspaces for all Canadian public servants, academics and post-secondary students, as well as partners by invitation. They allow people to connect and share information, leveraging the power of networking towards a more effective and efficient public service.

It features dynamic online communities where public servants can collaborate on projects, blog, carry on discussions, ask and answer each other's questions about anything from learning to technology. It acts as a professional platform to create your professional C.V., share ideas and connect you with people and information that you need.

GCconnex and GCcollab are based on [Elgg](https://github.com/Elgg/Elgg).

## Dev installation using docker compose

Developers can use [docker compose](https://docs.docker.com/compose/) to
quickly setup a development environment.

### Prerequisites

* [docker](https://www.docker.com)
* [docker compose](https://docs.docker.com/compose/)

### Getting started

> The apache process inside Docker will need write access to the project's root
> directory, and the "engine" directory.  ```chmod o+w . && chmod o+w engine```

Start by cloning the git repo; then change into the repo's root directory and
use docker compose to start/create your containers.

    docker compose up

and add an entry for ```<host ip> gcconnex.local``` in your hosts file.
Then visit [http://gcconnex.local](http://gcconnex.local) which should by now be a fully set up dev environment.
An admin account is created: Username: "admin"  Password: "adminpassword".
If E2E_TEST_INIT is set to true (it is by default in docker-compose.yml), a non-admin user is also created: Username: "Haibun"  Password: "Haibun".

### GCcollab / GCconnex
Since GCconnex has been decommissioned, by default the docker-compose.yml is now configured to initialize a gccollab instance, this is controlled by the INIT environment variable used in the [docker_installer script](https://github.com/gctools-outilsgc/gcconnex/blob/README-cleanup-update/install/cli/docker_installer.php). Changing this after installation will not do anything, to initialize the other site type the persisted DB data in ./data/ will need to be cleared.

## Contributing

We welcome your contributions. Create Issues for bugs or feature requests. Submit your pull requests.

## License

GNU General Public License (GPL) Version 2

Elgg Copyright (c) 2008-2016, see COPYRIGHT.txt

-------------------------------------------------------------------

# GCconnex et GCcollab

GCconnex (GC seulement) and [GCcollab](https://gccollab.ca/) sont des espaces de travail collaboratif pour tous les fonctionnaires, universitaires et étudiants de niveau postsecondaire canadiens, ainsi que des partenaires sur invitation. Ils permettent aux personnes de se connecter et de partager des informations et tirer profit du pouvoir de réseautage pour accroître l'efficacité et la productivité de la fonction publique.

On y retrouve plusieurs communautés en ligne où les employés peuvent collaborer à des projets, tenir des blogues, tenir des discussions, poser des questions et obtenir des réponses sur des sujets aussi variés que l’apprentissage et la technologie. C'est une plateforme professionnel ou vous pouvez créer votre C.V, échanger des idées et vous connecter avec des gens et les information dont vous avez besoin.

GCconnex et GCcollab sont basés sur [Elgg](https://github.com/Elgg/Elgg).

## Utilisation de Docker

Les développeurs peuvent utiliser
[docker compose](https://docs.docker.com/compose/) pour rapidement établir un
environnement de développement.

### Logiciels requis

* [Docker](https://www.docker.com)
* [Docker compose](https://docs.docker.com/compose/)

### Pour commencer

> Le serveur apache qui fonctionne dans Docker aura besoin d'ecrire dans le dossier
> principale et le dossier "engine".  ```chmod o+w . && chmod o+w engine```

Commencez avec le téléchargement du code source de github, ensuite dans ceci
utilisez `docker compose` pour démarrer et/ou créer vos conteneurs Docker.

    docker compose up

et ajouter un ligne ```<host ip> gcconnex.local``` a votre ficher "hosts".
Ensuite, visitez [http://gcconnex.local](http://gcconnex.local).

### GCcollab / GCconnex

## Contribuer

Nous vous invitons à contribuer.  Créez des billets (Issues) pour des problèmes ou demander des nouvelles fonctionnalités.  Envoyez vos modification (Pull request).

## Licence

GNU General Public License (GPL) Version 2

Elgg Copyright (c) 2008-2016, voir COPYRIGHT.txt
