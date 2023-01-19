[![Build Status](https://travis-ci.org/zerai/albomon.svg?branch=master)](https://travis-ci.org/zerai/albomon)
[![Coverage Status](https://coveralls.io/repos/github/zerai/albomon/badge.svg?branch=%28no+branch%29)](https://coveralls.io/github/zerai/albomon?branch=%28no+branch%29)

[![](https://codescene.io/projects/6064/status.svg) Get more details at **codescene.io**.](https://codescene.io/projects/6064/jobs/latest-successful/results)

# AlboMON  -  AlboPOP Monitoring application


Console application per il monitoraggio dei feed RSS prodotti dal progetto [AlboPOP](https://albopop.it).

AlboMON valuta, e restituisce in output, i seguenti parametri:

- Feed Status: 'ATTIVO/NON ATTIVO'

- Spec. Status: 'Non Rilevato'  <- valore di default la feature è da implementare

- Content Update At: data di aggiornamento del feed ed il numero di giorni di ritarto esempio '2019-05-20  -53 gg.'

- Error: 'server error' indica problemi rigurdanti la rete (404 500 e simili). 


## Requisiti:
- PHP >=7.4



## Installazione:

$ git clone https://github.com/zerai/albomon.git

$ cd albomon/

$ composer install



## Documentazione e Comandi:

#### - scansione singolo feed:
$ php bin/console albomon:check:feed <http://www.mio-feed.com/feed.xml>


#### - scansione feed da catalogo personale:
$ php bin/console albomon:check:custom-catalog


#### - scansione feed da catalogo ufficiale AlboPOP:
$ php bin/console albomon:check:albopop-catalog

[NB.] Il catalogo ufficiale del progetto AlboPOP è reperibile in [questa pagina](https://albopop.it/comune/).


#### Gestione cataloghi:

Per aggiungere o rimuovere un feed dal catalogo personale modificare il file 'catalog/custom-catalog.json'.

Per aggiungere o rimuovere un feed dal catalogo ufficiale AlboPOP modificare il file 'catalog/albopop-catalog.json'.


#### Report:

L' applicazione genera un report in formato CSV, il file viene salvato nella directory 'report'.