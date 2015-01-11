#! /usr/bin/env python3

import json
import subprocess
import urllib.request


# Put passwords for IsoHunt's remote services in sphinx's config file
URL = 'http://isohunt.to/openbay/config.json'
CFG_FILE = '/etc/sphinxsearch/sphinx.conf'


if __name__ == '__main__':
    # the default User-Agent ‘Python-urllib/«version»’ gets 403 Forbidden
    req = urllib.request.Request(URL, headers={
        'User-Agent': 'openbay',
        })
    with urllib.request.urlopen(req) as f:
        data = json.loads(f.read().decode('utf-8'))
    db_data = data['components']['db']
    for placeholder, key in (
            ('YOUR_MYSQL_HOST', 'host'),
            ('YOUR_MYSQL_USERNAME', 'user'),
            ('YOUR_MYSQL_PASSWORD', 'password'),
            ('YOUR_MYSQL_DATABASE', 'name'),
            ('YOUR_MYSQL_PORT', 'port'),
            ):
        value = db_data[key]
        print('setting', placeholder, value)
        subprocess.check_call(['sed',
            '-e', 's+{}+{}+'.format(placeholder, value),
            '-i', CFG_FILE])
