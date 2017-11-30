
# GCconnex

[![Build Status](https://secure.travis-ci.org/gctools-outilsgc/gcconnex.svg?branch=gcconnex)](https://travis-ci.org/gctools-outilsgc/gcconnex)
[![Join the chat at https://gitter.im/gctools-outilsgc/gcconnex](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/gctools-outilsgc/general?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/gctools-outilsgc/gcconnex/badges/quality-score.png?b=gcconnex)](https://scrutinizer-ci.com/g/gctools-outilsgc/gcconnex/?branch=gcconnex)
[![Code Coverage](https://scrutinizer-ci.com/g/gctools-outilsgc/gcconnex/badges/coverage.png?b=gcconnex)](https://scrutinizer-ci.com/g/gctools-outilsgc/gcconnex/?branch=gcconnex)

GCconnex is a professional networking and collaborative workspace for all Canadian public service, allowing people to connect and share information, leveraging the power of networking towards a more effective and efficient public service.

It features dynamic online communities where public servants can collaborate on projects, blog, chat via instant messaging, carry on discussions, ask and answer each other's questions about anything from learning to technology. It acts as a professional platform to create your professional C.V., share ideas and connect you with people and information that you need.

GCconnex is based on Elgg. https://github.com/Elgg/Elgg

## Installation

Follow instructions in [INSTALL.md](INSTALL.md)

## Using Docker

Developers can use [docker-compose](https://docs.docker.com/compose/) to
quickly setup a development environment.

### Prerequisites

* [docker](https://www.docker.com)
* [docker-compose](https://docs.docker.com/compose/)

### Getting started

> The apache process inside Docker will need write access to the project's root
> directory, and the "engine" directory.  ```chmod o+w . && chmod o+w engine```

Start by cloning the git repo; then change into the repo's root directory and
use docker-compose to start/create your containers.

    docker-compose up

Then visit [http://localhost:8080](http://localhost:8080) and follow the
instructions to complete your installation.  Once the installer is complete,
refer to [INSTALL.md](INSTALL.md#configure-plugins) to configure the plugins
required by GCconnex.

Alternatively, you can use the automated install script which will run the regular install as well as installing and rearanging the gcconnex mods:

    docker exec -it gcconnex_gcconnex_1 php install/cli/docker_installer.php

### Docker specific configuration

On the `Database installation` page, use the following settings:

| Parameter             | Value         |
| --------------------- | ------------- |
| Database Username     | elgg          |
| Database Password     | gcconnex      |
| Database Name         | elgg          |
| Database Host         | gcconnex-db   |
| Database Table Prefix | elgg_         |

On the `Configure site` page, set the `Data Directory` to `/data`.

## Contributing

We welcome your contributions. Create Issues for bugs or feature requests. Submit your pull requests.

## License

GNU General Public License (GPL) Version 2

Elgg Copyright (c) 2008-2016, see COPYRIGHT.txt

-------------------------------------------------------------------

# GCconnex

GCconnex est un espace de travail collaboratif pour le réseautage professionnel à l'ensemble de la fonction publique Canadienne. Celle-ci vous permet de vous brancher, de partager de l'information et tirer profit du pouvoir de réseautage pour accroître l'efficacité et la productivité de la fonction publique.

On y retrouve plusieurs communautés en ligne où les employés peuvent collaborer à des projets, tenir des blogues, clavarder au moyen de la messagerie instantanée, tenir des discussions, poser des questions et obtenir des réponses sur des sujets aussi variés que l’apprentissage et la technologie. C'est une plateforme professionnel ou vous pouvez créer votre C.V, échanger des idées et vous connecter avec des gens et les information dont vous avez besoin.

GCconnex est basé sur Elgg. https://github.com/Elgg/Elgg

## Installation

Suivez les instructions dans [INSTALL.md](INSTALL.md)

## Utilisation de Docker

Les développeurs peuvent utiliser
[docker-compose](https://docs.docker.com/compose/) pour rapidement établir un
environnement de développement.

### Logiciels requis

* [Docker] (https://www.docker.com)
* [Docker-compose] (https://docs.docker.com/compose/)

### Pour commencer

> Le serveur apache qui fonctionne dans Docker aura besoin d'ecrire dans le dossier
> principale et le dossier "engine".  ```chmod o+w . && chmod o+w engine```

Commencez avec le téléchargement du code source de github, ensuite dans ceci
utilisez `docker-compose` pour démarrer et/ou créer vos conteneurs Docker.

    docker-compose up

Ensuite, visitez [http://localhost:8080](http://localhost:8080) et suivre les
instructions pour compléter votre installation.  Une fois complet, regarder à
[INSTALL.md](INSTALL.md#configure-plugins) et suivez les étapes additionnels.

### Configuration spécifique avec Docker

Sur la page `Database installation`, utilisez les paramètres suivants:

| Paramètre             | Valeur        |
| --------------------- | ------------- |
| Database Username     | elgg          |
| Database Password     | gcconnex      |
| Database Name         | elgg          |
| Database Host         | gcconnex-db   |
| Database Table Prefix | elgg_         |

Sur la page `Configure site`, `Data Directory` sera `/var/data`.

## Contribuer

Nous vous invitons à contribuer.  Créez des billets (Issues) pour des problèmes ou demander des nouvelles fonctionnalités.  Envoyez vos modification (Pull request).

## Licence

GNU General Public License (GPL) Version 2

Elgg Copyright (c) 2008-2016, voir COPYRIGHT.txt
