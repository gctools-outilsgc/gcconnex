# update ssl certs
This is for any sites that don't have cert updates automated (gcpedia, gcconnex)

## generate csr
a certificate signing request needs to be generated and sent to the CA / provider / whoever is in contact with them

`openssl req -new -newkey rsa:2048 -nodes -out gcconnex.csr -keyout gcconnex.key`

## When you have the new cert, replace the old cert and key files
backing up the old cert files might not be a bad idea at least until the while process is done, also the intermediate and root certs are unlikely to change if they're already there
make sure the owner and permissions of the new files are the same as the old certs and the site config in /etc/apache2/sites-enabled/ is pointing at the new files.
restart apache2 and make sure everything's still working properly

## you might need to export a pfx file as well
https://stackoverflow.com/questions/6307886/how-to-create-pfx-file-from-certificate-and-private-key
