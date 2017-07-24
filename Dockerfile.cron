FROM ubuntu:14.04
MAINTAINER Luc Belliveau <luc.belliveau@nrc-cnrc.gc.ca>

# Install dependencies
RUN apt-get update
RUN apt-get install -y wget

# Add a copy of crontab example to the image
COPY ./docs/examples/crontab.example /opt/crontab.example

# Install the Elgg crontab
RUN sed -i 's/www.example.com/gcconnex/' /opt/crontab.example
RUN sed -i 's/lwp-request/wget/' /opt/crontab.example
RUN sed -i 's/\$LWPR -m GET -d/\/usr\/bin\/wget --output-document=\/dev\/null --spider/' /opt/crontab.example
RUN crontab /opt/crontab.example

WORKDIR /var/www/html

# Start the cron daemon in the foreground
CMD cron -f
