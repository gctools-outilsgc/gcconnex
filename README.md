<h1>GCconnex & How to Install</h1>
This project is forked from Elgg<sup>[1](#fn1)</sup> by the Federal Government of Canada. This branch contains the main version of Elgg for 1.12 which is currently in development for future launch of the new GCconnex.

All dependencies is included in this branch for Elgg v1.12, please note that some modules are included as submodules<sup>[2](#fn2)</sup>, you may need to pull from submodule.


```
git submodule foreach git pull origin master
```


<sub><a name="fn1">1</a>: Elgg is an open source framework  for social networking and collaboration, for more information about Elgg visit http://elgg.org/ or see the original Elgg README below.</sub>

<sub><a name="fn2">2</a>: WET4 is currently in development to comply with the standards of UX within the Government</sub>

<h1>GCconnex branches explained</h1>
<strong>1.*</strong> - Older version of Elgg codebase

<strong>GCconnex</strong> - Codebase for main production copy of GCconnex, any changes made or additional functionality that is developed will be merged into this branch.

<strong>Staging</strong> - Pre release version used by TBS-SCT developers for development and testing

<strong>devel-*</strong> - Branches used by TBS-SCT developers

<strong>gcconnex-upgrade</strong> - Current (and future release) for GCconnex using Elgg v1.12

<h1>Elgg README</h1>

Elgg
Copyright (c) 2008-2015, see COPYRIGHT.txt

See CONTRIBUTORS.txt for development credits.

Elgg is managed by the Elgg Foundation, a nonprofit organization that was
founded to govern, protect, and promote the Elgg open source social network
engine.  The Foundation aims to provide a stable, commercially and
individually independent organization that operates in the best interest of Elgg
as an open source project.

The project site can be found at http://elgg.org/

The Elgg project was started in 2004 by:
Ben Werdmuller <ben@benwerd.com, http://benwerd.com> and
Dave Tosh <davidgtosh@gmail.com>

Elgg is released under the GNU General Public License (GPL) Version 2 and the
Massachusetts Institute of Technology (MIT) License. See LICENSE.txt 
in the root of the package you downloaded.

For installation instructions, see INSTALL.txt.

For upgrade instructions, see UPGRADE.txt.
